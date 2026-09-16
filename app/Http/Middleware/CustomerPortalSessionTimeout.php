<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CustomerPortalSessionTimeout
{
    /**
     * Handle an incoming request.
     * Mengatur batas waktu (timeout) sesi portal pelanggan otomatis logout setelah 1 jam (3600 detik).
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::guard('customer')->check()) {
            $lastActivity = session('customer_last_activity');
            $timeoutSeconds = 3600; // 1 jam

            if ($lastActivity && (time() - $lastActivity) > $timeoutSeconds) {
                Auth::guard('customer')->logout();
                $request->session()->forget('customer_last_activity');
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('portal.login')
                    ->with('warning', 'Sesi login Anda telah berakhir otomatis karena tidak ada aktivitas selama 1 jam. Silakan masuk kembali.');
            }

            // Perbarui penanda waktu aktivitas terakhir
            session(['customer_last_activity' => time()]);
        }

        return $next($request);
    }
}
