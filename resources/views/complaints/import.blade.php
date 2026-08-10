@extends('layouts.app')

@section('title', 'Import Complaints')

@section('content')
    <h1 class="page-title mb-3">Import Complaints</h1>

    <div class="form-card">
        <p class="text-muted mb-4">
            Upload an Excel file (.xlsx, .xls) or CSV with complaint data. Download the template below to see the required columns and valid values.
        </p>

        <div class="mb-4">
            <a href="{{ route('complaints.import.template') }}" class="btn btn-excel">
                <i class="bi bi-download"></i> Download Template
            </a>
        </div>

        <div class="mb-4">
            <h2 class="h6 mb-2">Valid values</h2>
            <ul class="text-muted small mb-0">
                <li><strong>Region:</strong> {{ implode(', ', config('complaints.regions')) }}</li>
                <li><strong>Department:</strong> {{ implode(', ', config('complaints.departments')) }}</li>
                <li><strong>Priority:</strong> {{ implode(', ', array_keys(config('complaints.priorities'))) }}</li>
                <li><strong>Status:</strong> {{ implode(', ', array_keys(config('complaints.statuses'))) }} (optional, defaults to new)</li>
            </ul>
        </div>

        @if(session('import_errors'))
            <div class="alert alert-warning">
                <strong>Some rows could not be imported:</strong>
                <ul class="mb-0 ps-3 mt-2">
                    @foreach(session('import_errors') as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('complaints.import.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label for="file">Excel / CSV File</label>
                <input type="file" id="file" name="file" class="form-control" accept=".xlsx,.xls,.csv" required>
                <div class="form-text">Maximum file size: 5 MB</div>
            </div>

            <div class="d-flex justify-content-end align-items-center gap-3">
                <a href="{{ route('complaints.index') }}" class="btn-cancel">Cancel</a>
                <button type="submit" class="btn btn-primary-dark">IMPORT COMPLAINTS</button>
            </div>
        </form>
    </div>
@endsection
