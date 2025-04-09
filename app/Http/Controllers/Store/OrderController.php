<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{

    public function index()
    {
        $storeManagerId = auth()->user()->id;

        $orders = OrderItem::whereHas('product', function ($query) use ($storeManagerId) {
            $query->where('seller_id', $storeManagerId); // assuming 'user_id' is the owner/store manager
        })->with(['product', 'order.user'])->paginate(10);
        return view('store.orders.index', compact('orders'));
    }

    /**
     * Show details of a single order.
     */
    public function show($id)
    {
        $order = Order::findOrFail($id);
        return view('orders.show', compact('order'));
    }

    /**
     * Show the form to create a new order.
     */
    public function create()
    {
        return view('orders.create');
    }

    /**
     * Store a new order.
     */
    public function store(string $id)
    {

        DB::beginTransaction();

        try {
            $orderitem = OrderItem::findOrFail($id);
            $orderitem->update([
                'status' => 'proceeded',
            ]);
            $product = $orderitem->product;

            $order = $orderitem->order;

            $allProceeded = $order->orderItems()->where('status', '!=', 'proceeded')->doesntExist();

            if ($allProceeded) {
                $order->update([
                    'status' => 'completed',
                ]);
            }

            $product->update([
                'stock' => $product->stock - $orderitem->quantity,
            ]);
            DB::commit();
        } catch (\Exception $e) {

            throw new Exception($e->getMessage());
            DB::rollBack();
        }



        return redirect()->route('store.orders.index')->with('success', 'Order has been procceeded successfully.');
    }

    /**
     * Show the edit form for an order.
     */
    public function edit($id)
    {
        $order = Order::findOrFail($id);
        return view('orders.edit', compact('order'));
    }

    /**
     * Update the order status.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled',
        ]);

        $order = Order::findOrFail($id);
        $order->update(['status' => $request->status]);

        return redirect()->route('orders.index')->with('success', 'Order updated successfully.');
    }

    /**
     * Delete an order.
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->route('orders.index')->with('success', 'Order deleted successfully.');
    }

    /**
     * Respond to an order (custom action).
     */
    public function respond(Request $request, $id)
    {
        $request->validate([
            'response' => 'required|string',
        ]);

        $order = Order::findOrFail($id);
        $order->update(['response' => $request->response]);

        return redirect()->route('orders.show', $id)->with('success', 'Response sent successfully.');
    }
}
