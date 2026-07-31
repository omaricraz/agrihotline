@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
    <h1 class="page-title mb-3">Edit User</h1>

    <div class="form-card">
        <div class="panel-title">User Details</div>
        <form method="POST" action="{{ route('users.update', $user) }}">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password">Password <span class="text-muted">(leave blank to keep current)</span></label>
                <input type="password" id="password" name="password" class="form-control">
            </div>
            <div class="mb-4">
                <label for="role">Role</label>
                <select id="role" name="role" class="form-select" required>
                    @foreach(config('complaints.roles') as $key => $label)
                        <option value="{{ $key }}" @selected(old('role', $user->role) === $key)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="d-flex justify-content-end align-items-center gap-3">
                <a href="{{ route('users.index') }}" class="btn-cancel">Cancel</a>
                <button type="submit" class="btn btn-primary-dark">UPDATE USER</button>
            </div>
        </form>
    </div>
@endsection
