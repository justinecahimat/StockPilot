<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StockOut;
use App\Models\Ingredient;
use App\Models\InventoryActivity;

class StockOutController extends Controller
{
    public function create()
    {
        $ingredients = Ingredient::all();
        return view('stock_out', compact('ingredients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ingredient' => 'required|string',
            'quantity' => 'required|numeric|min:0.01',
            'unit_cost' => 'required|numeric|min:0',
            'reason' => 'required|string',
            'issued_to' => 'nullable|string|max:255',
            'date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $ingredient = Ingredient::where('name',$request->ingredient)->first();

        if ($ingredient && $ingredient->quantity <$request->quantity) {
            return back()->withErrors(['quantity' => 'Issued quantity exceeds available stock (' . $ingredient->quantity . ' ' .$ingredient->unit . ').'])->withInput();
        }

        StockOut::create([
            'ingredient' => $request->ingredient,
            'quantity' => $request->quantity,
            'unit_cost' => $request->unit_cost,
            'reason' => $request->reason,
            'issued_to' => $request->issued_to,
            'date' => $request->date,
            'notes' => $request->notes,
        ]);

        if ($ingredient) {
            $ingredient->quantity -= $request->quantity;
            $ingredient->save();

            InventoryActivity::create([
                'ingredient_id' => $ingredient->id,
                'transaction_type' => 'Stock-Out',
                'quantity' => $request->quantity,
                'user_id' => $request->user()->id(),
            ]);
        }

        return redirect()->route('ingredients.index')->with('success', 'Stock-Out recorded successfully and inventory updated!');
    }
}