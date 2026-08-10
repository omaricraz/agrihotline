@extends('layouts.app')

@section('title', 'Complaints Dashboard')

@section('content')
    <h1 class="page-title mb-3">Complaints Dashboard</h1>

    <div class="panel">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
            <div class="panel-title mb-0">All Complaints</div>
            <div class="d-flex flex-wrap gap-2">
                @if(auth()->user()->canViewReports())
                    <a href="{{ route('complaints.report.pdf', request()->only(['start_date', 'end_date'])) }}" class="btn btn-pdf">
                        <i class="bi bi-download"></i> Daily PDF Report
                    </a>
                    <a href="{{ route('complaints.report.excel', request()->only(['start_date', 'end_date', 'q'])) }}" class="btn btn-excel">
                        <i class="bi bi-download"></i> Export to Excel
                    </a>
                @endif
                <a href="{{ route('complaints.import') }}" class="btn btn-import">
                    <i class="bi bi-upload"></i> Import Excel
                </a>
                <a href="{{ route('complaints.create') }}" class="btn btn-new">New Complaint</a>
            </div>
        </div>

        <form method="GET" action="{{ route('complaints.index') }}" class="filter-row mb-4">
            <div class="row g-2 align-items-end">
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text" style="background:var(--input-bg);border-color:var(--input-border);color:var(--text-muted);">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Search by name or phone...">
                    </div>
                </div>
                <div class="col-md-2">
                    <input type="date" name="start_date" value="{{ request('start_date') }}" class="form-control" placeholder="dd/mm/yyyy">
                </div>
                <div class="col-md-2">
                    <input type="date" name="end_date" value="{{ request('end_date') }}" class="form-control" placeholder="dd/mm/yyyy">
                </div>
                <div class="col-md-3 d-flex align-items-center gap-3 justify-content-md-end">
                    <a href="{{ route('complaints.index') }}" class="clear-link">Clear</a>
                    <button type="submit" class="btn btn-search">Search</button>
                </div>
            </div>
        </form>

        @if($complaints->isEmpty())
            <p class="text-muted mb-0">No complaints found.</p>
        @else
            <div class="row g-3">
                @foreach($complaints as $complaint)
                    <div class="col-md-6 col-lg-4">
                        @include('partials._complaint-card', ['complaint' => $complaint])
                    </div>
                @endforeach
            </div>
            <div class="mt-4">
                {{ $complaints->links() }}
            </div>
        @endif
    </div>
@endsection
