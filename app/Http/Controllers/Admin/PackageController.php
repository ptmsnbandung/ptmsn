<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PackageController extends Controller
{
    public function index(): View
    {
        $packages = Package::orderBy('sort_order')->get();
        return view('admin.packages.index', compact('packages'));
    }

    public function create(): View
    {
        return view('admin.packages.form', [
            'package' => new Package(),
            'isEdit' => false,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'speed' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'period' => ['required', 'string', 'max:50'],
            'description' => ['nullable', 'string'],
            'features' => ['nullable', 'string'],
            'is_popular' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
            'sort_order' => ['required', 'integer'],
        ]);

        $features = array_filter(array_map('trim', explode("\n", $request->input('features', ''))));

        Package::create([
            'name' => $validated['name'],
            'speed' => $validated['speed'],
            'price' => $validated['price'],
            'period' => $validated['period'],
            'description' => $validated['description'],
            'features' => array_values($features),
            'is_popular' => $request->boolean('is_popular'),
            'is_active' => $request->boolean('is_active', true),
            'sort_order' => $validated['sort_order'],
        ]);

        return redirect()->route('admin.packages.index')
            ->with('success', 'Paket internet baru berhasil ditambahkan!');
    }

    public function edit(Package $package): View
    {
        return view('admin.packages.form', [
            'package' => $package,
            'isEdit' => true,
        ]);
    }

    public function update(Request $request, Package $package): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'speed' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'period' => ['required', 'string', 'max:50'],
            'description' => ['nullable', 'string'],
            'features' => ['nullable', 'string'],
            'is_popular' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
            'sort_order' => ['required', 'integer'],
        ]);

        $features = array_filter(array_map('trim', explode("\n", $request->input('features', ''))));

        $package->update([
            'name' => $validated['name'],
            'speed' => $validated['speed'],
            'price' => $validated['price'],
            'period' => $validated['period'],
            'description' => $validated['description'],
            'features' => array_values($features),
            'is_popular' => $request->boolean('is_popular'),
            'is_active' => $request->boolean('is_active'),
            'sort_order' => $validated['sort_order'],
        ]);

        return redirect()->route('admin.packages.index')
            ->with('success', "Paket {$package->name} berhasil diperbarui!");
    }

    public function destroy(Package $package): RedirectResponse
    {
        $name = $package->name;
        $package->delete();

        return redirect()->route('admin.packages.index')
            ->with('success', "Paket {$name} berhasil dihapus!");
    }
}
