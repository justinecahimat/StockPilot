<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StockIn;
use App\Models\Ingredient;
use App\Models\Supplier;

class StockInController extends Controller
{
    public function create()
    {
        $ingredients = Ingredient::all();
        $suppliers = Supplier::all();

        return view('stock_in', compact('ingredients', 'suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ingredient' => 'required|string',
            'quantity' => 'required|numeric|min:0.01',
            'supplier' => 'nullable|string',
            'unit_cost' => 'nullable|numeric|min:0',
            'expiration_date' => 'nullable|date',
            'reference_number' => 'nullable|string|max:255',
        ]);

        // Save stock-in record
        StockIn::create([
            'ingredient' => $request->ingredient,
            'quantity' => $request->quantity,
            'supplier' => $request->supplier,
            'unit_cost' => $request->unit_cost,
            'expiration_date' => $request->expiration_date,
            'reference_number' => $request->reference_number,
        ]);

        // Automatically update/increment the ingredient quantity in inventory
        $ingredient = Ingredient::where('name', $request->ingredient)->first();
        if ($ingredient) {
            $ingredient->quantity += $request->quantity;
            if ($request->filled('supplier')) {
                $ingredient->supplier = $request->supplier;
            }
            if ($request->filled('expiration_date')) {
                $ingredient->expiration_date = $request->expiration_date;
            }
            $ingredient->save();
        }

        return redirect()->route('ingredients.index')->with('success', 'Stock-In recorded successfully and inventory updated!');
    }
}