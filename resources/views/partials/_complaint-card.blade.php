<a href="{{ route('complaints.show', $complaint) }}" class="complaint-card">
    <div class="d-flex justify-content-between align-items-start gap-2">
        <div class="name">{{ $complaint->complainant_name }}</div>
        <span class="priority-badge priority-{{ $complaint->priority }}">{{ $complaint->priorityLabel() }}</span>
    </div>
    <div class="meta">{{ $complaint->phone }}</div>
    <div class="meta">{{ $complaint->location }}, {{ $complaint->region }}</div>
    <div class="meta">Created By: {{ $complaint->creator->name ?? '—' }}</div>
    <div class="footer">
        <span>{{ $complaint->created_at->format('d M Y, g:i A') }}</span>
        <span class="status-badge status-{{ $complaint->status }}">{{ $complaint->statusLabel() }}</span>
    </div>
</a>
