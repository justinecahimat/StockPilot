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

    public function show($id)
    {
        // Find the selected ingredient
        $ingredient = Ingredient::findOrFail($id);

        // Display the ingredient details page
        return view('showIngredientsDetail', compact('ingredient'));
    }


    public function exportCsv(Request $request)
    {
        $query = Ingredient::query();

        // Apply the same search filter
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Apply the same category filter
        if ($request->filled('category') && $request->category !== 'All categories') {
            $query->where('category', $request->category);
        }

        // Retrieve all matching ingredients
        $ingredients = $query->get();

        // Generate CSV download
        return response()->streamDownload(function () use ($ingredients) {

            $file = fopen('php://output', 'w');

            // Add UTF-8 BOM for Excel compatibility
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // CSV column headings
            fputcsv($file, [
                'Ingredient',
                'Category',
                'Quantity',
                'Unit',
                'Minimum Stock',
                'Supplier',
                'Status'
            ]);

            // Add ingredient records
            foreach ($ingredients as $item) {

                $status = $item->quantity <= $item->min_quantity
                    ? 'Low Stock'
                    : 'In Stock';

                fputcsv($file, [
                    $item->name,
                    $item->category ?? 'N/A',
                    $item->quantity,
                    $item->unit,
                    $item->min_quantity,
                    $item->supplier ?? 'N/A',
                    $status
                ]);
            }

            fclose($file);

        }, 'stockpilot-ingredients-' . now()->format('Y-m-d') . '.csv', [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }


    
    public function exportPdf(Request $request)
    {
        $query = Ingredient::query();

        // Apply search filter
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Apply category filter
        if ($request->filled('category') && $request->category !== 'All categories') {
            $query->where('category', $request->category);
        }

        // Retrieve ALL matching ingredients
        $ingredients = $query->get();

        // Return ingredient records as JSON
        return response()->json($ingredients);
    }



}