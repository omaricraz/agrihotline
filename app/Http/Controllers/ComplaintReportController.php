<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ComplaintReportController extends Controller
{
    public function pdf(Request $request)
    {
        [$start, $end, $label] = $this->resolveDates($request);

        $complaints = Complaint::query()
            ->dateRange($start, $end)
            ->orderBy('id')
            ->get();

        $pdf = Pdf::loadView('reports.daily-pdf', [
            'complaints' => $complaints,
            'reportLabel' => $label,
        ])->setPaper('a4', 'landscape');

        return $pdf->download('daily-complaints-report.pdf');
    }

    public function excel(Request $request): StreamedResponse
    {
        [$start, $end] = $this->resolveDates($request);

        $complaints = Complaint::query()
            ->dateRange($start, $end)
            ->orderBy('id')
            ->get();

        $filename = 'complaints-export-'.now()->format('Y-m-d').'.csv';

        return response()->streamDownload(function () use ($complaints) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['ID', 'Complainant', 'Phone', 'Region', 'Department', 'Status', 'Priority', 'Date']);

            foreach ($complaints as $complaint) {
                fputcsv($handle, [
                    $complaint->id,
                    $complaint->complainant_name,
                    $complaint->phone,
                    $complaint->region,
                    $complaint->department,
                    $complaint->status,
                    $complaint->priority,
                    $complaint->created_at->format('d M Y'),
                ]);
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }

    /**
     * @return array{0: string, 1: string, 2: string}
     */
    private function resolveDates(Request $request): array
    {
        $start = $request->query('start_date');
        $end = $request->query('end_date');

        if (! filled($start) && ! filled($end)) {
            $today = now()->toDateString();

            return [$today, $today, now()->format('F d, Y')];
        }

        $labelStart = filled($start) ? \Carbon\Carbon::parse($start)->format('F d, Y') : '…';
        $labelEnd = filled($end) ? \Carbon\Carbon::parse($end)->format('F d, Y') : '…';
        $label = ($start === $end || (! filled($end)))
            ? (filled($start) ? \Carbon\Carbon::parse($start)->format('F d, Y') : $labelEnd)
            : "{$labelStart} – {$labelEnd}";

        return [$start, $end, $label];
    }
}
