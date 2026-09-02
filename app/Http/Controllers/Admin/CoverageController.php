<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CoverageArea;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CoverageController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->query('search');
        
        $query = CoverageArea::query();
        
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('city', 'like', "%{$search}%")
                  ->orWhere('district', 'like', "%{$search}%")
                  ->orWhere('village', 'like', "%{$search}%");
            });
        }

        $areas = $query->orderBy('city')->orderBy('district')->paginate(15)->withQueryString();

        return view('admin.coverage.index', compact('areas', 'search'));
    }

    public function create(): View
    {
        return view('admin.coverage.form', [
            'area' => new CoverageArea(),
            'isEdit' => false,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'city' => ['required', 'string', 'max:255'],
            'district' => ['required', 'string', 'max:255'],
            'village' => ['required', 'string', 'max:255'],
            'postal_code' => ['nullable', 'string', 'max:10'],
            'status' => ['required', 'string', 'in:covered,in_progress,pending'],
            'notes' => ['nullable', 'string', 'max:255'],
        ]);

        CoverageArea::create($validated);

        return redirect()->route('admin.coverage.index')
            ->with('success', 'Area coverage baru berhasil ditambahkan!');
    }

    public function edit(CoverageArea $coverage): View
    {
        return view('admin.coverage.form', [
            'area' => $coverage,
            'isEdit' => true,
        ]);
    }

    public function update(Request $request, CoverageArea $coverage): RedirectResponse
    {
        $validated = $request->validate([
            'city' => ['required', 'string', 'max:255'],
            'district' => ['required', 'string', 'max:255'],
            'village' => ['required', 'string', 'max:255'],
            'postal_code' => ['nullable', 'string', 'max:10'],
            'status' => ['required', 'string', 'in:covered,in_progress,pending'],
            'notes' => ['nullable', 'string', 'max:255'],
        ]);

        $coverage->update($validated);

        return redirect()->route('admin.coverage.index')
            ->with('success', "Area {$coverage->district}, {$coverage->city} berhasil diperbarui!");
    }

    public function destroy(CoverageArea $coverage): RedirectResponse
    {
        $coverage->delete();

        return redirect()->route('admin.coverage.index')
            ->with('success', 'Area coverage berhasil dihapus!');
    }
}
