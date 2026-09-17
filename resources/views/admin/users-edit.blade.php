@extends('layouts.app')
@section('title', 'Edit User')
@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card card-ssz">
            <div class="card-header">Edit {{ $targetUser->full_name }} ({{ ucfirst(str_replace('_',' ',$targetUser->role)) }})</div>
            <div class="card-body p-4">
                <p class="text-muted">Changes here update this person's record for everyone in the system immediately.</p>
                <form method="POST" action="{{ route('system-admin.users.update', $targetUser) }}">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Full Name</label>
                        <input type="text" name="full_name" class="form-control" value="{{ $targetUser->full_name }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ $targetUser->email }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Gender</label>
                        <select name="gender" class="form-select" required>
                            @foreach($genders as $g)
                                <option value="{{ $g }}" {{ $targetUser->gender==$g?'selected':'' }}>{{ $g }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nationality</label>
                        <input type="text" name="nationality" class="form-control" value="{{ $targetUser->nationality }}" required>
                    </div>
                    <button class="btn btn-ssz-primary w-100 py-2">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
