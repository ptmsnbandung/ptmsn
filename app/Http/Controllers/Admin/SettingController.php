<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    /**
     * Show the website settings & copywriting editor.
     */
    public function index(Request $request): View
    {
        $group = $request->query('group', 'hero');
        
        $groups = [
            'hero' => 'Hero Section',
            'about' => 'Tentang Kami',
            'why_us' => 'Why MSN (Keunggulan)',
            'cta' => 'Banner CTA',
            'company' => 'Informasi Kontak & Perusahaan',
        ];

        $settings = SiteSetting::where('group', $group)->get();

        return view('admin.settings.index', compact('settings', 'group', 'groups'));
    }

    /**
     * Update settings.
     */
    public function update(Request $request): RedirectResponse
    {
        $data = $request->except(['_token', '_method', 'group']);
        $group = $request->input('group', 'hero');

        foreach ($data as $key => $value) {
            SiteSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        SiteSetting::clearCache();

        return redirect()->route('admin.settings.index', ['group' => $group])
            ->with('success', 'Konten website berhasil diperbarui dan disimpan!');
    }
}
