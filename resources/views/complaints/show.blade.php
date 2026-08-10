@extends('layouts.app')

@section('title', 'Complaint #'.$complaint->id)

@section('content')
    <h1 class="page-title mb-3">Complaint Details</h1>

    <div class="form-card">
        <div class="mb-3">
            <label>Complainant Name</label>
            <div class="form-control" style="pointer-events:none;">{{ $complaint->complainant_name }}</div>
        </div>
        <div class="mb-3">
            <label>Complainant Phone</label>
            <div class="form-control" style="pointer-events:none;">{{ $complaint->phone }}</div>
        </div>
        <div class="mb-3">
            <label>Location</label>
            <div class="form-control" style="pointer-events:none;">{{ $complaint->location }}</div>
        </div>
        <div class="mb-3">
            <label>Region</label>
            <div class="form-control" style="pointer-events:none;">{{ $complaint->region }}</div>
        </div>
        <div class="mb-3">
            <label>Village</label>
            <div class="form-control" style="pointer-events:none;">{{ $complaint->village ?: '—' }}</div>
        </div>
        <div class="mb-3">
            <label>Department</label>
            <div class="form-control" style="pointer-events:none;">{{ $complaint->department }}</div>
        </div>
        <div class="mb-3">
            <label>Complaint Description</label>
            <div class="form-control" style="min-height:90px;pointer-events:none;">{{ $complaint->description }}</div>
        </div>
        <div class="mb-3">
            <label>Priority</label>
            <div>
                <span class="priority-badge priority-{{ $complaint->priority }}">{{ $complaint->priorityLabel() }}</span>
            </div>
        </div>
        <div class="mb-3">
            <label>Status</label>
            <div>
                <span class="status-badge status-{{ $complaint->status }}">{{ $complaint->statusLabel() }}</span>
            </div>
        </div>
        <div class="mb-3">
            <label>Created By</label>
            <div class="form-control" style="pointer-events:none;">{{ $complaint->creator->name ?? '—' }}</div>
        </div>
        <div class="mb-4">
            <label>Created Date</label>
            <div class="form-control" style="pointer-events:none;">{{ $complaint->created_at->format('d M Y, g:i A') }}</div>
        </div>

        @if(auth()->user()->canUpdateStatus())
            <form method="POST" action="{{ route('complaints.status', $complaint) }}" class="border-top pt-3">
                @csrf
                @method('PATCH')
                <div class="mb-3">
                    <label for="status">Update Status</label>
                    <select id="status" name="status" class="form-select" required>
                        @foreach(config('complaints.statuses') as $key => $label)
                            <option value="{{ $key }}" @selected($complaint->status === $key)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="d-flex justify-content-end gap-3">
                    <a href="{{ route('complaints.index') }}" class="btn-cancel">Back</a>
                    <button type="submit" class="btn btn-primary-dark">Update Status</button>
                </div>
            </form>
        @else
            <div class="d-flex justify-content-end">
                <a href="{{ route('complaints.index') }}" class="btn-cancel">Back</a>
            </div>
        @endif
    </div>
@endsection
