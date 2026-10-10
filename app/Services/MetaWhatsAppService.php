<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MetaWhatsAppService
{
    protected ?string $token;
    protected ?string $phoneNumberId;
    protected ?string $businessAccountId;
    protected string $apiVersion;
    protected string $templateName;
    protected string $templateLang;

    public function __construct()
    {
        $this->token = config('services.meta_wa.token');
        $this->phoneNumberId = config('services.meta_wa.phone_number_id');
        $this->businessAccountId = config('services.meta_wa.business_account_id');
        $this->apiVersion = config('services.meta_wa.api_version', 'v25.0') ?: 'v25.0';
        $this->templateName = config('services.meta_wa.template_name', 'vertifikasi') ?: 'vertifikasi';
        $this->templateLang = config('services.meta_wa.template_lang', 'en_US') ?: 'en_US';
    }

    /**
     * Cek apakah konfigurasi Meta WA API sudah lengkap
     */
    public function isConfigured(): bool
    {
        return !empty($this->token) && !empty($this->phoneNumberId);
    }

    /**
     * Format nomor HP ke standar internasional WhatsApp (misal: 6281234567890)
     */
    public static function formatPhoneNumber(string $phone): string
    {
        $digits = preg_replace('/[^0-9]/', '', $phone);

        if (str_starts_with($digits, '0')) {
            $digits = '62' . substr($digits, 1);
        } elseif (str_starts_with($digits, '8')) {
            $digits = '62' . $digits;
        }

        return $digits;
    }

    /**
     * Samarkan nomor HP untuk ditampilkan ke user (misal: 0812••••7890)
     */
    public static function maskPhoneNumber(string $phone): string
    {
        $clean = preg_replace('/[^0-9]/', '', $phone);
        if (str_starts_with($clean, '62')) {
            $clean = '0' . substr($clean, 2);
        }

        $len = strlen($clean);
        if ($len <= 7) {
            return $clean;
        }

        $start = substr($clean, 0, 4);
        $end = substr($clean, -3);
        $masked = str_repeat('•', max(3, $len - 7));

        return $start . $masked . $end;
    }

    /**
     * Kirim template kode OTP verifikasi WhatsApp menggunakan Meta Cloud API
     */
    public function sendOtp(string $recipientPhone, string $otpCode): array
    {
        $targetNumber = self::formatPhoneNumber($recipientPhone);

        if (empty($targetNumber)) {
            return [
                'success' => false,
                'message' => 'Nomor telepon tidak valid.',
            ];
        }

        // Jika belum dikonfigurasi di environment lokal / staging
        if (!$this->isConfigured()) {
            Log::info("Meta WhatsApp Cloud API belum dikonfigurasi di .env. OTP untuk {$targetNumber}: {$otpCode}");
            
            // Pada environment lokal / testing, kita izinkan proses berjalan untuk debugging
            if (app()->environment('local', 'testing')) {
                return [
                    'success' => true,
                    'message' => 'OTP berhasil dibuat (Mode Pengujian Lokal: ' . $otpCode . ')',
                    'debug_otp' => $otpCode,
                ];
            }

            return [
                'success' => false,
                'message' => 'Layanan WhatsApp belum dikonfigurasi di server. Silakan hubungi admin atau login menggunakan Nomor Internet.',
            ];
        }

        $endpoint = "https://graph.facebook.com/{$this->apiVersion}/{$this->phoneNumberId}/messages";

        // Daftar strategi payload untuk template Authentication:
        // 1. Language en_US dengan body + button url copy code
        // 2. Language en_US dengan body saja
        // 3. Language en dengan body + button url
        // 4. Language en dengan body saja
        // 5. Language en_US dengan button sub_type copy_code
        $strategies = [
            // Strategi 1: en_US dengan body + button url
            [
                'lang' => $this->templateLang,
                'components' => [
                    [
                        'type' => 'body',
                        'parameters' => [
                            ['type' => 'text', 'text' => $otpCode],
                        ],
                    ],
                    [
                        'type' => 'button',
                        'sub_type' => 'url',
                        'index' => '0',
                        'parameters' => [
                            ['type' => 'text', 'text' => $otpCode],
                        ],
                    ],
                ],
            ],
            // Strategi 2: en_US dengan body parameter saja
            [
                'lang' => $this->templateLang,
                'components' => [
                    [
                        'type' => 'body',
                        'parameters' => [
                            ['type' => 'text', 'text' => $otpCode],
                        ],
                    ],
                ],
            ],
            // Strategi 3: Fallback bahasa "en" jika di Meta Manager hanya "English" (en)
            [
                'lang' => 'en',
                'components' => [
                    [
                        'type' => 'body',
                        'parameters' => [
                            ['type' => 'text', 'text' => $otpCode],
                        ],
                    ],
                    [
                        'type' => 'button',
                        'sub_type' => 'url',
                        'index' => '0',
                        'parameters' => [
                            ['type' => 'text', 'text' => $otpCode],
                        ],
                    ],
                ],
            ],
            // Strategi 4: Fallback bahasa "en" body parameter saja
            [
                'lang' => 'en',
                'components' => [
                    [
                        'type' => 'body',
                        'parameters' => [
                            ['type' => 'text', 'text' => $otpCode],
                        ],
                    ],
                ],
            ],
            // Strategi 5: sub_type copy_code (WhatsApp Auth API v19+)
            [
                'lang' => $this->templateLang,
                'components' => [
                    [
                        'type' => 'body',
                        'parameters' => [
                            ['type' => 'text', 'text' => $otpCode],
                        ],
                    ],
                    [
                        'type' => 'button',
                        'sub_type' => 'copy_code',
                        'index' => '0',
                        'parameters' => [
                            ['type' => 'coupon_code', 'coupon_code' => $otpCode],
                        ],
                    ],
                ],
            ],
        ];

        $lastError = null;

        foreach ($strategies as $index => $strategy) {
            $payload = [
                'messaging_product' => 'whatsapp',
                'recipient_type' => 'individual',
                'to' => $targetNumber,
                'type' => 'template',
                'template' => [
                    'name' => $this->templateName,
                    'language' => [
                        'code' => $strategy['lang'],
                    ],
                    'components' => $strategy['components'],
                ],
            ];

            try {
                $response = Http::withToken($this->token)
                    ->acceptJson()
                    ->timeout(12)
                    ->post($endpoint, $payload);

                $json = $response->json();

                if ($response->successful() && !empty($json['messages'])) {
                    Log::info("Meta WA OTP berhasil terkirim ke {$targetNumber} menggunakan strategi #{$index} (Lang: {$strategy['lang']}). Message ID: " . ($json['messages'][0]['id'] ?? '-'));
                    return [
                        'success' => true,
                        'message' => 'Kode OTP berhasil dikirim ke nomor WhatsApp Anda.',
                        'data' => $json,
                    ];
                }

                $errorDetails = $json['error'] ?? null;
                $lastError = $errorDetails['message'] ?? $response->body();
                Log::warning("Meta WA OTP percobaan strategi #{$index} gagal: " . json_encode($errorDetails));

                // Jika error bukan karena format template/button/language, hentikan percobaan
                $errorCode = $errorDetails['code'] ?? 0;
                $errorSubcode = $errorDetails['error_subcode'] ?? 0;

                // Error token tidak valid (190) atau phone number id salah (100)
                if (in_array($errorCode, [190, 100]) && !str_contains($lastError, 'template')) {
                    break;
                }
            } catch (\Throwable $e) {
                $lastError = $e->getMessage();
                Log::error("Koneksi ke Meta WhatsApp API gagal pada percobaan #{$index}: " . $e->getMessage());
            }
        }

        return [
            'success' => false,
            'message' => 'Gagal mengirim kode verifikasi WhatsApp: ' . ($lastError ?: 'Terjadi kesalahan pada Meta API.'),
        ];
    }
}
