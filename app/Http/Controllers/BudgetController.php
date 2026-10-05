<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Cashier;
use App\Models\Client;
use App\Models\Material;
use App\Models\Vendor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BudgetController extends Controller
{
    public function index()
    {
        return view('main.budget.index');
    }

    // public function build(Request $request)
    // {
    //     $validated = $request->validate([
    //         'material_price_option' => ['required'],
    //         'manual-price'          => ['required_if:material_price_option,2', 'nullable', 'numeric'],
    //         'capital_amount'        => ['required', 'numeric'],
    //         'until_date'            => ['required', 'date', 'before_or_equal:today'],
    //     ]);

    //     // 1. Calculate Credit components
    //     $clientsTotal = Client::with(['sales.bill', 'ledgersRecords'])
    //         ->get()
    //         ->sum(function ($client) {
    //             $totalSales = $client->sales->sum(fn($sale) => $sale->total());
    //             $totalRecords = $client->ledgersRecords->sum(fn($record) => $record->amount);
    //             return $totalSales + $totalRecords;
    //         });

    //     // 1. Check the manual price condition upfront to avoid unnecessary database queries and loops
    //     if ($validated['material_price_option'] == 2 && isset($validated['manual-price'])) {
    //         $materialsTotal = (int) $validated['manual-price'];
    //     } else {
    //         $materialsTotal = Material::with(['inventories', 'purchases'])
    //             ->get()
    //             ->sum(function ($material) {
    //                 $quantity = $material->inventories->sum('pivot.quantity') ?? 0;
    //                 $latestPurchase = $material->latestPurchase->first();
    //                 $lastPrice = $latestPurchase ? ($latestPurchase->pivot->cost * $latestPurchase->rate) : 1;

    //                 return max(0, $quantity) * $lastPrice;
    //             });
    //     }

    //     $cashiersTotal = Cashier::all()->sum('total');

    //     // 2. Calculate Debit components
    //     $vendorsTotal = Vendor::with(['purchases.bill', 'ledgersRecords'])
    //         ->get()
    //         ->sum(function ($vendor) {
    //             $totalPurchases = $vendor->purchases->sum(fn($purchase) => $purchase->total());
    //             $totalRecords = $vendor->ledgersRecords->sum(fn($record) => $record->amount);
    //             return $totalPurchases + $totalRecords;
    //         });

    //     $capitalTotal = (float) $validated['capital_amount'];

    //     // 3. Aggregate Financial Totals
    //     $totalCredit = $clientsTotal + $materialsTotal + $cashiersTotal;
    //     $totalDebit = $vendorsTotal + $capitalTotal;

    //     // Profit Calculation: Credit (Inflow/Value) minus Debit (Outflow/Obligations)
    //     $netBalance = $totalCredit - $totalDebit;
    //     $isProfit = $netBalance >= 0;

    //     // 4. Compile the full report payload
    //     $reportData = [
    //         'credit' => [
    //             'clients' => $clientsTotal,
    //             'materials' => $materialsTotal,
    //             'cashiers' => $cashiersTotal,
    //             'total' => $totalCredit,
    //         ],
    //         'debit' => [
    //             'vendors' => $vendorsTotal,
    //             'capital' => $capitalTotal,
    //             'total' => $totalDebit,
    //         ],
    //         'summary' => [
    //             'net_balance' => $netBalance,
    //             'status' => $isProfit ? 'Profit' : 'Loss',
    //             'generated_at' => now()->toDateTimeString(),
    //         ]
    //     ];

    //     Helper::file_data('latest_budget_report', ['report_data' => $reportData, 'inputs' => $validated]);
    //     Helper::file_data('last_capital', ['last_capital' => $capitalTotal]);

    //     return view('main.budget.report', compact('reportData'));
    // }

    public function build(Request $request)
    {
        // 1. Fallback 'until_date' to today if missing, then validate
        if (!$request->has('until_date')) {
            $request->merge(['until_date' => now()->toDateString()]);
        }

        $validated = $request->validate([
            'material_price_option' => ['required'],
            'manual-price'          => ['required_if:material_price_option,2', 'nullable', 'numeric'],
            'capital_amount'        => ['required', 'numeric'],
            'until_date'            => ['required', 'date', 'before_or_equal:today'],
        ]);

        // Define the dynamic timeframes
        $untilDate = Carbon::parse($validated['until_date'])->endOfDay();
        $startDate = Carbon::parse($validated['until_date'])->startOfYear(); // Start of the year relative to until_date

        // Reusable constraint closure for standard timestamp columns (created_at)
        $dateFilter = function ($query, ?string $name = null) use ($startDate, $untilDate) {
            if ($name == null) {
                return $query->whereBetween("created_at", [$startDate, $untilDate]);
            } else {
                $query->whereBetween("$name.created_at", [$startDate, $untilDate]);
            }
        };

        // 2. Calculate Credit components (Filtered by date)
        $clientsTotal = Client::with([
            'sales' => function ($query) use ($startDate, $untilDate) {
                $query->whereBetween('sales.created_at', [$startDate, $untilDate])
                    ->with('bill'); // Make sure the nested bill stays eager loaded
            },
            'ledgersRecords' => $dateFilter
        ])
            ->get()
            ->sum(function ($client) {
                $totalSales = $client->sales->sum(fn($sale) => $sale->total());
                $totalRecords = $client->ledgersRecords->sum(fn($record) => $record->amount);
                return $totalSales + $totalRecords;
            });

        // 3. Calculate Material Totals (Filtered by date)
        if ($validated['material_price_option'] == 2 && isset($validated['manual-price'])) {
            $materialsTotal = (int) $validated['manual-price'];
        } else {
            $materialsTotal = Material::with([
                'inventories' => function ($query) use ($startDate, $untilDate) {
                    // Assuming inventory pivot table or model tracks inventory addition dates via created_at
                    $query->whereBetween('inventories.created_at', [$startDate, $untilDate]);
                },
                'purchases' => fn($query) => $dateFilter($query, name: 'purchases'),
            ])
                ->get()
                ->sum(function ($material) {
                    $quantity = $material->inventories->sum('pivot.quantity') ?? 0;
                    // Get the latest purchase up *until* our date limit
                    // $latestPurchase = $material->purchases->sortByDesc('created_at')->first();
                    $latestPurchase = $material->latestPurchase->first();;
                    $lastPrice = $latestPurchase ? ($latestPurchase->pivot->cost * $latestPurchase->rate) : 1;

                    return max(0, $quantity) * $lastPrice;
                });
        }

        // Assuming Cashier totals should also be constraint relative to the timeline
        // If Cashier totals are static/running balances, you can leave Cashier::all() as it was
        $cashiersTotal = Cashier::all()->sum('total');

        $vendorsTotal = Vendor::with([
            'purchases' => function ($query) use ($startDate, $untilDate) {
                $query->whereBetween('purchases.created_at', [$startDate, $untilDate])
                    ->with('bill');
            },
            'ledgersRecords' => $dateFilter
        ])
            ->get()
            ->sum(function ($vendor) {
                $totalPurchases = $vendor->purchases->sum(fn($purchase) => $purchase->total());
                $totalRecords = $vendor->ledgersRecords->sum(fn($record) => $record->amount);
                return $totalPurchases + $totalRecords;
            });

        $capitalTotal = (float) $validated['capital_amount'];

        $totalCredit = $clientsTotal + $materialsTotal + $cashiersTotal;
        $totalDebit = $vendorsTotal + $capitalTotal;

        $netBalance = $totalCredit - $totalDebit;
        $isProfit = $netBalance >= 0;

        $reportData = [
            'credit' => [
                'clients' => $clientsTotal,
                'materials' => $materialsTotal,
                'cashiers' => $cashiersTotal,
                'total' => $totalCredit,
            ],
            'debit' => [
                'vendors' => $vendorsTotal,
                'capital' => $capitalTotal,
                'total' => $totalDebit,
            ],
            'summary' => [
                'net_balance' => $netBalance,
                'status' => $isProfit ? 'Profit' : 'Loss',
                'generated_at' => now()->toDateTimeString(),
                'start_date' => $startDate->toDateString(),
                'until_date' => $untilDate->toDateString(),
            ]
        ];

        Helper::file_data('latest_budget_report', ['report_data' => $reportData, 'inputs' => $validated]);
        Helper::file_data('last_capital', ['last_capital' => $capitalTotal]);

        return view('main.budget.report', compact('reportData'));
    }


    public function last()
    {
        $lastReport = Helper::file_data('latest_budget_report');

        if ($lastReport) {
            return view('main.budget.report', ['reportData' => $lastReport['report_data']]);
        }
        return back()->with('error', 'No budget report found');
    }

    public function deleteLast()
    {
        $lastReport = Helper::file_data('latest_budget_report', deleteFile: true);

        if ($lastReport) {
            return redirect()->route('home')->with('success', 'Last budget report is deleted');
        }
        return back()->with('error', 'Last budget report could not be deleted');
    }
}
