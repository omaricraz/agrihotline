@extends('layouts.app')

@section('title', 'New Complaint')

@section('content')
    <h1 class="page-title mb-3">Complaint Details</h1>

    <div class="form-card">
        <form method="POST" action="{{ route('complaints.store') }}">
            @csrf

            <div class="mb-3">
                <label for="complainant_name">Complainant Name</label>
                <input type="text" id="complainant_name" name="complainant_name" value="{{ old('complainant_name') }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="phone">Complainant Phone</label>
                <input type="text" id="phone" name="phone" value="{{ old('phone') }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="location">Location (e.g., Village, District)</label>
                <input type="text" id="location" name="location" value="{{ old('location') }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="region">Region</label>
                <select id="region" name="region" class="form-select" required>
                    <option value="">Select region</option>
                    @foreach(config('complaints.regions') as $region)
                        <option value="{{ $region }}" @selected(old('region') === $region)>{{ $region }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="village">Village</label>
                <input type="text" id="village" name="village" value="{{ old('village') }}" class="form-control">
            </div>

            <div class="mb-3">
                <label for="department">Department</label>
                <select id="department" name="department" class="form-select" required>
                    <option value="">Select department</option>
                    @foreach(config('complaints.departments') as $department)
                        <option value="{{ $department }}" @selected(old('department') === $department)>{{ $department }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="description">Complaint Description</label>
                <textarea id="description" name="description" rows="4" class="form-control" required>{{ old('description') }}</textarea>
            </div>

            <div class="mb-4">
                <label for="priority">Priority</label>
                <select id="priority" name="priority" class="form-select" required>
                    @foreach(config('complaints.priorities') as $key => $label)
                        <option value="{{ $key }}" @selected(old('priority', 'normal') === $key)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div class="d-flex justify-content-end align-items-center gap-3">
                <a href="{{ route('complaints.index') }}" class="btn-cancel">Cancel</a>
                <button type="submit" class="btn btn-primary-dark">LOG COMPLAINT</button>
            </div>
        </form>
    </div>
@endsection
