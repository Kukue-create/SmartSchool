@extends('layouts.app')
@section('title', 'System Administrator Dashboard')
@section('content')
<div class="alert alert-warning">You are logged in as the <strong>System Administrator (owner)</strong>. You have full view and edit access to every record in SmartSchool Zimbabwe.</div>
<div class="row g-4">
    <div class="col-md-3"><div class="card card-ssz text-center p-3"><h2>{{ $totalUsers }}</h2><p class="mb-0">Total Users</p></div></div>
    <div class="col-md-3"><div class="card card-ssz text-center p-3"><h2>{{ $totalStudents }}</h2><p class="mb-0">Students</p></div></div>
    <div class="col-md-3"><div class="card card-ssz text-center p-3"><h2>{{ $totalTeachers }}</h2><p class="mb-0">Teachers</p></div></div>
    <div class="col-md-3"><div class="card card-ssz text-center p-3"><h2>{{ $pendingPayments }}</h2><p class="mb-0">Pending Payments</p></div></div>
</div>

<div class="card card-ssz mt-4">
    <div class="card-header">Owner Tools</div>
    <div class="card-body d-grid gap-2 d-md-flex">
        <a href="{{ route('system-admin.users.index') }}" class="btn btn-ssz-primary">View &amp; Edit Any User</a>
        <a href="{{ route('system-admin.results.all') }}" class="btn btn-ssz-green">All Results</a>
        <a href="{{ route('system-admin.notices.index') }}" class="btn btn-ssz-green">Notices</a>
        <a href="{{ route('system-admin.enrollments.index') }}" class="btn btn-ssz-green">Enrollment Applications ({{ $pendingEnrollments }} new)</a>
    </div>
</div>
@endsection
