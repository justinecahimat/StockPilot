<?php

namespace App\Http\Controllers;

use App\Models\PurchaseRequest;
use App\Models\Ingredient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseRequestController extends Controller
{
    public function index()
    {
        $requests = PurchaseRequest::with([
            'requester',
            'items'
        ])
        ->latest()
        ->get();

        $ingredients = Ingredient::orderBy('name')->get();

        return view('purchase-requests', compact(
            'requests',
            'ingredients'
        ));
    }

    // Display one purchase request
    public function show($id)
    {
        $request = PurchaseRequest::with([
            'requester',
            'items.ingredient'
        ])->findOrFail($id);

        return view('purchase-request', compact('request'));
    }

    // Save a new purchase request
    public function store(Request $request)
    {
        // Validate submitted information
        $validated = $request->validate([
            'items' => ['required', 'array', 'min:1'],
            'items.*.ingredient_id' => [
                'required',
                'exists:ingredients,id'
            ],
            'items.*.requested_quantity' => [
                'required',
                'numeric',
                'gt:0'
            ],
            'items.*.unit_cost' => [
                'required',
                'numeric',
                'min:0'
            ],
        ]);

        DB::transaction(function () use ($validated, $request) {

            // Generate the request reference number
            $nextNumber = PurchaseRequest::max('id') + 1;

            $referenceNo = 'PR-' . now()->year . '-'
                . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

            // Create the main purchase request
            $purchaseRequest = PurchaseRequest::create([
                'reference_no' => $referenceNo,
                'requested_by' => $request->user()->id,
                'status' => 'pending',
            ]);

            // Save each requested ingredient
            foreach ($validated['items'] as $item) {

                $ingredient = Ingredient::findOrFail(
                    $item['ingredient_id']
                );

                $purchaseRequest->items()->create([
                    'ingredient_id' => $ingredient->id,
                    'requested_quantity' => $item['requested_quantity'],
                    'unit' => $ingredient->unit,
                    'current_stock' => $ingredient->quantity,
                    'unit_cost' => $item['unit_cost'],
                ]);
            }

        });

        return redirect()
            ->route('purchase-request')
            ->with('success', 'Purchase request submitted successfully.');
    }
}
