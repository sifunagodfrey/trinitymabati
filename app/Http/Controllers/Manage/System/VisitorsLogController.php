<?php

namespace App\Http\Controllers\Manage\System;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\ReportExportTrait;
use App\Models\Manage\System\VisitorLog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VisitorsLogController extends Controller
{
    use ReportExportTrait;
    // ---------------
    // Per-section page size
    // ---------------
    private int $perPage = 10;

    // ---------------
    // Index - handles the initial page load and AJAX load-more / search refresh
    // ---------------
    public function index(Request $request): mixed
    {
        $search = trim($request->input('search', ''));
        $isAjax = $request->boolean('ajax');

        // ---------------
        // Reset the badge - record when admin last viewed this page
        // ---------------
        if (!$isAjax) {
            DB::table('su_settings')->updateOrInsert(
                ['setting_key' => 'visitors_log_last_viewed_at'],
                ['setting_value' => now(), 'updated_at' => now()]
            );
        }

        if ($isAjax) {
            $type   = $request->input('type', '');
            $offset = max(0, (int) $request->input('offset', 0));

            return match ($type) {
                'visitors'      => $this->visitorsChunk($search, $offset),
                'top_pages'     => $this->topPagesChunk($search, $offset),
                'top_referrers' => $this->topReferrersChunk($search, $offset),
                default         => response()->json(['error' => 'Unknown section type'], 400),
            };
        }

        // ---------------
        // Summary stat: distinct sessions
        // ---------------
        $totalUniqueVisitors = VisitorLog::query()
            ->distinct()
            ->count('session_id');

        if ($request->input('export') === 'csv' || $request->input('export') === 'pdf') {
            $query = VisitorLog::query()
                ->leftJoin('su_users as u', 'su_visitors_logs.user_id', '=', 'u.id')
                ->when($search !== '', fn ($q) => $q->where(function ($inner) use ($search) {
                    $inner->where('su_visitors_logs.visited_url', 'like', "%{$search}%")
                          ->orWhere('su_visitors_logs.referrer_url', 'like', "%{$search}%")
                          ->orWhere('u.first_name', 'like', "%{$search}%")
                          ->orWhere('u.last_name', 'like', "%{$search}%");
                }))
                ->select(['su_visitors_logs.*', 'u.first_name', 'u.last_name'])
                ->orderByDesc('su_visitors_logs.visit_time');

            $reportRows = $query->get();

            if ($request->input('export') === 'csv') {
                $rows = $reportRows->map(function ($log) {
                    return [
                        $log->id,
                        trim(($log->first_name ?? '') . ' ' . ($log->last_name ?? '')) ?: 'Guest',
                        $log->ip_address,
                        $log->visited_url,
                        $log->referrer_url ?: 'Direct',
                        $log->visit_time,
                    ];
                })->toArray();

                return $this->exportCsv('visitors-log-' . now()->format('Ymd_His') . '.csv', [
                    'Log ID', 'Visitor', 'IP Address', 'Visited URL', 'Referrer URL', 'Visit Time'
                ], $rows);
            }

            $lines = [
                'Visitors Log Report',
                'Generated: ' . now()->format('Y-m-d H:i:s'),
                '',
                'Log ID | Visitor | IP Address | Visited URL | Referrer URL | Visit Time',
            ];

            foreach ($reportRows as $log) {
                $lines[] = sprintf(
                    '%s | %s | %s | %s | %s | %s',
                    $log->id,
                    trim(($log->first_name ?? '') . ' ' . ($log->last_name ?? '')) ?: 'Guest',
                    $log->ip_address ?? '-',
                    $log->visited_url ?? '-',
                    $log->referrer_url ?: 'Direct',
                    $log->visit_time ?? '-'
                );
            }

            return $this->exportPdf('visitors-log-' . now()->format('Ymd_His') . '.pdf', $lines);
        }

        // ---------------
        // Initial data - first chunk per section
        // ---------------
        [$visitorsRows, $visitorsTotal] = $this->fetchVisitors($search, 0);
        [$pagesRows, $pagesTotal]       = $this->fetchTopPages($search, 0);
        [$refsRows, $refsTotal]         = $this->fetchTopReferrers($search, 0);

        return view('manage.visitors-log.index', [
            'search'              => $search,
            'totalUniqueVisitors' => $totalUniqueVisitors,
            'visitorsRows'        => $visitorsRows,
            'visitorsTotal'       => $visitorsTotal,
            'visitorsHasMore'     => count($visitorsRows) < $visitorsTotal,
            'visitorsNext'        => count($visitorsRows),
            'pagesRows'           => $pagesRows,
            'pagesTotal'          => $pagesTotal,
            'pagesHasMore'        => count($pagesRows) < $pagesTotal,
            'pagesNext'           => count($pagesRows),
            'refsRows'            => $refsRows,
            'refsTotal'           => $refsTotal,
            'refsHasMore'         => count($refsRows) < $refsTotal,
            'refsNext'            => count($refsRows),
        ]);
    }

    // ---------------
    // AJAX: visitors list chunk
    // ---------------
    private function visitorsChunk(string $search, int $offset): JsonResponse
    {
        [$rows, $total] = $this->fetchVisitors($search, $offset);
        $next = $offset + count($rows);

        $html = '';
        foreach ($rows as $log) {
            $name = (($log->first_name ?? '') || ($log->last_name ?? ''))
                ? trim(($log->first_name ?? '') . ' ' . ($log->last_name ?? ''))
                : 'Guest';

            $nameEsc = e($name);
            $urlEsc  = e($log->visited_url ?? '');
            $refEsc  = e($log->referrer_url ?: 'Direct');
            $timeEsc = e($log->visit_time ?? '-');

            $html .= <<<HTML
<li class="px-4 py-3 border-b border-border last:border-0 hover:bg-slate-50">
    <div class="font-medium text-sm text-black">{$nameEsc}</div>
    <div class="text-xs mt-0.5"><span class="font-mono text-primary">{$urlEsc}</span></div>
    <div class="text-xs text-muted mt-0.5">Referrer: {$refEsc} &nbsp;&middot;&nbsp; {$timeEsc}</div>
</li>
HTML;
        }

        return response()->json([
            'html'       => $html,
            'hasMore'    => $next < $total,
            'nextOffset' => $next,
            'returned'   => count($rows),
            'total'      => $total,
        ]);
    }

    // ---------------
    // AJAX: top pages chunk
    // ---------------
    private function topPagesChunk(string $search, int $offset): JsonResponse
    {
        [$rows, $total] = $this->fetchTopPages($search, $offset);
        $next = $offset + count($rows);

        $html = '';
        foreach ($rows as $page) {
            $url    = e($page->visited_url ?? '');
            $visits = (int) $page->visits;

            $html .= <<<HTML
<li class="flex items-center justify-between px-3 py-2 border-b border-border last:border-0 hover:bg-slate-50">
    <span class="font-mono text-xs text-text truncate">{$url}</span>
    <span class="ml-3 shrink-0 inline-flex items-center rounded-[12px] bg-primary/10 text-primary text-xs px-2 py-0.5 font-semibold">{$visits}</span>
</li>
HTML;
        }

        return response()->json([
            'html'       => $html,
            'hasMore'    => $next < $total,
            'nextOffset' => $next,
            'returned'   => count($rows),
            'total'      => $total,
        ]);
    }

    // ---------------
    // AJAX: top referrers chunk
    // ---------------
    private function topReferrersChunk(string $search, int $offset): JsonResponse
    {
        [$rows, $total] = $this->fetchTopReferrers($search, $offset);
        $next = $offset + count($rows);

        $html = '';
        foreach ($rows as $ref) {
            $url       = e($ref->referrer_url ?? '');
            $referrals = (int) $ref->referrals;

            $html .= <<<HTML
<li class="flex items-center justify-between px-3 py-2 border-b border-border last:border-0 hover:bg-slate-50">
    <span class="font-mono text-xs text-text truncate">{$url}</span>
    <span class="ml-3 shrink-0 inline-flex items-center rounded-[12px] bg-emerald-100 text-emerald-800 text-xs px-2 py-0.5 font-semibold">{$referrals}</span>
</li>
HTML;
        }

        return response()->json([
            'html'       => $html,
            'hasMore'    => $next < $total,
            'nextOffset' => $next,
            'returned'   => count($rows),
            'total'      => $total,
        ]);
    }

    // ---------------
    // Query: all visitor rows with left-joined user name
    // ---------------
    private function fetchVisitors(string $search, int $offset): array
    {
        $build = function () use ($search) {
            $q = VisitorLog::query()
                ->leftJoin('su_users as u', 'su_visitors_logs.user_id', '=', 'u.id');
            if ($search !== '') {
                $q->where(function ($inner) use ($search) {
                    $inner->where('su_visitors_logs.visited_url', 'like', "%{$search}%")
                          ->orWhere('su_visitors_logs.referrer_url', 'like', "%{$search}%")
                          ->orWhere('u.first_name', 'like', "%{$search}%")
                          ->orWhere('u.last_name', 'like', "%{$search}%");
                });
            }
            return $q;
        };

        $total = $build()->count();
        $rows  = $build()
            ->select(['su_visitors_logs.*', 'u.first_name', 'u.last_name'])
            ->orderByDesc('su_visitors_logs.visit_time')
            ->offset($offset)
            ->limit($this->perPage)
            ->get();

        return [$rows, $total];
    }

    // ---------------
    // Query: pages grouped by visited_url, sorted by visit count
    // ---------------
    private function fetchTopPages(string $search, int $offset): array
    {
        $build = function () use ($search) {
            return VisitorLog::query()
                ->when($search !== '', fn ($q) => $q->where('visited_url', 'like', "%{$search}%"));
        };

        $total = $build()->distinct()->count('visited_url');
        $rows  = $build()
            ->selectRaw('visited_url, COUNT(*) as visits')
            ->groupBy('visited_url')
            ->orderByDesc('visits')
            ->offset($offset)
            ->limit($this->perPage)
            ->get();

        return [$rows, $total];
    }

    // ---------------
    // Query: referrers grouped by referrer_url, sorted by referral count
    // ---------------
    private function fetchTopReferrers(string $search, int $offset): array
    {
        $build = function () use ($search) {
            return VisitorLog::query()
                ->whereNotNull('referrer_url')
                ->where('referrer_url', '!=', '')
                ->when($search !== '', fn ($q) => $q->where('referrer_url', 'like', "%{$search}%"));
        };

        $total = $build()->distinct()->count('referrer_url');
        $rows  = $build()
            ->selectRaw('referrer_url, COUNT(*) as referrals')
            ->groupBy('referrer_url')
            ->orderByDesc('referrals')
            ->offset($offset)
            ->limit($this->perPage)
            ->get();

        return [$rows, $total];
    }
}
