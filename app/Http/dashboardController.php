<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ingredient;
use App\Models\PurchaseRequest;
use App\Models\InventoryActivity;

class DashboardController extends Controller
{
    public function index()
    {
        $totalIngredients = Ingredient::count();

        $lowStockItems = Ingredient::whereColumn('quantity', '<=', 'min_quantity')->get();
        $lowStockCount = $lowStockItems->count();

        $pendingRequestsCount = PurchaseRequest::where('status', 'pending')->count();

        $expiringSoonCount = Ingredient::whereBetween('expiration_date', [now(), now()->addDays(7)])->count();

        $recentActivities = InventoryActivity::latest()->take(5)->get();

        return view('dashboard', compact(
            'totalIngredients',
            'lowStockCount',
            'pendingRequestsCount',
            'expiringSoonCount',
            'lowStockItems',
            'recentActivities'
        ));
    }

    public function ingredientsIndex(Request $request)
    {
        $query = Ingredient::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category') && $request->category !== 'All categories') {
            $query->where('category', $request->category);
        }

        $ingredients = $query->paginate(10);
        $categories = Ingredient::select('category')->distinct()->pluck('category');

        return view('ingredients', compact('ingredients', 'categories'));
    }

    public function storeIngredient(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'quantity' => 'required|integer|min:0',
            'min_quantity' => 'required|integer|min:0',
            'supplier' => 'nullable|string|max:255',
            'expiration_date' => 'nullable|date',
        ]);

        Ingredient::create($request->all());

        return redirect()->back()->with('success', 'Ingredient added successfully!');
    }
}