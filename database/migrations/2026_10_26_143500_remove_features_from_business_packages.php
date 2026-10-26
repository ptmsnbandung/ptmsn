<?php

use App\Models\Package;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $packageUpdates = [
            'UMKM BASIC' => [
                'Unlimited Akses (Tanpa FUP)',
                'Bantuan Prioritas 24/7',
            ],
            'UMKM PLUS' => [
                'Unlimited Akses (Tanpa FUP)',
                'SLA Bisnis Terjamin',
            ],
            'BISNIS PRO' => [
                'Unlimited Akses (Tanpa FUP)',
                'SLA Bisnis 99.5%',
            ],
            'BISNIS ENTERPRISE' => [
                'Unlimited Akses (Tanpa FUP)',
                'Dedicated NOC & SLA 99.8%',
            ],
        ];

        foreach ($packageUpdates as $name => $features) {
            Package::where('name', $name)->update([
                'features' => json_encode($features),
            ]);
        }

        // Clean up any remaining 'Fiber Optic 1:1 Simetris' in other packages if present
        $allPackages = Package::all();
        foreach ($allPackages as $pkg) {
            if (!empty($pkg->features) && is_array($pkg->features)) {
                $cleaned = array_map(function ($feat) {
                    if (trim($feat) === 'Fiber Optic 1:1 Simetris') {
                        return 'Fast Network Fiber Optic';
                    }
                    return $feat;
                }, $pkg->features);

                if ($cleaned !== $pkg->features) {
                    $pkg->features = array_values($cleaned);
                    $pkg->save();
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Re-seed original features if rolled back
        $packageRollbacks = [
            'UMKM BASIC' => [
                'Unlimited Akses (Tanpa FUP)',
                'Fast Network Fiber Optic',
                'Router Gigabit Dual-Band ONT',
                'Bantuan Prioritas 24/7',
            ],
            'UMKM PLUS' => [
                'Unlimited Akses (Tanpa FUP)',
                'Fast Network Fiber Optic',
                'IP Static / Dedicated Ready',
                'SLA Bisnis Terjamin',
            ],
            'BISNIS PRO' => [
                'Unlimited Akses (Tanpa FUP)',
                'Fast Network Fiber Optic',
                'IP Dedicated Bisnis',
                'SLA Bisnis 99.5%',
            ],
            'BISNIS ENTERPRISE' => [
                'Unlimited Akses (Tanpa FUP)',
                'Fast Network Fiber Optic',
                'IP Dedicated Bisnis',
                'Dedicated NOC & SLA 99.8%',
            ],
        ];

        foreach ($packageRollbacks as $name => $features) {
            Package::where('name', $name)->update([
                'features' => json_encode($features),
            ]);
        }
    }
};
