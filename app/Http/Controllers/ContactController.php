<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    /**
     * Store a contact inquiry message.
     */
    public function store(Request $request): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150'],
            'whatsapp' => ['required', 'string', 'max:20'],
            'subjek' => ['required', 'string', 'max:150'],
            'pesan' => ['required', 'string', 'max:2000'],
        ], [
            'nama.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'whatsapp.required' => 'Nomor WhatsApp wajib diisi.',
            'subjek.required' => 'Subjek pesan wajib diisi.',
            'pesan.required' => 'Pesan wajib diisi.',
        ]);

        try {
            ContactMessage::create([
                'name' => $validated['nama'],
                'email' => $validated['email'],
                'whatsapp' => $validated['whatsapp'],
                'subject' => $validated['subjek'],
                'message' => $validated['pesan'],
                'status' => 'unread',
            ]);

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Pesan berhasil dikirim. Tim PT Media Solusi Network akan segera menghubungi Anda.',
                ]);
            }

            return redirect()->back()->with('success', 'Pesan berhasil dikirim. Tim kami akan segera menghubungi Anda.');
        } catch (\Throwable $e) {
            Log::error('Error saving contact message: ' . $e->getMessage());

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan. Silakan coba kembali nanti.',
                ], 500);
            }

            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan. Silakan coba kembali.');
        }
    }
}
