<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StoreOwnerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $store = auth()->user()->store()
            ->where('status', 'approved')
            ->latest()
            ->first();


        $products = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->where('products.store_id', $store->id)
            ->select('products.name as product', DB::raw('SUM(order_items.total_price) as total'))
            ->groupBy('products.name')
            ->orderByDesc('total')
            ->pluck('total', 'product');

        $productlabel = $products->keys();   // ['Product A', 'Product B']
        $productkeys = $products->values(); // [1000, 850]

        $earnings = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->where('products.store_id', $store->id)
            ->select(
                DB::raw("DATE_FORMAT(MIN(order_items.created_at), '%M') as month"),
                DB::raw("SUM(order_items.total_price) as total")
            )
            ->groupBy(DB::raw("MONTH(order_items.created_at)"))
            ->orderBy(DB::raw("MIN(order_items.created_at)"))
            ->pluck('total', 'month');

        $earninglabel = $earnings->keys();  // e.g. ['January', 'February']
        $earningvalues = $earnings->values(); // e.g. [1200, 900]


        $monthlyEarnings = 0;
        $yearlyEarnings = 0;
        $totalProducts = 0;
        $pendingOrders = 0;


        $monthlyEarnings = DB::table('order_items')
            ->whereIn('product_id', function ($query) use ($store) {
                $query->select('id')->from('products')->where('store_id', $store->id);
            })
            ->whereMonth('created_at', now()->month)
            ->sum('total_price');

        // Yearly Earnings
        $yearlyEarnings = DB::table('order_items')
            ->whereIn('product_id', function ($query) use ($store) {
                $query->select('id')->from('products')->where('store_id', $store->id);
            })
            ->whereYear('created_at', now()->year)
            ->sum('total_price');

        // Total Products
        $totalProducts = $store->products()->count();

        // Pending Orders (assuming order_items have a status)
        $orders = OrderItem::whereIn('product_id', function ($query) use ($store) {
            $query->select('id')->from('products')->where('store_id', $store->id);
        })->with('order')
            ->where('status', 'pending')
            ->get();

        $pendingOrders = $orders->count();


        return view('store.dashboard.index', compact(
            'earninglabel',
            'earningvalues',
            'productlabel',
            'productkeys',
            'monthlyEarnings',
            'yearlyEarnings',
            'totalProducts',
            'pendingOrders',
            'orders',
        ));
    }

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
        //
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
}
