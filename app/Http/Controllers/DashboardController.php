<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $total = Complaint::count();

        $regionCounts = Complaint::query()
            ->select('region', DB::raw('count(*) as total'))
            ->groupBy('region')
            ->pluck('total', 'region');

        $regions = collect(config('complaints.regions'))->map(function (string $region) use ($regionCounts, $total) {
            $count = (int) ($regionCounts[$region] ?? 0);

            return [
                'name' => $region,
                'count' => $count,
                'percent' => $total > 0 ? round(($count / $total) * 100, 1) : 0,
            ];
        })->sortByDesc('count')->values();

        $priorityCounts = Complaint::query()
            ->select('priority', DB::raw('count(*) as total'))
            ->groupBy('priority')
            ->pluck('total', 'priority');

        $priorities = collect(config('complaints.priorities'))->map(function (string $label, string $key) use ($priorityCounts, $total) {
            $count = (int) ($priorityCounts[$key] ?? 0);

            return [
                'key' => $key,
                'label' => $label,
                'count' => $count,
                'percent' => $total > 0 ? round(($count / $total) * 100, 1) : 0,
            ];
        });

        $statusCounts = Complaint::query()
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $statuses = collect(config('complaints.statuses'))->map(function (string $label, string $key) use ($statusCounts, $total) {
            $count = (int) ($statusCounts[$key] ?? 0);

            return [
                'key' => $key,
                'label' => $label,
                'count' => $count,
                'percent' => $total > 0 ? round(($count / $total) * 100, 1) : 0,
            ];
        });

        return view('dashboard.index', compact('total', 'regions', 'priorities', 'statuses'));
    }
}
