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
            'approver',
            'items.ingredient'
        ])->findOrFail($id);

        return view('purchase-requests.show', compact('request'));
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


    // Approve a purchase request
    public function approve(Request $request, $id)
    {
        // Only admins can approve purchase requests
        if ($request->user()->role !== 'Admin') {
            abort(403);
        }

        // Find the purchase request
        $purchaseRequest = PurchaseRequest::findOrFail($id);

        // Prevent approving an already processed request
        if ($purchaseRequest->status !== 'pending') {
            return redirect()
                ->route('purchase-request.show', $id)
                ->with('error', 'This request has already been processed.');
        }

        // Update the approval information
        $purchaseRequest->update([
            'status' => 'approved',
            'approved_by' => $request->user()->id,
            'approved_at' => now(),
        ]);

        return redirect()
            ->route('purchase-request.show', $id)
            ->with('success', 'Purchase request approved successfully.');
    }

    public function reject(Request $request, $id)
    {
        // Only Admin can reject purchase requests
        if ($request->user()->role !== 'Admin') {
            abort(403, 'Unauthorized action.');
        }

        // Validate the rejection reason
        $validated = $request->validate([
            'rejection_reason' => 'required|string|max:1000',
        ]);

        $purchaseRequest = PurchaseRequest::findOrFail($id);

        // Only pending requests can be rejected
        if ($purchaseRequest->status !== 'pending') {
            return redirect()
                ->route('purchase-request.show', $id)
                ->with('error', 'Only pending purchase requests can be rejected.');
        }

        $purchaseRequest->update([
            'status' => 'rejected',
            'rejection_reason' => $validated['rejection_reason'],
            'approved_by' => $request->user()->id,
            'approved_at' => now(),
        ]);

        return redirect()
            ->route('purchase-request.show', $id)
            ->with('success', 'Purchase request rejected successfully.');
    }

}
