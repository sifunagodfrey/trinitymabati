<?php

namespace App\Http\Controllers\Manage\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class OptimizationController extends Controller
{
    // ---------------
    // Show Optimization Tools and System Info
    // ---------------
    public function index()
    {
        $systemInfo = [
            'php_version'     => phpversion(),
            'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown',
            'memory_limit'    => ini_get('memory_limit'),
            'max_upload_size' => ini_get('upload_max_filesize'),
        ];

        return view('manage.settings.optimization.index', compact('systemInfo'));
    }

    // ---------------
    // Clear Application Cache
    // Runs: cache:clear, config:clear, view:clear, route:clear, event:clear
    // ---------------
    public function clearCache()
    {
        $commands = [
            'cache:clear'  => 'Application cache',
            'config:clear' => 'Config cache',
            'view:clear'   => 'Compiled views',
            'route:clear'  => 'Route cache',
            'event:clear'  => 'Event cache',
        ];

        $cleared = [];
        $failed  = [];

        foreach ($commands as $command => $label) {
            try {
                Artisan::call($command);
                $cleared[] = $label;
            } catch (Throwable $e) {
                $failed[] = $label;
                Log::warning("Optimization: {$command} failed - " . $e->getMessage());
            }
        }

        if (empty($failed)) {
            $message = 'All caches cleared successfully: ' . implode(', ', $cleared) . '.';
            return redirect()->route('manage.settings.optimization.index')
                ->with('success', $message);
        }

        $message = 'Cleared: ' . implode(', ', $cleared) . '. '
                 . 'Could not clear: ' . implode(', ', $failed) . ' (may already be empty or not cached).';

        return redirect()->route('manage.settings.optimization.index')
            ->with('info', $message);
    }

    // ---------------
    // Optimize Assets (build step required outside the application)
    // ---------------
    public function optimizeAssets()
    {
        return redirect()->route('manage.settings.optimization.index')
            ->with('info', 'To minify assets, run "npm run build" in the terminal. Asset compilation cannot be triggered from the admin panel.');
    }

    // ---------------
    // Clean Expired Sessions and Temp Data
    // ---------------
    public function cleanDatabase()
    {
        $deleted  = [];
        $errors   = [];

        // Remove expired POS sessions
        try {
            $count = DB::table('su_sessions')->where('status', 'expired')->count();
            DB::table('su_sessions')->where('status', 'expired')->delete();
            $deleted[] = "{$count} expired POS session(s)";
        } catch (Throwable $e) {
            $errors[] = 'POS sessions';
            Log::warning('Optimization: su_sessions cleanup failed - ' . $e->getMessage());
        }

        // Remove Laravel framework sessions (if using database driver)
        try {
            $count = DB::table('sessions')
                ->where('last_activity', '<', now()->subHours(24)->timestamp)
                ->count();
            DB::table('sessions')
                ->where('last_activity', '<', now()->subHours(24)->timestamp)
                ->delete();
            $deleted[] = "{$count} stale framework session(s)";
        } catch (Throwable $e) {
            // Silently skip - table may not exist if using file sessions
            Log::info('Optimization: sessions table not found or not applicable.');
        }

        // Remove stale pending M-Pesa records older than 24 hours
        try {
            $count = DB::table('su_pending_mpesa')
                ->where('created_at', '<', now()->subHours(24))
                ->count();
            DB::table('su_pending_mpesa')
                ->where('created_at', '<', now()->subHours(24))
                ->delete();
            $deleted[] = "{$count} stale pending M-Pesa record(s)";
        } catch (Throwable $e) {
            Log::info('Optimization: su_pending_mpesa cleanup skipped - ' . $e->getMessage());
        }

        // Remove stale pending wallet M-Pesa records older than 24 hours
        try {
            $count = DB::table('su_pending_wallet_mpesa')
                ->where('created_at', '<', now()->subHours(24))
                ->count();
            DB::table('su_pending_wallet_mpesa')
                ->where('created_at', '<', now()->subHours(24))
                ->delete();
            $deleted[] = "{$count} stale pending wallet M-Pesa record(s)";
        } catch (Throwable $e) {
            Log::info('Optimization: su_pending_wallet_mpesa cleanup skipped - ' . $e->getMessage());
        }

        if (!empty($errors)) {
            return redirect()->route('manage.settings.optimization.index')
                ->with('error', 'Some cleanup tasks failed: ' . implode(', ', $errors) . '. Check logs for details.');
        }

        $summary = empty($deleted)
            ? 'Database is already clean. Nothing to remove.'
            : 'Cleaned: ' . implode(', ', $deleted) . '.';

        return redirect()->route('manage.settings.optimization.index')
            ->with('success', $summary);
    }
}