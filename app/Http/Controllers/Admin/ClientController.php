<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClientController extends Controller
{
    public function index(): View
    {
        $clients = Client::orderBy('sort_order')->get();
        return view('admin.clients.index', compact('clients'));
    }

    public function create(): View
    {
        return view('admin.clients.form', [
            'client' => new Client(),
            'isEdit' => false,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'logo' => ['required', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:2048'],
            'is_active' => ['nullable', 'boolean'],
            'sort_order' => ['required', 'integer'],
        ]);

        $file = $request->file('logo');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('images/clients'), $filename);
        $logoPath = 'images/clients/' . $filename;

        Client::create([
            'name' => $validated['name'],
            'logo' => $logoPath,
            'is_active' => $request->boolean('is_active', true),
            'sort_order' => $validated['sort_order'],
        ]);

        return redirect()->route('admin.clients.index')
            ->with('success', 'Logo mitra/klien baru berhasil ditambahkan!');
    }

    public function edit(Client $client): View
    {
        return view('admin.clients.form', [
            'client' => $client,
            'isEdit' => true,
        ]);
    }

    public function update(Request $request, Client $client): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:2048'],
            'is_active' => ['nullable', 'boolean'],
            'sort_order' => ['required', 'integer'],
        ]);

        $logoPath = $client->logo;

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/clients'), $filename);
            $logoPath = 'images/clients/' . $filename;
        }

        $client->update([
            'name' => $validated['name'],
            'logo' => $logoPath,
            'is_active' => $request->boolean('is_active'),
            'sort_order' => $validated['sort_order'],
        ]);

        return redirect()->route('admin.clients.index')
            ->with('success', "Data klien {$client->name} berhasil diperbarui!");
    }

    public function destroy(Client $client): RedirectResponse
    {
        $name = $client->name;
        $client->delete();

        return redirect()->route('admin.clients.index')
            ->with('success', "Klien {$name} berhasil dihapus!");
    }
}
