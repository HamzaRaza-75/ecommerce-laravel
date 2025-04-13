<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Retrieve all products with their associated store, category, and seller data
        $products = Product::with(['store', 'category'])->withCount(['reviews', 'wishlists'])->where('seller_id', auth()->user()->id)->paginate(10);
        return view('store.items.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // You might need to pass additional data to the view, like categories and stores.
        $categories = Category::all();
        return view('store.items.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate incoming request data
        $validated = $request->validate([
            'category_id'  => 'required|exists:categories,id',
            'name'         => 'required|unique:products|string|max:255',
            'description'  => 'nullable|string',
            'product_image' => 'nullable|image|dimensions:ratio=1',
            'price'        => 'required|numeric',
            'stock'        => 'required|integer',
        ]);

        // Handle file upload if provided
        if ($request->hasFile('product_image')) {
            $file = $request->file('product_image');
            $imagePath = uploadImage($file, 'products');
        }

        // Create the product using the validated data
        $product = Product::create([
            'seller_id'    => auth()->user()->id,
            'store_id'     => auth()->user()->store->id,
            'category_id'  => $request->category_id,
            'name'         => $request->name,
            'description'  => $request->description,
            'product_image' => $imagePath,
            'price'        => $request->price,
            'stock' => $request->stock,
        ]);

        return redirect()->route('store.product.index')
            ->with('success', 'Product has been added to your store successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::findOrFail($id);
        Gate::authorize('update', $product);
        // Eager load user (belongsTo) and orderitems.order (hasMany through)

        // Paginate related orderitems with their order
        $orderItems = $product->orderitems()->with('order.user')->paginate(10);



        $earnings = DB::table('order_items')
            ->where('product_id', $product->id)
            ->select(
                DB::raw("DATE_FORMAT(created_at, '%M') as month"), // e.g. January
                DB::raw("SUM(total_price) as total")
            )
            ->groupBy(DB::raw("MONTH(created_at), DATE_FORMAT(created_at, '%M')"))
            ->orderBy(DB::raw("MIN(created_at)"))
            ->pluck('total', 'month');

        $earningLabels = $earnings->keys();     // ['January', 'February', ...]
        $earningValues = $earnings->values();

        return view('store.items.view', compact('product', 'orderItems', 'earningLabels', 'earningValues'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        // You might want to pass additional data to the view (e.g., categories, stores)
        Gate::authorize('update', $product);
        $categories = Category::all();
        return view('store.items.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        // Validate incoming request data
        Gate::authorize('update', $product);

        $validated = $request->validate([
            'category_id'  => 'required|exists:categories,id',
            'name'         => 'required|string|max:255|unique:products,name,' . $product->id,
            'description'  => 'nullable|string',
            'product_image' => 'nullable|image',
            'price'        => 'required|numeric',
            'stock'        => 'required|integer',
        ]);

        // Handle file upload if provided
        if ($request->hasFile('product_image')) {
            // Delete old image if it exists
            if ($product->product_image) {
                Storage::delete('public/' . $product->product_image);
            }

            $file = $request->file('product_image');
            $imagePath = uploadImage($file, 'products');
        } else {
            $imagePath = $product->product_image;
        }

        // Update product with validated data
        $product->update([
            'seller_id'    => auth()->user()->id,
            'store_id'     => auth()->user()->store->id,
            'category_id'  => $request->category_id,
            'name'         => $request->name,
            'description'  => $request->description,
            'product_image' => $imagePath, // ✅ Directly use $imagePath
            'price'        => $request->price,
            'stock'        => $request->stock,
        ]);

        return redirect()->route('store.product.index')
            ->with('success', 'Product has been updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        Gate::authorize('update', $product);

        $product->update(['status' => 'inactive']);
        return redirect()->route('store.product.index')
            ->with('success', 'Product deleted successfully.');
    }
}
