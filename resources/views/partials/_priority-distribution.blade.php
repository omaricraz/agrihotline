@php
    $colors = [
        'urgent' => ['#ef4444', 'bi-exclamation-triangle-fill'],
        'normal' => ['#f59e0b', 'bi-exclamation-circle-fill'],
        'low' => ['#22c55e', 'bi-check-circle-fill'],
    ];
@endphp

<div class="stat-card priority-distribution">
    <div class="priority-distribution-bar" aria-hidden="true">
        @foreach($priorities as $priority)
            @php
                [$bar] = $colors[$priority['key']] ?? ['#6b7280', 'bi-circle'];
            @endphp
            @if($priority['percent'] > 0)
                <span
                    style="width: {{ $priority['percent'] }}%; background: {{ $bar }};"
                    title="{{ $priority['label'] }}: {{ $priority['percent'] }}%"
                ></span>
            @endif
        @endforeach
    </div>

    <div class="priority-distribution-list">
        @foreach($priorities as $priority)
            @php
                [$bar, $icon] = $colors[$priority['key']] ?? ['#6b7280', 'bi-circle'];
            @endphp
            <div class="priority-distribution-item">
                <div class="d-flex align-items-center gap-3">
                    <div class="icon-box" style="background:{{ $bar }}22;color:{{ $bar }};">
                        <i class="bi {{ $icon }}"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <strong>{{ $priority['label'] }}</strong>
                                <div class="text-muted small">{{ $priority['count'] }} Cases</div>
                            </div>
                            <span class="badge" style="background:{{ $bar }}22;color:{{ $bar }};">{{ $priority['percent'] }}%</span>
                        </div>
                        <div class="progress-thin mb-0">
                            <span style="width: {{ $priority['percent'] }}%; background:{{ $bar }};"></span>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
