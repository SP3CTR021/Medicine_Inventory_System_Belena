<?php

namespace App\Http\Controllers;

use App\Http\Requests\MedicineRequest;
use App\Models\Medicine;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MedicineController extends Controller
{
    /**
     * Display a listing of the medicines.
     */
    public function index(Request $request): View
    {
        $query = Medicine::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('generic_name', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->input('category'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $medicines = $query->latest()->paginate(10)->withQueryString();
        $categories = Medicine::distinct()->pluck('category');

        return view('medicines.index', compact('medicines', 'categories'));
    }

    /**
     * Show the form for creating a new medicine.
     */
    public function create(): View
    {
        $categories = Medicine::distinct()->pluck('category');
        return view('medicines.create', compact('categories'));
    }

    /**
     * Store a newly created medicine in storage.
     */
    public function store(MedicineRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['status'] = Medicine::determineStatus(
            (int) $data['quantity'],
            $data['expiration_date']
        );

        Medicine::create($data);

        return redirect()->route('medicines.index')
            ->with('success', 'Medicine created successfully.');
    }

    /**
     * Display the specified medicine.
     */
    public function show(Medicine $medicine): View
    {
        return view('medicines.show', compact('medicine'));
    }

    /**
     * Show the form for editing the specified medicine.
     */
    public function edit(Medicine $medicine): View
    {
        $categories = Medicine::distinct()->pluck('category');
        return view('medicines.edit', compact('medicine', 'categories'));
    }

    /**
     * Update the specified medicine in storage.
     */
    public function update(MedicineRequest $request, Medicine $medicine): RedirectResponse
    {
        $data = $request->validated();
        $data['status'] = Medicine::determineStatus(
            (int) $data['quantity'],
            $data['expiration_date']
        );

        $medicine->update($data);

        return redirect()->route('medicines.index')
            ->with('success', 'Medicine updated successfully.');
    }

    /**
     * Remove the specified medicine from storage.
     */
    public function destroy(Medicine $medicine): RedirectResponse
    {
        $medicine->delete();

        return redirect()->route('medicines.index')
            ->with('success', 'Medicine deleted successfully.');
    }
}
