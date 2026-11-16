<?php

namespace App\Http\Controllers;

use App\Models\StockIn;
use App\Models\StockOut;
use App\Models\PurchaseRequest;
use App\Models\Ingredient;

class InventoryReportController extends Controller
{
    public function index()
    {
        // Report period: Last 30 days
        $startDate = now()->subDays(30)->startOfDay();
        $endDate = now()->endOfDay();

        // Prepare data for the Stock Movement chart (last 6 months)
        $chartStartDate = now()->copy()->startOfMonth()->subMonths(5);
        $chartEndDate = now()->copy()->endOfMonth();

        // Get monthly Stock-In quantities
        $monthlyStockIn = StockIn::selectRaw(
            'YEAR(created_at) as year, MONTH(created_at) as month, SUM(quantity) as total'
        )
            ->whereBetween('created_at', [$chartStartDate, $chartEndDate])
            ->groupBy('year', 'month')
            ->get()
            ->keyBy(fn($item) => $item->year . '-' . $item->month);

        // Get monthly Stock-Out quantities
        $monthlyStockOut = StockOut::selectRaw(
            'YEAR(created_at) as year, MONTH(created_at) as month, SUM(quantity) as total'
        )
            ->whereBetween('created_at', [$chartStartDate, $chartEndDate])
            ->groupBy('year', 'month')
            ->get()
            ->keyBy(fn($item) => $item->year . '-' . $item->month);

        // Prepare chart labels and values
        $stockMovementLabels = [];
        $stockInData = [];
        $stockOutData = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = now()->copy()->startOfMonth()->subMonths($i);
            $key = $month->year . '-' . $month->month;

            $stockMovementLabels[] = $month->format('M Y');

            $stockInData[] = $monthlyStockIn->get($key)->total ?? 0;
            $stockOutData[] = $monthlyStockOut->get($key)->total ?? 0;
        }

        // Count pending purchase requests
        $purchaseRequestsCount = PurchaseRequest::where('status', 'pending')
            ->count();

        // Total Stock-In quantity for the last 30 days
        $stockInQuantity = StockIn::whereBetween('created_at', [
            $startDate,
            $endDate
        ])->sum('quantity');

        // Total Stock-Out quantity for the last 30 days
        $stockOutQuantity = StockOut::whereBetween('created_at', [
            $startDate,
            $endDate
        ])->sum('quantity');

        // Calculate Stock-In value (quantity × unit cost)
        $stockInValue = StockIn::whereBetween('created_at', [
            $startDate,
            $endDate
        ])->selectRaw(
            'COALESCE(SUM(quantity * unit_cost), 0) as total'
        )->value('total');

        // Calculate Stock-Out value (quantity × unit cost)
        $stockOutValue = StockOut::whereBetween('created_at', [
            $startDate,
            $endDate
        ])->selectRaw(
            'COALESCE(SUM(quantity * unit_cost), 0) as total'
        )->value('total');

        // Calculate the value of expired ingredients
        $wasteExpiredValue = Ingredient::whereNotNull('expiration_date')
            ->whereDate('expiration_date', '<', now()->toDateString())
            ->selectRaw(
                'COALESCE(SUM(quantity * unit_cost), 0) as total'
            )
            ->value('total');

        // Current ingredient quantities grouped by category
        $categorySummaries = Ingredient::selectRaw(
            'category as category_name, SUM(quantity) as total_value'
        )
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->groupBy('category')
            ->get();

        return view('reports.index', compact(
            'stockInValue',
            'stockOutValue',
            'wasteExpiredValue',
            'purchaseRequestsCount',
            'categorySummaries',
            'stockInQuantity',
            'stockOutQuantity',
            'stockMovementLabels',
            'stockInData',
            'stockOutData'
        ));
    }
}
