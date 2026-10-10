<?php

namespace App\Http\Controllers;

use App\Models\CoverageArea;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class CoverageController extends Controller
{
    /**
     * Get all ODP points from database (gomsn.odp1, odp2, odp3 or fallback).
     */
    public function getOdps(): array
    {
        return Cache::remember('gomsn_coverage_odps_v2', 1800, function () {
            $odps = collect();

            try {
                if (Schema::hasTable('gomsn.olt')) {
                $olts = DB::table('gomsn.olt')->orderBy('olt_id', 'asc')->get();

                foreach ($olts as $olt) {
                    $odpTable = "gomsn.odp{$olt->olt_id}";
                    $ponTable = "gomsn.pon{$olt->olt_id}";
                    $userTable = "gomsn.users{$olt->olt_id}";

                    if (Schema::hasTable($odpTable)) {
                        $pons = Schema::hasTable($ponTable) ? DB::table($ponTable)->get()->keyBy('id') : collect();
                        $userCounts = Schema::hasTable($userTable) 
                            ? DB::table($userTable)->select('odp_id', DB::raw('count(*) as total'))->groupBy('odp_id')->pluck('total', 'odp_id') 
                            : collect();

                        $odpRows = DB::table($odpTable)->get();
                        foreach ($odpRows as $odp) {
                            $rawLat = $odp->latitude;
                            $rawLng = $odp->longitude;

                            $lat = null;
                            $lng = null;

                            if ($rawLat !== null && $rawLat !== '' && is_numeric($rawLat)) {
                                $lat = (float) $rawLat;
                            }
                            if ($rawLng !== null && $rawLng !== '' && is_numeric($rawLng)) {
                                $lng = (float) $rawLng;
                            }

                            // Normalisasi typo koordinat (contoh: -703585 -> -7.03585)
                            if ($lat !== null) {
                                if ($lat < -1000) {
                                    while ($lat < -90) $lat /= 10;
                                } elseif ($lat > 1000) {
                                    while ($lat > 180) $lat /= 10;
                                }
                            }
                            if ($lng !== null) {
                                if ($lng > 1000) {
                                    while ($lng > 180) $lng /= 10;
                                }
                            }

                            // Normalisasi jika koordinat tertukar
                            if ($lat !== null && $lng !== null) {
                                if ($lat > 0 && $lng < 0) {
                                    $temp = $lat;
                                    $lat = $lng;
                                    $lng = $temp;
                                }
                            }

                            // Lewatkan jika kosong atau di luar batas Indonesia
                            if ($lat === null || $lng === null || $lat > 0 || $lat < -15 || $lng < 90 || $lng > 145) {
                                continue;
                            }

                            $pon = $pons->get($odp->pon_id);
                            $ponName = $pon->nama_pon ?? "PON #{$odp->pon_id}";
                            $used = (int) ($userCounts->get($odp->id, 0));
                            $max = (int) ($odp->port_max ?? 8);
                            if ($max <= 0) $max = 8;

                            $code = "ODP-OLT{$olt->olt_id}-#{$odp->id}";
                            $name = $odp->nama_odp ?: "ODP #{$odp->id}";
                            $oltName = strtoupper($olt->nama_olt ?? "OLT {$olt->olt_id}");

                            $odps->push([
                                'id' => $odp->id,
                                'olt_id' => $olt->olt_id,
                                'olt_name' => $oltName,
                                'kode_odp' => $code,
                                'name_odp' => $name,
                                'code' => $code,
                                'name' => $name,
                                'display_name' => "{$name} ({$oltName} - {$ponName})",
                                'kode_pon' => $ponName,
                                'pon_name' => $ponName,
                                'capacity_odp' => $max,
                                'total_ports' => $max,
                                'used_ports' => $used,
                                'has_slot' => $used < $max,
                                'latitude' => $lat,
                                'longitude' => $lng,
                                'lat' => $lat,
                                'lng' => $lng,
                                'note_odp' => "OLT: {$oltName} | Port: {$ponName} | Terpakai: {$used}/{$max} Port",
                                'note' => "OLT: {$oltName} | Port: {$ponName}",
                                'status' => 'active',
                            ]);
                        }
                    }
                }
            }
        } catch (\Throwable $e) {
            Log::warning("Coverage ODP gomsn fetch warning: " . $e->getMessage());
        }

            return $odps->values()->toArray();
        });
    }

    /**
     * Check network coverage for a given location / coordinates or search query.
     */
    public function check(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'query' => ['nullable', 'string', 'max:255'],
            'lat' => ['nullable', 'numeric'],
            'lng' => ['nullable', 'numeric'],
        ]);

        $query = trim($validated['query'] ?? '');
        $lat = isset($validated['lat']) ? (float) $validated['lat'] : null;
        $lng = isset($validated['lng']) ? (float) $validated['lng'] : null;

        // Extract coordinates from query if passed as "lat, lng"
        if (($lat === null || $lng === null) && preg_match('/^\s*(-?\d+(\.\d+)?)\s*,\s*(-?\d+(\.\d+)?)\s*$/', $query, $matches)) {
            $lat = (float) $matches[1];
            $lng = (float) $matches[3];
        }

        $allOdps = $this->getOdps();
        $waNumber = config('company.whatsapp', '6289696629955');

        // Case 1: Coordinate-based GIS precision distance calculation
        if ($lat !== null && $lng !== null) {
            $nearest = null;
            $minDist = PHP_FLOAT_MAX;

            foreach ($allOdps as $odp) {
                $d = $this->calculateDistanceMeters($lat, $lng, $odp['lat'], $odp['lng']);
                if ($d < $minDist) {
                    $minDist = $d;
                    $nearest = $odp;
                }
            }

            if ($nearest) {
                $distMeters = round($minDist);
                $isCovered = $distMeters <= 300;
                $level = 'uncovered';
                $levelTitle = 'Di Luar Radius ODP (> 300m)';

                if ($distMeters <= 150) {
                    $level = 'excellent';
                    $levelTitle = 'Sangat Bagus (Optimal FTTH)';
                } elseif ($distMeters <= 250) {
                    $level = 'good';
                    $levelTitle = 'Bagus (Layak Pasang)';
                } elseif ($distMeters <= 300) {
                    $level = 'moderate';
                    $levelTitle = 'Batas Jangkauan ODP';
                }

                $msg = $isCovered 
                    ? "Halo PT Media Solusi Network, saya telah mengecek coverage di website pada koordinat {$lat}, {$lng}. Lokasi saya berjarak {$distMeters} meter dari {$nearest['name']} ({$nearest['code']}). Mohon informasi paket dan jadwal pemasangannya."
                    : "Halo PT Media Solusi Network, saya mengecek koordinat {$lat}, {$lng} (jarak {$distMeters}m dari {$nearest['name']}). Saya ingin mengajukan request perluasan ODP ke lokasi saya.";

                return response()->json([
                    'success' => true,
                    'status' => $isCovered ? 'covered' : 'uncovered',
                    'is_covered' => $isCovered,
                    'coverage_level' => $level,
                    'level_title' => $levelTitle,
                    'distance_meters' => $distMeters,
                    'title' => $isCovered ? "Lokasi Tercover Jaringan ({$distMeters}m ke ODP)" : "Lokasi Berjarak {$distMeters}m dari ODP Terdekat",
                    'message' => $isCovered 
                        ? "Lokasi Anda berjarak {$distMeters}m dari {$nearest['name']} ({$nearest['olt_name']}). Jalur distribusi kabel dropcore siap ditarik."
                        : "Lokasi Anda berjarak {$distMeters}m dari {$nearest['name']}. Melebihi radius standar 300m, namun tim ekspansi kami dapat melakukan survei penambahan tiang/ODP baru.",
                    'nearest_odp' => $nearest,
                    'target_coords' => ['lat' => $lat, 'lng' => $lng],
                    'whatsapp_url' => 'https://wa.me/' . $waNumber . '?text=' . urlencode($msg),
                ]);
            }
        }

        // Case 2: Text search against CoverageArea database
        $matchedArea = CoverageArea::query()
            ->where(function ($q) use ($query) {
                $q->where('city', 'LIKE', "%{$query}%")
                  ->orWhere('district', 'LIKE', "%{$query}%")
                  ->orWhere('village', 'LIKE', "%{$query}%")
                  ->orWhere('postal_code', 'LIKE', "%{$query}%");
            })
            ->first();

        if ($matchedArea && $matchedArea->status === 'covered') {
            $msg = "Halo PT Media Solusi Network, saya ingin berlangganan internet di area: {$matchedArea->village}, Kec. {$matchedArea->district}, {$matchedArea->city}. Mohon informasi paket dan pemasangannya.";
            return response()->json([
                'success' => true,
                'status' => 'covered',
                'is_covered' => true,
                'coverage_level' => 'good',
                'title' => 'Wilayah Tercover Jaringan Fiber Optic!',
                'message' => "Kabar baik! Area {$matchedArea->village}, Kec. {$matchedArea->district}, {$matchedArea->city} telah terhubung dengan infrastruktur Fiber Optic PT Media Solusi Network.",
                'details' => [
                    'city' => $matchedArea->city,
                    'district' => $matchedArea->district,
                    'village' => $matchedArea->village,
                    'postal_code' => $matchedArea->postal_code ?? '-',
                    'notes' => $matchedArea->notes ?? 'Fiber Optic Ready',
                ],
                'whatsapp_url' => 'https://wa.me/' . $waNumber . '?text=' . urlencode($msg),
            ]);
        }

        $uncoveredMsg = "Halo PT Media Solusi Network, saya ingin mengajukan permohonan perluasan jaringan fiber optik untuk wilayah: {$query}. Mohon informasikan jika area kami sudah dapat dipasang.";
        return response()->json([
            'success' => false,
            'status' => 'uncovered',
            'is_covered' => false,
            'coverage_level' => 'uncovered',
            'title' => 'Lokasi Belum Tercover Secara Langsung',
            'message' => "Saat ini lokasi '{$query}' belum terjangkau secara langsung oleh jalur distribusi fiber kami. Ajukan request perluasan area agar tim survei kami memprioritaskan wilayah Anda.",
            'whatsapp_url' => 'https://wa.me/' . $waNumber . '?text=' . urlencode($uncoveredMsg),
        ]);
    }

    /**
     * Get all ODP points as JSON for client-side map rendering.
     */
    public function odps(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'odps' => $this->getOdps(),
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

    /**
     * Calculate geodesic distance between 2 coordinates in meters (Haversine formula).
     */
    private function calculateDistanceMeters(float $lat1, float $lon1, float $lat2, float $lon2): float
    {
        $earthRadius = 6371000; // meters

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }
}
