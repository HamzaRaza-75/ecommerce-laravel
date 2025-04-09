<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Binafy\LaravelCart\Models\CartItem;
use \Binafy\LaravelCart\Models\Cart;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cart = Cart::query()->firstOrCreate(['user_id' => auth()->user()->id]);
        // dd($cart);
        return view('shop.cart', compact('cart'));
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create(string $id)
    // {
    //     $product = Product::findOrFail($id);

    //     $cart = Cart::query()->firstOrCreate(['user_id', auth()->user()->id]); // Automatically handles per-user cart

    //     $cartItem = new CartItem([
    //         'itemable_id' => $product->id,
    //         'itemable_type' => $product::class,
    //         'quantity' => $request->quantity,
    //     ]);

    //     return redirect()->back();
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $id)
    {
        $product = Product::findOrFail($id);

        $cart = Cart::query()->firstOrCreate(['user_id' => auth()->user()->id]); // Automatically handles per-user cart

        $cartItem = new CartItem([
            'itemable_id' => $product->id,
            'itemable_type' => $product::class,
            'quantity' => $request->quantity,
            'price' => $product->price,
            'total_price' => $request->quantity * $product->price,
        ]);

        $cart->items()->save($cartItem);

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function update(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'quantities.*' => 'required|integer|min:1|max:10', // Ensure quantities are between 1 and 10
        ]);

        // Get the current user's cart
        $cart = Cart::where('user_id', auth()->user()->id)->latest()->first();

        // If cart doesn't exist, redirect or return error
        if (!$cart) {
            return redirect()->route('shop.cart.index')->with('error', 'No cart found');
        }

        // Loop through the updated quantities and update each item
        foreach ($validated['quantities'] as $cartItemId => $quantity) {
            // Find the cart item by ID
            $cartItem = CartItem::where('id', $cartItemId)->where('cart_id', $cart->id)->first();

            if ($cartItem) {
                // Update the quantity and total price
                $cartItem->update([
                    'quantity' => $quantity,
                    'total_price' => $quantity * $cartItem->itemable->price, // Assuming price is a property on the related item
                ]);
            }
        }

        // Redirect back to the cart page with a success message
        return redirect()->route('shop.cart.index');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cartItem = CartItem::findOrFail($id)->delete();
        return redirect()->back();
    }
}
