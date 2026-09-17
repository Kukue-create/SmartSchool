@extends('layouts.app')
@section('title', 'System Administrator Login')
@section('content')
<div class="row justify-content-center">
    <div class="col-lg-5">
        <div class="card card-ssz">
            <div class="card-header">System Administrator (Owner) Login</div>
            <div class="card-body p-4">
                <p class="text-muted">This login is reserved for the system owner and grants full view and edit access to every record in SmartSchool Zimbabwe.</p>
                <form method="POST" action="{{ route('system-admin.login.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">System Admin Password</label>
                        <input type="password" name="system_admin_password" class="form-control" required autofocus>
                    </div>
                    <button type="submit" class="btn btn-ssz-primary w-100 py-2">Login as System Admin</button>
                </form>
                <p class="text-center mt-3 mb-0"><a href="{{ route('login') }}">Back to regular login</a></p>
            </div>
        </div>
    </div>
</div>
@endsection
