<?php

namespace App\Providers;

use App\Session\SafeDatabaseSessionHandler;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Illuminate\Pagination\Paginator::useTailwind();

        // 1. Extend driver database session agar aman dari SQL Error 1366 saat user_id adalah string non-numeric (seperti ID pelanggan 'MS...')
        Session::extend('database', function ($app) {
            $table = $app['config']->get('session.table');
            $lifetime = $app['config']->get('session.lifetime');
            $connection = $app['db']->connection($app['config']->get('session.connection'));

            return new SafeDatabaseSessionHandler(
                $connection, $table, $lifetime, $app
            );
        });

        // 2. Auto-patch skema sessions.user_id di database production jika belum di-alter
        try {
            if (!Cache::has('db_sessions_user_id_string_patched_v1')) {
                DB::statement("ALTER TABLE `sessions` MODIFY `user_id` VARCHAR(255) NULL");
                Cache::forever('db_sessions_user_id_string_patched_v1', true);
            }
        } catch (\Throwable $e) {
            // Abaikan jika tidak ada izin ALTER atau sudah sesuai
        }
    }
}
