<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        $pendingCount = User::where('status', 'pending')->count();

        return view('users.index', compact(
            'users',
            'pendingCount'
        ));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['required', Rule::in(['Admin', 'Staff'])],
        ]);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
            'status' => 'approved',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        return redirect()->route('users.index')
            ->with('success', 'User account created successfully.');
    }

    public function approve(int $id)
    {
        $user = User::findOrFail($id);

        if (strtolower($user->role) !== 'staff') {
            return back()->with('error', 'Only Staff accounts can be approved.');
        }

        if ($user->status !== 'pending') {
            return back()->with('error', 'This account is not pending approval.');
        }

        $user->update([
            'status' => 'approved',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        return back()->with('success', 'Staff account approved successfully.');
    }

    public function reject(int $id)
    {
        $user = User::findOrFail($id);

        if (strtolower($user->role) !== 'staff') {
            return back()->with('error', 'Only Staff accounts can be rejected.');
        }

        if ($user->status !== 'pending') {
            return back()->with('error', 'This account is not pending approval.');
        }

        $user->update([
            'status' => 'rejected',
        ]);

        return back()->with('success', 'Staff registration rejected.');
    }

    public function destroy(int $id)
    {
        $user = User::findOrFail($id);

        if ($user->id === Auth::id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        if (strtolower($user->role) === 'admin') {
            $adminCount = User::whereRaw('LOWER(role) = ?', ['admin'])->count();

            if ($adminCount <= 1) {
                return back()->with('error', 'You cannot delete the last Admin account.');
            }
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully.');
    }
}
