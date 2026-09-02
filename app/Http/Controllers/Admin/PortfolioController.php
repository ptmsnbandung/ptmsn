<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;

class PortfolioController extends Controller
{
    public function index(): View
    {
        $portfolios = Portfolio::orderBy('sort_order')->get();
        return view('admin.portfolios.index', compact('portfolios'));
    }

    public function create(): View
    {
        return view('admin.portfolios.form', [
            'portfolio' => new Portfolio(),
            'isEdit' => false,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'url' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:4096'],
            'is_active' => ['nullable', 'boolean'],
            'sort_order' => ['required', 'integer'],
        ]);

        $imagePath = 'images/portfolio/sinopel.png';

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/portfolio'), $filename);
            $imagePath = 'images/portfolio/' . $filename;
        }

        Portfolio::create([
            'title' => $validated['title'],
            'category' => $validated['category'],
            'description' => $validated['description'],
            'url' => $validated['url'] ?: '#',
            'image' => $imagePath,
            'is_active' => $request->boolean('is_active', true),
            'sort_order' => $validated['sort_order'],
        ]);

        return redirect()->route('admin.portfolios.index')
            ->with('success', 'Proyek portofolio baru berhasil ditambahkan!');
    }

    public function edit(Portfolio $portfolio): View
    {
        return view('admin.portfolios.form', [
            'portfolio' => $portfolio,
            'isEdit' => true,
        ]);
    }

    public function update(Request $request, Portfolio $portfolio): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'url' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:4096'],
            'is_active' => ['nullable', 'boolean'],
            'sort_order' => ['required', 'integer'],
        ]);

        $imagePath = $portfolio->image;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/portfolio'), $filename);
            $imagePath = 'images/portfolio/' . $filename;
        }

        $portfolio->update([
            'title' => $validated['title'],
            'category' => $validated['category'],
            'description' => $validated['description'],
            'url' => $validated['url'] ?: '#',
            'image' => $imagePath,
            'is_active' => $request->boolean('is_active'),
            'sort_order' => $validated['sort_order'],
        ]);

        return redirect()->route('admin.portfolios.index')
            ->with('success', "Portofolio {$portfolio->title} berhasil diperbarui!");
    }

    public function destroy(Portfolio $portfolio): RedirectResponse
    {
        $title = $portfolio->title;
        $portfolio->delete();

        return redirect()->route('admin.portfolios.index')
            ->with('success', "Portofolio {$title} berhasil dihapus!");
    }
}
