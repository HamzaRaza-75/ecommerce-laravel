<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\User;
use App\Notifications\StoreRequest;
use Illuminate\Http\Request;

class AdminUtilsController extends Controller
{
    public function approvestore(Request $request)
    {
        $store = Store::findOrFail($request->storeid);
        $store->update([
            'status' => 'approved',
        ]);

        $user = User::findOrFail($store->user_id);
        $user->assignRole('store-owner');
        $user->notify(new StoreRequest($store, $user->name));

        return redirect()->back()->with('success', 'Store has been approved successfully');
    }


    public function rejectstore(Request $request)
    {
        $store = Store::findOrFail($request->storeid);
        $store->update([
            'status' => 'rejected',
        ]);
        $user = User::findOrFail($store->user_id);
        $user->notify(new StoreRequest($store, $user->name));

        return redirect()->back()->with('success', 'Store has been rejected successfully');
    }

    public function blockuser(Request $request)
    {
        User::findOrFail($request->id)->update([
            'status' => 'blocked',
        ]);

        return redirect()->back()->with('success', 'User has been blocked successfully');
    }

    public function unblockuser(Request $request)
    {
        User::findOrFail($request->id)->update([
            'status' => 'active',
        ]);

        return redirect()->back()->with('success', 'User has been unblocked successfully');
    }

    public function readnotification()
    {
        auth()->user()->unreadNotifications->markAsRead();

        return redirect()->back()->with('success', 'Marked all notifications as read');
    }
}
