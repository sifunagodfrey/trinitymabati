<?php

namespace App\Http\Controllers\Manage\Ecommerce;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\ReportExportTrait;
use App\Models\Manage\Ecommerce\Order;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportsController extends Controller
{
    use ReportExportTrait;
    // ---------------
    // Ecommerce overview with monthly sales summary, filterable by date range
    // ---------------
    public function index(): View|StreamedResponse
    {
        $startDate = request('start_date');
        $endDate   = request('end_date');

        $totalOrders = Order::count();

        $totalRevenue = Order::where('status', 'completed')
            ->when($startDate, fn ($q) => $q->whereDate('created_at', '>=', $startDate))
            ->when($endDate,   fn ($q) => $q->whereDate('created_at', '<=', $endDate))
            ->sum('total');

        $totalCustomers = DB::table('su_users')
            ->join('su_user_roles', 'su_user_roles.user_id', '=', 'su_users.id')
            ->join('su_roles', 'su_user_roles.role_id', '=', 'su_roles.id')
            ->where('su_roles.slug', 'customer')
            ->count();

        $totalRefunds = Order::where('status', 'refunded')->sum('total');

        // ---------------
        // Monthly summary - last 12 months, filtered by date range if provided
        // ---------------
        $sql    = "SELECT DATE_FORMAT(o.created_at, '%Y-%m') AS month,
                          COUNT(*) AS orders,
                          SUM(CASE WHEN o.status = 'completed' THEN o.total ELSE 0 END) AS revenue,
                          SUM(CASE WHEN o.status = 'refunded'  THEN o.total ELSE 0 END) AS refunds
                   FROM su_orders o
                   WHERE 1";
        $params = [];

        if ($startDate) {
            $sql     .= ' AND o.created_at >= ?';
            $params[] = $startDate . ' 00:00:00';
        }
        if ($endDate) {
            $sql     .= ' AND o.created_at <= ?';
            $params[] = $endDate . ' 23:59:59';
        }

        $sql         .= ' GROUP BY month ORDER BY month DESC LIMIT 12';
        $monthlyStats = DB::select($sql, $params);

        // ---------------
        // CSV/PDF export - triggered by ?export=csv or ?export=pdf
        // ---------------
        if (request('export') === 'csv') {
            return $this->exportCsv($monthlyStats, $startDate, $endDate);
        } elseif (request('export') === 'pdf') {
            $lines = [
                'Ecommerce Report',
                'Generated: ' . now()->format('Y-m-d H:i:s'),
                '',
                'Monthly Sales Summary',
            ];

            foreach ($monthlyStats as $row) {
                $month = \Carbon\Carbon::createFromFormat('Y-m', $row->month)->format('F Y');
                $lines[] = sprintf(
                    'Month: %s | Orders: %s | Revenue (KES): %s | Refunds (KES): %s',
                    $month,
                    number_format((int) $row->orders),
                    number_format((float) $row->revenue, 2),
                    number_format((float) $row->refunds, 2)
                );
            }

            return $this->exportPdf('ecommerce-report-' . now()->format('Ymd_His') . '.pdf', $lines);
        }

        return view('manage.ecommerce.reports.index', compact(
            'totalOrders', 'totalRevenue', 'totalCustomers', 'totalRefunds',
            'monthlyStats', 'startDate', 'endDate'
        ));
    }

    // ---------------
    // Stream monthly stats as a CSV download
    // ---------------
    private function exportCsv(array $rows, ?string $startDate, ?string $endDate): StreamedResponse
    {
        $filename = 'ecommerce-report-' . now()->format('Y-m-d') . '.csv';

        return response()->streamDownload(function () use ($rows) {
            $handle = fopen('php://output', 'w');

            // ---------------
            // CSV header row
            // ---------------
            fputcsv($handle, ['Month', 'Orders', 'Revenue (KES)', 'Refunds (KES)']);

            foreach ($rows as $row) {
                fputcsv($handle, [
                    $row->month,
                    $row->orders,
                    number_format((float) $row->revenue, 2, '.', ''),
                    number_format((float) $row->refunds,  2, '.', ''),
                ]);
            }

            fclose($handle);
        }, $filename, [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

}
