<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    
    public function register(Request $request)
    {
        // 1. Receive the submitted form data
        $F_name = $request->input('F_name');
        $L_name = $request->input('L_name');
        $email = $request->input('email');
        $password = $request->input('password');

        // 2. Validate the data
        $data = $request->validate([
            'F_name' => ['required', 'string', 'max:255'],
            'L_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        // 3. Insert the data into the users table
        \App\Models\User::create([
            'name' => $F_name . ' ' . $L_name,
            'email' => $email,
            'password' => \Illuminate\Support\Facades\Hash::make($password),
        ]);

        // 4. Redirect after successful registration
        return redirect('/login')
            ->with('success', 'Registration successful!');
    }

}
