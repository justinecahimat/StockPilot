<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ingredient;
use Carbon\Carbon;

class LowStockAlertController extends Controller
{
    public function index(Request $request)
    {
        // Get today's date and the date 7 days from now
        $today = Carbon::today();
        $sevenDaysLater = Carbon::today()->addDays(7);

        // 1. Critical stock: below 25% of minimum quantity
        $criticalIngredients = Ingredient::where('min_quantity', '>', 0)
            ->whereRaw('quantity < min_quantity * 0.25')
            ->get();

        // 2. Low stock: below minimum, but not critical
        $lowStockIngredients = Ingredient::where('min_quantity', '>', 0)
            ->whereRaw('quantity < min_quantity')
            ->whereRaw('quantity >= min_quantity * 0.25')
            ->get();

        // 3. Expiring within the next 7 days
        $expiringIngredients = Ingredient::whereNotNull('expiration_date')
            ->whereDate('expiration_date', '>=', $today)
            ->whereDate('expiration_date', '<=', $sevenDaysLater)
            ->get();

        // 4. Already expired
        $expiredIngredients = Ingredient::whereNotNull('expiration_date')
            ->whereDate('expiration_date', '<', $today)
            ->get();

        // Get all ingredients that need attention
        $alerts = Ingredient::where(function ($query) use ($today, $sevenDaysLater) {

            $query->where(function ($stockQuery) {
                $stockQuery->where('min_quantity', '>', 0)
                    ->whereRaw('quantity < min_quantity');
            })

            ->orWhere(function ($expiryQuery) use ($today, $sevenDaysLater) {
                $expiryQuery->whereNotNull('expiration_date')
                    ->whereDate('expiration_date', '<=', $sevenDaysLater);
            });

        })->get();

        // Assign an alert status to each ingredient
        $alerts = $alerts->map(function ($ingredient) use ($today, $sevenDaysLater) {

            if ($ingredient->expiration_date && $ingredient->expiration_date < $today->toDateString()) {
                $ingredient->alert_status = 'Expired';
            } elseif (
                $ingredient->expiration_date &&
                $ingredient->expiration_date <= $sevenDaysLater->toDateString()
            ) {
                $ingredient->alert_status = 'Expiring Soon';
            } elseif (
                $ingredient->min_quantity > 0 &&
                $ingredient->quantity < $ingredient->min_quantity * 0.25
            ) {
                $ingredient->alert_status = 'Critical';
            } else {
                $ingredient->alert_status = 'Low Stock';
            }

            return $ingredient;
        });

                // Search ingredients by name
        if ($request->filled('search')) {
            $search = $request->input('search');

            $alerts = $alerts->filter(function ($ingredient) use ($search) {
                return stripos($ingredient->name, $search) !== false;
            })->values();
        }

        // Get all ingredients for the reusable Purchase Request modal
        $ingredients = Ingredient::orderBy('name')->get();

        return view('low-stock-alerts', compact(
            'criticalIngredients',
            'lowStockIngredients',
            'expiringIngredients',
            'expiredIngredients',
            'alerts',
            'ingredients'
        ));
    }


    public function exportCsv()
    {
        $today = Carbon::today();
        $sevenDaysLater = Carbon::today()->addDays(7);

        $alerts = Ingredient::where(function ($query) use ($today, $sevenDaysLater) {

            $query->where(function ($stockQuery) {
                $stockQuery->where('min_quantity', '>', 0)
                    ->whereRaw('quantity < min_quantity');
            })

            ->orWhere(function ($expiryQuery) use ($today, $sevenDaysLater) {
                $expiryQuery->whereNotNull('expiration_date')
                    ->whereDate('expiration_date', '<=', $sevenDaysLater);
            });

        })->get();

        $alerts = $alerts->map(function ($ingredient) use ($today, $sevenDaysLater) {

            if ($ingredient->expiration_date && $ingredient->expiration_date < $today->toDateString()) {
                $ingredient->alert_status = 'Expired';
            } elseif (
                $ingredient->expiration_date &&
                $ingredient->expiration_date <= $sevenDaysLater->toDateString()
            ) {
                $ingredient->alert_status = 'Expiring Soon';
            } elseif (
                $ingredient->min_quantity > 0 &&
                $ingredient->quantity < $ingredient->min_quantity * 0.25
            ) {
                $ingredient->alert_status = 'Critical';
            } else {
                $ingredient->alert_status = 'Low Stock';
            }

            return $ingredient;
        });

        $filename = 'stockpilot-alerts-' . now()->format('Y-m-d') . '.csv';

        return response()->streamDownload(function () use ($alerts) {

            $file = fopen('php://output', 'w');

            // Add UTF-8 BOM for Excel compatibility
            fwrite($file, "\xEF\xBB\xBF");

            fputcsv($file, [
                'Ingredient Name',
                'Quantity',
                'Minimum Quantity',
                'Unit',
                'Expiration Date',
                'Alert Status'
            ]);

            foreach ($alerts as $ingredient) {
                fputcsv($file, [
                    $ingredient->name,
                    $ingredient->quantity,
                    $ingredient->min_quantity,
                    $ingredient->unit,
                    $ingredient->expiration_date,
                    $ingredient->alert_status
                ]);
            }

            fclose($file);

        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }


    public function exportPdf()
    {
        $today = Carbon::today();
        $sevenDaysLater = Carbon::today()->addDays(7);

        $alerts = Ingredient::where(function ($query) use ($today, $sevenDaysLater) {

            $query->where(function ($stockQuery) {
                $stockQuery->where('min_quantity', '>', 0)
                    ->whereRaw('quantity < min_quantity');
            })

            ->orWhere(function ($expiryQuery) use ($sevenDaysLater) {
                $expiryQuery->whereNotNull('expiration_date')
                    ->whereDate('expiration_date', '<=', $sevenDaysLater);
            });

        })->get();

        $alerts = $alerts->map(function ($ingredient) use ($today, $sevenDaysLater) {

            if ($ingredient->expiration_date && $ingredient->expiration_date < $today->toDateString()) {
                $ingredient->alert_status = 'Expired';
            } elseif (
                $ingredient->expiration_date &&
                $ingredient->expiration_date <= $sevenDaysLater->toDateString()
            ) {
                $ingredient->alert_status = 'Expiring Soon';
            } elseif (
                $ingredient->min_quantity > 0 &&
                $ingredient->quantity < $ingredient->min_quantity * 0.25
            ) {
                $ingredient->alert_status = 'Critical';
            } else {
                $ingredient->alert_status = 'Low Stock';
            }

            return $ingredient;
        });

        return view('exports.low-stock-alerts-pdf', compact(
            'alerts',
            'today'
        ));
    }


}