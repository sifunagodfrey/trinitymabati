<?php

namespace App\Http\Controllers\Traits;

use Symfony\Component\HttpFoundation\StreamedResponse;

trait ReportExportTrait
{
    // ---------------
    // Stream CSV downloads with headers
    // ---------------
    protected function exportCsv(string $filename, array $headers, array $rows): StreamedResponse
    {
        return response()->streamDownload(function () use ($headers, $rows) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, $headers);

            foreach ($rows as $row) {
                fputcsv($handle, $row);
            }

            fclose($handle);
        }, $filename, [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    // ---------------
    // Stream minimal text-based PDF downloads
    // ---------------
    protected function exportPdf(string $filename, array $lines): StreamedResponse
    {
        return response()->streamDownload(function () use ($lines) {
            echo $this->buildSimplePdf($lines);
        }, $filename, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    // ---------------
    // Build a very simple PDF document with plain text lines
    // ---------------
    private function buildSimplePdf(array $lines): string
    {
        $contentLines = [];

        foreach ($lines as $line) {
            $normalized = str_replace("\t", '    ', (string) $line);
            $rows = explode("\n", wordwrap($normalized, 90, "\n", true));

            foreach ($rows as $row) {
                $contentLines[] = $this->escapePdfString($row);
            }
        }

        $streamBody = "BT\n/F1 10 Tf\n40 760 Td\n";

        foreach ($contentLines as $index => $contentLine) {
            $streamBody .= "({$contentLine}) Tj\n";
            if ($index < count($contentLines) - 1) {
                $streamBody .= "0 -14 Td\n";
            }
        }

        $streamBody .= "ET";

        $objects = [
            1 => "1 0 obj\n<< /Type /Catalog /Pages 2 0 R >>\nendobj\n",
            2 => "2 0 obj\n<< /Type /Pages /Kids [3 0 R] /Count 1 >>\nendobj\n",
            3 => "3 0 obj\n<< /Type /Page /Parent 2 0 R /MediaBox [0 0 612 792] /Contents 4 0 R /Resources << /Font << /F1 5 0 R >> >> >>\nendobj\n",
            4 => "4 0 obj\n<< /Length " . strlen($streamBody) . " >>\nstream\n" . $streamBody . "\nendstream\nendobj\n",
            5 => "5 0 obj\n<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>\nendobj\n",
        ];

        $pdf = "%PDF-1.4\n";
        $body = '';
        $offsets = [];

        foreach ($objects as $objectId => $objectText) {
            $offsets[$objectId] = strlen($pdf . $body);
            $body .= $objectText;
        }

        $xref = "xref\n0 " . (count($objects) + 1) . "\n";
        $xref .= sprintf("%010d 65535 f \n", 0);

        foreach ($objects as $objectId => $_objectText) {
            $xref .= sprintf("%010d 00000 n \n", $offsets[$objectId]);
        }

        $startxref = strlen($pdf . $body);
        $trailer = "trailer\n<< /Size " . (count($objects) + 1) . " /Root 1 0 R >>\nstartxref\n" . $startxref . "\n%%EOF";

        return $pdf . $body . $xref . $trailer;
    }

    // ---------------
    // Escape text for PDF literal strings
    // ---------------
    private function escapePdfString(string $value): string
    {
        return str_replace(['\\', '(', ')'], ['\\\\', '\\(', '\\)'], $value);
    }
}
