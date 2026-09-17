@extends('layouts.app')
@section('title', 'School Admin Registration')
@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card card-ssz">
            <div class="card-header">School Administrator Registration</div>
            <div class="card-body p-4">
                <h4>Welcome, {{ $fullName }}! 🗂️</h4>
                <p>Please register here to complete your School Administrator account.</p>
                <p>Here is your email: <span class="email-preview">{{ $previewEmail }}</span></p>
                <div class="alert alert-warning">As School Administrator, you can view every student's and teacher's information but cannot edit any of it.</div>

                <form method="POST" action="{{ route('register.school-admin.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Gender</label>
                        <select name="gender" class="form-select" required>
                            <option value="">-- Select --</option>
                            @foreach($genders as $g)
                                <option value="{{ $g }}">{{ $g }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nationality</label>
                        <input type="text" name="nationality" class="form-control" value="Zimbabwean" required>
                    </div>
                    <button type="submit" class="btn btn-ssz-primary w-100 py-2 mt-2">Register</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
