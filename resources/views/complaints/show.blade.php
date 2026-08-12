@extends('layouts.app')

@section('title', 'Complaint #'.$complaint->id)

@section('content')
    <div class="complaint-detail-header">
        <div>
            <a href="{{ route('complaints.index') }}" class="complaint-back-link">
                <i class="bi bi-arrow-left"></i> Back to complaints
            </a>
            <h1 class="page-title mb-1">Complaint #{{ $complaint->id }}</h1>
            <div class="complaint-detail-badges">
                <span class="priority-badge priority-{{ $complaint->priority }}">{{ $complaint->priorityLabel() }}</span>
                <span class="status-badge status-{{ $complaint->status }}">{{ $complaint->statusLabel() }}</span>
            </div>
        </div>
    </div>

    <div class="complaint-detail-grid">
        <div class="form-card complaint-detail-form">
            <h2 class="section-heading">Details</h2>
            <p class="section-sub">Update complaint information below.</p>

            <form method="POST" action="{{ route('complaints.update', $complaint) }}">
                @csrf
                @method('PATCH')

                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="complainant_name">Complainant Name</label>
                        <input type="text" id="complainant_name" name="complainant_name"
                               value="{{ old('complainant_name', $complaint->complainant_name) }}"
                               class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="phone">Complainant Phone</label>
                        <input type="text" id="phone" name="phone"
                               value="{{ old('phone', $complaint->phone) }}"
                               class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="location">Location</label>
                        <input type="text" id="location" name="location"
                               value="{{ old('location', $complaint->location) }}"
                               class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="region">Region</label>
                        <select id="region" name="region" class="form-select" required>
                            @foreach(config('complaints.regions') as $region)
                                <option value="{{ $region }}" @selected(old('region', $complaint->region) === $region)>{{ $region }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="village">Village</label>
                        <input type="text" id="village" name="village"
                               value="{{ old('village', $complaint->village) }}"
                               class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label for="department">Department</label>
                        <select id="department" name="department" class="form-select" required>
                            @foreach(config('complaints.departments') as $department)
                                <option value="{{ $department }}" @selected(old('department', $complaint->department) === $department)>{{ $department }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12">
                        <label for="description">Complaint Description</label>
                        <textarea id="description" name="description" rows="4" class="form-control" required>{{ old('description', $complaint->description) }}</textarea>
                    </div>
                    <div class="col-md-6">
                        <label for="priority">Priority</label>
                        <select id="priority" name="priority" class="form-select" required>
                            @foreach(config('complaints.priorities') as $key => $label)
                                <option value="{{ $key }}" @selected(old('priority', $complaint->priority) === $key)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    @if(auth()->user()->canUpdateStatus())
                        <div class="col-md-6">
                            <label for="status">Status</label>
                            <select id="status" name="status" class="form-select" required>
                                @foreach(config('complaints.statuses') as $key => $label)
                                    <option value="{{ $key }}" @selected(old('status', $complaint->status) === $key)>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-primary-dark">Save Changes</button>
                </div>
            </form>
        </div>

        <div class="complaint-detail-sidebar">
            <div class="form-card complaint-meta-card">
                <h2 class="section-heading">Record Info</h2>
                <dl class="complaint-meta-list">
                    <div>
                        <dt>Created By</dt>
                        <dd>{{ $complaint->creator->name ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt>Created</dt>
                        <dd>{{ $complaint->created_at->format('d M Y, g:i A') }}</dd>
                    </div>
                    <div>
                        <dt>Last Updated</dt>
                        <dd>{{ $complaint->updated_at->format('d M Y, g:i A') }}</dd>
                    </div>
                </dl>
            </div>

            <div class="form-card complaint-notes-card">
                <h2 class="section-heading">Notes</h2>
                <p class="section-sub">Add responses and follow-up notes.</p>

                <div class="complaint-notes-list">
                    @forelse($complaint->notes as $note)
                        <div class="complaint-note">
                            <p class="complaint-note-body">{{ $note->body }}</p>
                            <div class="complaint-note-meta">
                                <span>{{ $note->user->name ?? '—' }}</span>
                                <span>{{ $note->created_at->format('d M Y, g:i A') }}</span>
                            </div>
                        </div>
                    @empty
                        <p class="complaint-notes-empty">No notes yet.</p>
                    @endforelse
                </div>

                <form method="POST" action="{{ route('complaints.notes.store', $complaint) }}" class="complaint-note-form">
                    @csrf
                    <label for="body">Add Note</label>
                    <textarea id="body" name="body" rows="3" class="form-control" placeholder="Write a response or follow-up..." required>{{ old('body') }}</textarea>
                    @error('body')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                    <div class="d-flex justify-content-end mt-2">
                        <button type="submit" class="btn btn-primary-dark btn-sm">Add Note</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
