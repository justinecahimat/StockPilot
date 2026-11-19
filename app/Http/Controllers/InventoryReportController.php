<?php

namespace App\Http\Controllers;

use App\Models\StockIn;
use App\Models\StockOut;
use App\Models\PurchaseRequest;
use App\Models\Ingredient;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class InventoryReportController extends Controller
{
    public function index(Request $request)
    {
        $reportData = $this->buildReportPayload($request);

        return view('reports.index', $reportData);
    }

    public function generate(Request $request)
    {
        $reportData = $this->buildReportPayload($request);

        return response()->json([
            'filters' => [
                'period'           => $reportData['selectedPeriod'],
                'category'         => $reportData['selectedCategory'],
                'transaction_type' => $reportData['selectedTransactionType'],
            ],
            'summary' => [
                'stockInValue'          => $reportData['stockInValue'],
                'stockInValueFormatted' => number_format($reportData['stockInValue'], 2), 'stockOutValue'         =>$reportData['stockOutValue'],
                'stockOutValueFormatted'=> number_format($reportData['stockOutValue'], 2), 'purchaseRequestsCount' =>$reportData['purchaseRequestsCount'],
                'wasteExpiredValue'     => $reportData['wasteExpiredValue'],
                'wasteExpiredFormatted' => number_format($reportData['wasteExpiredValue'], 2), 'stockInQuantity'       =>$reportData['stockInQuantity'],
                'stockOutQuantity'      => $reportData['stockOutQuantity'],
                'periodLabel'           => $reportData['periodLabel'],
            ],
            'chart' => [
                'labels'       => $reportData['stockMovementLabels'],
                'stockInData'  => $reportData['stockInData'],
                'stockOutData' => $reportData['stockOutData'],
            ],
            'categories' => $reportData['categorySummaries'],
        ]);
    }

    private function buildReportPayload(Request $request): array
    {
        $period =$request->input('period', 'Last 30 days');
        $category =$request->input('category', 'all');
        $transactionType =$request->input('transaction_type', 'all');

        [$startDate, $endDate,$periodLabel] = $this->resolvePeriodRange($period);

        // Prepare data for the Stock Movement chart (last 6 months)
        $chartStartDate = now()->copy()->startOfMonth()->subMonths(5);$chartEndDate = now()->copy()->endOfMonth();

        // Detect column names safely across tables
        $stockInQtyCol =$this->resolveColumn('stock_ins', ['quantity', 'quantity_added', 'qty', 'amount']);
        $stockOutQtyCol =$this->resolveColumn('stock_outs', ['quantity', 'quantity_issued', 'qty', 'amount']);
        $stockInCostCol =$this->resolveColumn('stock_ins', ['unit_cost', 'cost', 'price']);
        $stockOutCostCol =$this->resolveColumn('stock_outs', ['unit_cost', 'cost', 'price']);
        $ingredientQtyCol =$this->resolveColumn('ingredients', ['quantity', 'stock', 'qty']);
        $ingredientCostCol =$this->resolveColumn('ingredients', ['unit_cost', 'cost', 'price']);
        $ingredientCategoryCol =$this->resolveColumn('ingredients', ['category', 'category_name']);

        // Matching ingredient IDs if a specific category is selected
        $filteredIngredientIds = null;
        if ($category &&$category !== 'all' && $ingredientCategoryCol) {$filteredIngredientIds = Ingredient::where($ingredientCategoryCol,$category)->pluck('id');
        }

        // Monthly Stock-In quantities
        $monthlyStockIn = collect();
        if ($stockInQtyCol && $transactionType !== 'stock-out') {$query = StockIn::selectRaw(
                "YEAR(created_at) as year, MONTH(created_at) as month, SUM({$stockInQtyCol}) as total"
            )
                ->whereBetween('created_at', [$chartStartDate,$chartEndDate]);

            $this->applyIngredientScope($query, 'stock_ins',$filteredIngredientIds);

            $monthlyStockIn =$query->groupBy('year', 'month')
                ->get()
                ->keyBy(fn($item) => $item->year . '-' .$item->month);
        }

        // Monthly Stock-Out quantities
        $monthlyStockOut = collect();
        if ($stockOutQtyCol && $transactionType !== 'stock-in') {$query = StockOut::selectRaw(
                "YEAR(created_at) as year, MONTH(created_at) as month, SUM({$stockOutQtyCol}) as total"
            )
                ->whereBetween('created_at', [$chartStartDate,$chartEndDate]);

            $this->applyIngredientScope($query, 'stock_outs',$filteredIngredientIds);

            $monthlyStockOut =$query->groupBy('year', 'month')
                ->get()
                ->keyBy(fn($item) => $item->year . '-' .$item->month);
        }

        // Prepare chart labels and values
        $stockMovementLabels = [];
        $stockInData = [];$stockOutData = [];

        for ($i = 5; $i >= 0; $i--) {$month = now()->copy()->startOfMonth()->subMonths($i);$key = $month->year . '-' .$month->month;

            $stockMovementLabels[] =$month->format('M Y');
            $stockInData[] =$transactionType === 'stock-out' ? 0 : (float) ($monthlyStockIn->get($key)->total ?? 0);
            $stockOutData[] =$transactionType === 'stock-in' ? 0 : (float) ($monthlyStockOut->get($key)->total ?? 0);
        }

        // Count pending purchase requests
        $purchaseRequestsCount = PurchaseRequest::where('status', 'pending')->count();

        // Stock-In quantity and value for selected period
        $stockInQuantity = 0;
        $stockInValue = 0;
        if ($stockInQtyCol && $transactionType !== 'stock-out') {$qtyQuery = StockIn::whereBetween('created_at', [$startDate,$endDate]);
            $this->applyIngredientScope($qtyQuery, 'stock_ins', $filteredIngredientIds);$stockInQuantity = (float) $qtyQuery->sum($stockInQtyCol);

            if ($stockInCostCol) {
                $valQuery = StockIn::whereBetween('created_at', [$startDate, $endDate]);$this->applyIngredientScope($valQuery, 'stock_ins',$filteredIngredientIds);
                $stockInValue = (float)$valQuery
                    ->selectRaw("COALESCE(SUM({$stockInQtyCol} * {$stockInCostCol}), 0) as total")
                    ->value('total');
            }
        }

        // Stock-Out quantity and value for selected period
        $stockOutQuantity = 0;
        $stockOutValue = 0;
        if ($stockOutQtyCol && $transactionType !== 'stock-in') {$qtyQuery = StockOut::whereBetween('created_at', [$startDate,$endDate]);
            $this->applyIngredientScope($qtyQuery, 'stock_outs', $filteredIngredientIds);$stockOutQuantity = (float) $qtyQuery->sum($stockOutQtyCol);

            if ($stockOutCostCol) {
                $valQuery = StockOut::whereBetween('created_at', [$startDate, $endDate]);$this->applyIngredientScope($valQuery, 'stock_outs',$filteredIngredientIds);
                $stockOutValue = (float)$valQuery
                    ->selectRaw("COALESCE(SUM({$stockOutQtyCol} * {$stockOutCostCol}), 0) as total")
                    ->value('total');
            }
        }

        // Value of expired ingredients
        $wasteExpiredValue = 0;
        if ($ingredientQtyCol && $ingredientCostCol && Schema::hasColumn('ingredients', 'expiration_date')) {$wasteQuery = Ingredient::whereNotNull('expiration_date')
                ->whereDate('expiration_date', '<', now()->toDateString());

            if ($filteredIngredientIds !== null) {
                $wasteQuery->whereIn('id',$filteredIngredientIds);
            }

            $wasteExpiredValue = (float)$wasteQuery
                ->selectRaw("COALESCE(SUM({$ingredientQtyCol} * {$ingredientCostCol}), 0) as total")
                ->value('total');
        }

        // Available category options for filter dropdown
        $availableCategories = ($ingredientCategoryCol)
            ? Ingredient::whereNotNull($ingredientCategoryCol)
                ->where($ingredientCategoryCol, '!=', '')
                ->distinct()
                ->orderBy($ingredientCategoryCol)
                ->pluck($ingredientCategoryCol)
            : collect();

        // Current ingredient quantities grouped by category
        $categorySummaries = collect();
        if ($ingredientCategoryCol && $ingredientQtyCol) {$catQuery = Ingredient::selectRaw(
                "{$ingredientCategoryCol} as category_name, SUM({$ingredientQtyCol}) as total_value"
            )
                ->whereNotNull($ingredientCategoryCol)
                ->where($ingredientCategoryCol, '!=', '');

            if ($category && $category !== 'all') {$catQuery->where($ingredientCategoryCol,$category);
            }

            $categorySummaries =$catQuery
                ->groupBy($ingredientCategoryCol)
                ->get();
        }

        return [
            'stockInValue'            => $stockInValue,
            'stockOutValue'           => $stockOutValue,
            'wasteExpiredValue'       => $wasteExpiredValue,
            'purchaseRequestsCount'   => $purchaseRequestsCount,
            'categorySummaries'       => $categorySummaries,
            'availableCategories'     => $availableCategories,
            'stockInQuantity'         => $stockInQuantity,
            'stockOutQuantity'        => $stockOutQuantity,
            'stockMovementLabels'     => $stockMovementLabels,
            'stockInData'             => $stockInData,
            'stockOutData'            => $stockOutData,
            'selectedPeriod'          => $period,
            'selectedCategory'        => $category,
            'selectedTransactionType' => $transactionType,
            'periodLabel'             => $periodLabel,
        ];
    }

    private function resolvePeriodRange(string $period): array
    {
        return match ($period) {
            'Last 7 days' => [now()->subDays(7)->startOfDay(), now()->endOfDay(), 'Last 7 days'],
            'This year'   => [now()->copy()->startOfYear(), now()->endOfDay(), 'This year'],
            default       => [now()->subDays(30)->startOfDay(), now()->endOfDay(), 'Last 30 days'],
        };
    }

    private function applyIngredientScope($query, string $table,$ingredientIds): void
    {
        if ($ingredientIds === null) {
            return;
        }

        if (Schema::hasColumn($table, 'ingredient_id')) {
            $query->whereIn('ingredient_id',$ingredientIds);
        } elseif (Schema::hasColumn($table, 'ingredient')) {
            $names = Ingredient::whereIn('id',$ingredientIds)->pluck('name');
            $query->whereIn('ingredient',$names);
        }
    }

    private function resolveColumn(string $table, array$candidates): ?string
    {
        if (!Schema::hasTable($table)) {
            return null;
        }

        foreach ($candidates as$column) {
            if (Schema::hasColumn($table,$column)) {
                return $column;
            }
        }

        return null;
    }
}