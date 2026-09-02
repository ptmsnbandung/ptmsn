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

        if ($matchedArea && $matchedArea->status === 'covered') {
            return response()->json([
                'success' => true,
                'status' => 'covered',
                'title' => 'Lokasi Tercover Jaringan!',
                'message' => "Kabar baik! Wilayah {$matchedArea->village}, Kec. {$matchedArea->district}, {$matchedArea->city} telah tercover oleh jaringan Fiber Optic PT Media Solusi Network.",
                'details' => [
                    'city' => $matchedArea->city,
                    'district' => $matchedArea->district,
                    'village' => $matchedArea->village,
                    'notes' => $matchedArea->notes ?? 'Fiber Optic High Speed Ready',
                ],
            ]);
        }

        return response()->json([
            'success' => false,
            'status' => 'uncovered',
            'title' => 'Lokasi Belum Tercover',
            'message' => "Maaf, lokasi '{$query}' saat ini belum terjangkau oleh jaringan kami. Hubungi tim sales kami untuk registrasi minat dan percepatan perluasan area.",
        ]);
    }
}
