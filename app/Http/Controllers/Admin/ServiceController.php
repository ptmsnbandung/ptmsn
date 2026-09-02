<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(): View
    {
        $services = Service::orderBy('sort_order')->get();
        return view('admin.services.index', compact('services'));
    }

    public function create(): View
    {
        return view('admin.services.form', [
            'service' => new Service(),
            'isEdit' => false,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'icon' => ['nullable', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'features' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
            'sort_order' => ['required', 'integer'],
        ]);

        $features = array_filter(array_map('trim', explode("\n", $request->input('features', ''))));

        Service::create([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'icon' => $validated['icon'] ?: 'solar:server-square-bold',
            'description' => $validated['description'],
            'features' => array_values($features),
            'is_active' => $request->boolean('is_active', true),
            'sort_order' => $validated['sort_order'],
        ]);

        return redirect()->route('admin.services.index')
            ->with('success', 'Layanan baru berhasil ditambahkan!');
    }

    public function edit(Service $service): View
    {
        return view('admin.services.form', [
            'service' => $service,
            'isEdit' => true,
        ]);
    }

    public function update(Request $request, Service $service): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'icon' => ['nullable', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'features' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
            'sort_order' => ['required', 'integer'],
        ]);

        $features = array_filter(array_map('trim', explode("\n", $request->input('features', ''))));

        $service->update([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'icon' => $validated['icon'] ?: 'solar:server-square-bold',
            'description' => $validated['description'],
            'features' => array_values($features),
            'is_active' => $request->boolean('is_active'),
            'sort_order' => $validated['sort_order'],
        ]);

        return redirect()->route('admin.services.index')
            ->with('success', "Layanan {$service->title} berhasil diperbarui!");
    }

    public function destroy(Service $service): RedirectResponse
    {
        $title = $service->title;
        $service->delete();

        return redirect()->route('admin.services.index')
            ->with('success', "Layanan {$title} berhasil dihapus!");
    }
}
