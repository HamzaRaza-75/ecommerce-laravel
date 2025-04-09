<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole("client");

        Auth::login($user);

        // IMPORTANT: Return the redirect response!
        return $this->redirectToDashboard();
    }

    public function redirectToDashboard()
    {
        $user = auth()->user();

        // Define the prioritized roles
        $priorityRoles = ['super-admin', 'store-owner', 'client'];
        // Get the first matching role from the user's roles
        $role = $user->getRoleNames()->intersect($priorityRoles)->first();

        // Use match to return the appropriate redirect response based on the role
        return match ($role) {
            'super-admin' => redirect()->route('superadmin.dashboard'),
            'store-owner' => redirect()->route('storeowner.dashboard'),
            'client'      => redirect()->route('dashboard'),
            default       => redirect()->route('home'),
        };
    }



    public function roles()
    {
        $roles = ['super-admin', 'store-owner', 'client'];

        foreach ($roles as $role) {
            Role::firstOrCreate([
                'name' => $role,
                'guard_name' => 'web', // Specify the guard name
            ]);
        }

        $user = User::create([
            'name' => "admin",
            'email' => "admin123@gmail.com",
            'password' => Hash::make("admin123"),
        ]);

        // Assign role using guard name
        $assignrole = Role::findByName('super-admin', 'web');
        $user->assignRole($assignrole);

        return redirect()->back();
    }
}
