<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class MedicineReportController extends Controller
{
    /**
     * Display the reports dashboard.
     */
    public function index(Request $request): View
    {
        $categories = Medicine::distinct()->pluck('category');

        $totalMedicines = Medicine::count();
        $availableCount = Medicine::where('status', 'available')->count();
        $expiredCount = Medicine::where('status', 'expired')->count();
        $lowStockCount = Medicine::where('status', 'low_stock')->count();
        $outOfStockCount = Medicine::where('status', 'out_of_stock')->count();

        return view('reports.index', compact(
            'categories',
            'totalMedicines',
            'availableCount',
            'expiredCount',
            'lowStockCount',
            'outOfStockCount'
        ));
    }

    /**
     * Show available medicines report.
     */
    public function available(Request $request): View
    {
        $query = Medicine::where('status', 'available');

        if ($request->filled('category')) {
            $query->where('category', $request->input('category'));
        }

        $medicines = $query->latest()->paginate(15)->withQueryString();
        $reportType = 'Available Medicines';

        return view('reports.show', compact('medicines', 'reportType'));
    }

    /**
     * Show expired medicines report.
     */
    public function expired(Request $request): View
    {
        $query = Medicine::where('status', 'expired')
            ->orWhere('expiration_date', '<', now()->toDateString());

        if ($request->filled('category')) {
            $query->where('category', $request->input('category'));
        }

        $medicines = $query->latest()->paginate(15)->withQueryString();
        $reportType = 'Expired Medicines';

        return view('reports.show', compact('medicines', 'reportType'));
    }

    /**
     * Show low stock medicines report.
     */
    public function lowStock(Request $request): View
    {
        $query = Medicine::where('quantity', '<=', 10)
            ->where('quantity', '>', 0);

        if ($request->filled('category')) {
            $query->where('category', $request->input('category'));
        }

        $medicines = $query->latest()->paginate(15)->withQueryString();
        $reportType = 'Low Stock Medicines';

        return view('reports.show', compact('medicines', 'reportType'));
    }

    /**
     * Show full inventory report.
     */
    public function inventory(Request $request): View
    {
        $query = Medicine::query();

        if ($request->filled('category')) {
            $query->where('category', $request->input('category'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $medicines = $query->latest()->paginate(15)->withQueryString();
        $reportType = 'Medicine Inventory';

        return view('reports.show', compact('medicines', 'reportType'));
    }

    /**
     * Export report as CSV.
     */
    public function exportCsv(Request $request, string $type): StreamedResponse
    {
        $query = Medicine::query();

        switch ($type) {
            case 'available':
                $query->where('status', 'available');
                $filename = 'available_medicines.csv';
                break;
            case 'expired':
                $query->where('status', 'expired')
                    ->orWhere('expiration_date', '<', now()->toDateString());
                $filename = 'expired_medicines.csv';
                break;
            case 'low_stock':
                $query->where('quantity', '<=', 10)
                    ->where('quantity', '>', 0);
                $filename = 'low_stock_medicines.csv';
                break;
            case 'inventory':
            default:
                $filename = 'medicine_inventory.csv';
                break;
        }

        if ($request->filled('category')) {
            $query->where('category', $request->input('category'));
        }

        if ($request->filled('status') && $type === 'inventory') {
            $query->where('status', $request->input('status'));
        }

        $medicines = $query->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($medicines) {
            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'ID',
                'Name',
                'Generic Name',
                'Category',
                'Quantity',
                'Expiration Date',
                'Price',
                'Status',
                'Created At',
            ]);

            foreach ($medicines as $medicine) {
                fputcsv($file, [
                    $medicine->id,
                    $medicine->name,
                    $medicine->generic_name,
                    $medicine->category,
                    $medicine->quantity,
                    $medicine->expiration_date->format('Y-m-d'),
                    $medicine->price,
                    $medicine->status,
                    $medicine->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
