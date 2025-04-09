<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\User;
use App\Notifications\StoreRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class RegisterstoreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $store = Store::updateOrCreate(
            [
                'user_id' => auth()->user()->id, // condition to find existing store
            ],
            [
                'category_id' => $request->category_id,
                'name' => $request->name,
                'description' => $request->description,
            ]
        );


        $user = User::role('super-admin')->get();
        Notification::send($user, new StoreRequest($store, auth()->user()->name));
        return redirect()->back()->with('success', 'Store request submitted successfully.');
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
