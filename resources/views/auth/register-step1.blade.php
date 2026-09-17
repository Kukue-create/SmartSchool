@extends('layouts.app')
@section('title', 'Register')
@section('content')
@php
    $heading = match($role) {
        'teacher' => 'Teacher registration',
        'school_admin' => 'School Administrator registration',
        default => 'Create your SmartSchool Zimbabwe account',
    };
@endphp
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card card-ssz">
            <div class="card-header">{{ $heading }}</div>
            <div class="card-body p-4">
                <form method="POST" action="{{ url()->current() }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Full Name</label>
                        <input type="text" name="full_name" class="form-control" value="{{ old('full_name') }}" required minlength="3" placeholder="e.g. Bethel Jengwa">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Username</label>
                        <input type="text" name="username" class="form-control" value="{{ old('username') }}" required minlength="4" placeholder="Choose a username">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Password</label>
                            <input type="password" name="password" class="form-control" required minlength="8">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control" required minlength="8">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-ssz-primary w-100 py-2 mt-2">Continue</button>
                </form>
                <p class="text-center mt-3 mb-0">Already registered? <a href="{{ route('login') }}">Login here</a></p>
            </div>
        </div>
    </div>
</div>
@endsection
