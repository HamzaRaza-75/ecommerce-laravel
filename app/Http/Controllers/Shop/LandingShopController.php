<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class LandingShopController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with(['category'])->inRandomOrder()->limit(9)->get();
        return view("shop.index", compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function allShop(Request $request)
    {
        $request->validate([
            'category_id' => 'nullable|exists:categories,id',
            'sort_by' => 'nullable|string',
            'price_range' => 'nullable|string',
        ]);

        $productsQuery = Product::query()
            ->with(['category']) // eager load category if needed
            // ->withCount(['orderitems as sold_count'])
            ->withAvg('reviews', 'rating'); // average rating

        // Filter by category
        if ($request->filled('category_id')) {
            $productsQuery->where('category_id', $request->category_id);
        }

        // Filter by price range
        if ($request->filled('price_range')) {
            $range = $request->price_range;
            if (strpos($range, '-') !== false) {
                [$min, $max] = explode('-', $range);
                $productsQuery->whereBetween('price', [(float)$min, (float)$max]);
            } elseif ($range === '200+') {
                $productsQuery->where('price', '>=', 200);
            }
        }

        // Sorting
        switch ($request->sort_by) {
            case 'popularity':
                $productsQuery->orderByDesc('sold_count');
                break;
            case 'rating':
                $productsQuery->orderByDesc('ratings_avg_rating');
                break;
            case 'newest':
                $productsQuery->orderByDesc('created_at');
                break;
            case 'price_asc':
                $productsQuery->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $productsQuery->orderBy('price', 'desc');
                break;
            default:
                $productsQuery->latest();
                break;
        }

        $products = $productsQuery->paginate(15);
        $categories = Category::has('products')->get();

        return view('shop.product', compact('products', 'categories'));
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::with(['reviews' => ['user'], 'category'])
            ->withCount('reviews')
            ->findOrFail($id);

        $moreproducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->limit(8)
            ->get();

        return view('shop.productdetail', compact('product', 'moreproducts'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function aboutshop()
    {
        return view('shop.aboutstore');
    }
}
