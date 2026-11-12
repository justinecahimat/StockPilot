<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ReportController extends Controller
{
    public function index()
    {
        // Query actual database totals (default to 0 if empty or tables don't exist yet)
        $stockInValue = 0;
        try {
            if (Schema::hasTable('stock_ins')) {
                $stockInValue = DB::table('stock_ins')->sum('total_cost') ?? 0;
            }
        } catch (\Exception $e) {}

        $stockOutValue = 0;
        try {
            if (Schema::hasTable('stock_outs')) {
                $stockOutValue = DB::table('stock_outs')->sum('total_cost') ?? 0;
            }
        } catch (\Exception $e) {}

        $purchaseRequestsCount = 0;
        try {
            if (Schema::hasTable('purchase_requests')) {
                $purchaseRequestsCount = DB::table('purchase_requests')->count() ?? 0;
            }
        } catch (\Exception $e) {}
        
        // Multi-table join for actual category summaries from ingredients
        $categorySummaries = collect();
        try {
            if (Schema::hasTable('ingredients') && Schema::hasTable('categories')) {
                $categorySummaries = DB::table('ingredients')
                    ->join('categories', 'ingredients.category_id', '=', 'categories.id')
                    ->select('categories.name as category_name', DB::raw('SUM(ingredients.price * ingredients.stock) as total_value'))
                    ->groupBy('categories.id', 'categories.name')
                    ->get();
            }
        } catch (\Exception $e) {}

        return view('reports.index', compact('stockInValue', 'stockOutValue', 'purchaseRequestsCount', 'categorySummaries'));
    }
}