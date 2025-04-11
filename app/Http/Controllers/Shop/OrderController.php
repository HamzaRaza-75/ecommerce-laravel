<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Binafy\LaravelCart\Models\Cart;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $orders = Order::where('user_id', auth()->user()->id)->status($request->status)
            ->dateRange($request->from, $request->to)
            ->latest()
            ->paginate(10);

        return view('shop.orderindex', compact('orders'));
    }

    // Show single order details

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd("yes request is comming");
        $request->validate([
            'phone_number' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:100',
        ]);

        $user = User::findOrFail(auth()->user()->id);

        $cart = Cart::query()->firstOrCreate(['user_id' => $user->id]);
        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->back()->with('error', 'Your cart is empty.');
        }

        DB::beginTransaction();

        try {
            // 1. Generate unique order number
            // dd("i am reached here");
            $orderNum = 'ORD-' . strtoupper(Str::random(8));

            // 2. Calculate total
            $totalAmount = 0;
            foreach ($cart->items as $item) {
                $totalAmount += $item->quantity * $item->itemable->price;
            }

            // dd($totalAmount);
            // 3. Create order
            $order = $user->orders()->create([
                'order_num' => $orderNum,
                'status' => 'pending',
                'total_amount' => $totalAmount,
            ]);

            // 4. Save order items
            foreach ($cart->items as $item) {
                $order->orderitems()->create([
                    'product_id' => $item->itemable->id,
                    'quantity' => $item->quantity,
                    'product_price' => $item->itemable->price,
                    'total_price' => $item->quantity * $item->itemable->price,
                ]);
            }

            // 5. Save shipping info (assuming you have a shipping table or on orders table)
            $user->userdetail()->updateOrCreate(
                ['user_id' => $user->id], // Match condition
                [
                    'phone_number' => $request->phone_number,
                    'address' => $request->address,
                    'city' => $request->city,
                    'state' => $request->state,
                    'postal_code' => $request->postal_code,
                    'country' => $request->country,
                ]
            );

            // 6. Empty the cart
            $cart->emptyCart();

            // dd("here we have runn everything great");

            DB::commit();

            return redirect()->route('shop.orders.show', ['id' => $order->id])->with('success', 'Order placed successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Checkout failed. ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) // send him a returning id
    {
        $order = Order::with('orderitems.product')->findOrFail($id);
        return view('shop.trackorder', compact('order'));
        // return view('shop.trackorder');
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

    public function reviewstore(Request $request, Product $product)
    {
        $user = auth()->user();

        $alreadyReviewed = Review::where('user_id', $user->id)->where('product_id', $product->id)->exists();

        if ($alreadyReviewed) {
            return back()->with('error', 'You have already reviewed this product.');
        }

        $orderItem = OrderItem::where('product_id', $product->id)
            ->where('status', 'proceeded')
            ->whereHas('order', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })->first();

        if (!$orderItem) {
            return back()->with('error', 'You need to purchase this product before reviewing.');
        }

        Review::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'order_item_id' => $orderItem->id,
            'comment' => $request->comment,
            'rating' => $request->rating,
        ]);

        return back()->with('success', 'Thank you for your review!');
    }
}
