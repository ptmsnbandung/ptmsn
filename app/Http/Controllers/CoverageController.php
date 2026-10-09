<?php

namespace App\Http\Controllers;

use App\Models\CoverageArea;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CoverageController extends Controller
{
    /**
     * Check network coverage for a given location or customer ID.
     */
    public function check(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'query' => ['required', 'string', 'min:2', 'max:150'],
        ], [
            'query.required' => 'Silakan masukkan kota, kecamatan, kelurahan, atau kode pos lokasi Anda.',
            'query.min' => 'Pencarian minimal 2 karakter.',
        ]);

        $query = trim($validated['query']);

        // Search coverage areas matching city, district, village, or postal code
        $matchedArea = CoverageArea::query()
            ->where(function ($q) use ($query) {
                $q->where('city', 'LIKE', "%{$query}%")
                  ->orWhere('district', 'LIKE', "%{$query}%")
                  ->orWhere('village', 'LIKE', "%{$query}%")
                  ->orWhere('postal_code', 'LIKE', "%{$query}%");
            })
            ->first();

        $waNumber = config('company.whatsapp', '6289696629955');

        if ($matchedArea && $matchedArea->status === 'covered') {
            $msg = "Halo PT Media Solusi Network, saya telah mengecek jaringan di website dan ingin berlangganan internet di area: {$matchedArea->village}, Kec. {$matchedArea->district}, {$matchedArea->city}. Mohon informasi promo & jadwal pemasangannya.";
            return response()->json([
                'success' => true,
                'status' => 'covered',
                'title' => 'Lokasi Anda Tercover Jaringan Fiber Optic!',
                'message' => "Kabar baik! Wilayah {$matchedArea->village}, Kec. {$matchedArea->district}, {$matchedArea->city} telah terhubung dengan jaringan Fiber Optic berkecepatan tinggi PT Media Solusi Network dan siap untuk instalasi.",
                'details' => [
                    'city' => $matchedArea->city,
                    'district' => $matchedArea->district,
                    'village' => $matchedArea->village,
                    'postal_code' => $matchedArea->postal_code ?? '-',
                    'notes' => $matchedArea->notes ?? 'Fiber Optic High Speed 100% Ready',
                ],
                'whatsapp_url' => 'https://wa.me/' . $waNumber . '?text=' . urlencode($msg),
            ]);
        }

        $uncoveredMsg = "Halo PT Media Solusi Network, saya ingin mengajukan permohonan perluasan jaringan fiber optik untuk wilayah: {$query}. Mohon informasikan jika area kami sudah dapat dipasang.";
        return response()->json([
            'success' => false,
            'status' => 'uncovered',
            'title' => 'Lokasi Belum Tercover Secara Langsung',
            'message' => "Saat ini lokasi '{$query}' belum terjangkau secara langsung oleh jalur distribusi fiber kami. Namun Anda dapat mengajukan request perluasan area agar tim ekspansi jaringan kami memprioritaskan wilayah Anda.",
            'whatsapp_url' => 'https://wa.me/' . $waNumber . '?text=' . urlencode($uncoveredMsg),
        ]);
    }

    /**
     * Get list of covered areas for search suggestions.
     */
    public function areas(): JsonResponse
    {
        $areas = CoverageArea::where('status', 'covered')
            ->orderBy('city')
            ->orderBy('district')
            ->get();

        return response()->json([
            'success' => true,
            'areas' => $areas,
        ]);
    }
}
