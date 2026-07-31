@extends('layouts.app')

@section('title', 'Analytics Dashboard')

@section('content')
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
        <div>
            <h1 class="page-title">Analytics Dashboard</h1>
            <p class="page-subtitle mb-0">Real-time complaint monitoring and insights</p>
        </div>
        <div class="total-card">
            <div class="label">TOTAL COMPLAINTS</div>
            <div class="value">{{ $total }}</div>
        </div>
    </div>

    <div class="mb-4">
        <div class="section-heading">Top Complaints by Region</div>
        <div class="section-sub">Distribution of complaints across different regions</div>
        <div class="row g-3">
            @foreach($regions as $region)
                <div class="col-md-6 col-lg-4">
                    <div class="stat-card">
                        <div class="d-flex align-items-start gap-2">
                            <div class="icon-box" style="background:#7c3aed22;color:#a78bfa;">
                                <i class="bi bi-buildings"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between">
                                    <strong>{{ $region['name'] }}</strong>
                                    <span class="text-muted">{{ $region['count'] }}</span>
                                </div>
                                <div class="text-muted small">{{ $region['count'] }} {{ \Illuminate\Support\Str::plural('Complaint', $region['count']) }}</div>
                                <div class="progress-thin">
                                    <span style="width: {{ $region['percent'] }}%; background:#8b5cf6;"></span>
                                </div>
                                <div class="text-muted small mt-1">{{ $region['percent'] }}%</div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="section-heading">Priority Distribution</div>
            <div class="section-sub">Breakdown of complaints by urgency level</div>
            @include('partials._priority-distribution', ['priorities' => $priorities])
        </div>

        <div class="col-lg-6">
            <div class="section-heading">Status Overview</div>
            <div class="section-sub">Current status of all complaints in the system</div>
            <div class="row g-3">
                @foreach($statuses as $status)
                    @php
                        $colors = [
                            'new' => '#3b82f6',
                            'in_progress' => '#f59e0b',
                            'resolved' => '#22c55e',
                            'closed' => '#9ca3af',
                        ];
                        $icons = [
                            'new' => 'bi-plus-lg',
                            'in_progress' => 'bi-arrow-repeat',
                            'resolved' => 'bi-check-lg',
                            'closed' => 'bi-shield-check',
                        ];
                        $bar = $colors[$status['key']] ?? '#6b7280';
                    @endphp
                    <div class="col-sm-6">
                        <div class="stat-card">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div class="icon-box" style="background:{{ $bar }}22;color:{{ $bar }};">
                                    <i class="bi {{ $icons[$status['key']] ?? 'bi-circle' }}"></i>
                                </div>
                                <strong style="font-size:1.4rem;">{{ $status['count'] }}</strong>
                            </div>
                            <div class="fw-semibold">{{ $status['label'] }}</div>
                            <div class="progress-thin">
                                <span style="width: {{ $status['percent'] }}%; background:{{ $bar }};"></span>
                            </div>
                            <div class="text-muted small mt-1">{{ $status['percent'] }}% of total</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
