<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // 1. Validate the submitted data
        $data = $request->validate([
            'F_name' => ['required', 'string', 'max:255'],
            'L_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // 2. Create the account
        User::create([
            'name' => $data['F_name'] . ' ' . $data['L_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'Staff',
        ]);

        // 3. Redirect to login after registration
        return redirect()->route('login')
            ->with('success', 'Registration successful! You can now log in.');
    }
}
