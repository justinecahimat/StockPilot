<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ingredient;

class IngredientController extends Controller
{
    public function index(Request $request)
    {
        $query = Ingredient::query();

        // Search by keyword
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter by category
        if ($request->filled('category') && $request->category !== 'All categories') {
            $query->where('category', $request->category);
        }

        $ingredients = $query->paginate(10);
        $categories = Ingredient::select('category')->distinct()->pluck('category');

        return view('ingredients', compact('ingredients', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'unit' => 'required|string|max:50',
            'quantity' => 'required|integer|min:0',
            'min_quantity' => 'required|integer|min:0',
            'supplier' => 'nullable|string|max:255',
            'expiration_date' => 'nullable|date',
            'notes' => 'nullable|string|max:1000',
        ]);

        Ingredient::create($request->all());

        return redirect()->back()->with('success', 'Ingredient added successfully!');
    }
}