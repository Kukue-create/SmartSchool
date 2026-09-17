@extends('layouts.app')
@section('title', 'School Admin Dashboard')
@section('content')
<h3>Welcome, {{ auth()->user()->full_name }}!</h3>
<p class="text-muted">You can view every student and teacher record but cannot edit them. Use the tools below to manage school-wide content.</p>
<div class="row g-4 mt-1">
    <div class="col-md-3">
        <div class="card card-ssz h-100">
            <div class="card-header">Directories</div>
            <div class="card-body d-grid gap-2">
                <a href="{{ route('directory.students') }}" class="btn btn-ssz-green">All Students</a>
                <a href="{{ route('directory.teachers') }}" class="btn btn-ssz-green">All Teachers</a>
                <a href="{{ route('directory.school-admins') }}" class="btn btn-ssz-green">All School Admins</a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-ssz h-100">
            <div class="card-header">Finance</div>
            <div class="card-body d-grid gap-2">
                <a href="{{ route('fees.manage') }}" class="btn btn-ssz-green">Fees &amp; Payments</a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-ssz h-100">
            <div class="card-header">School Content</div>
            <div class="card-body d-grid gap-2">
                <a href="{{ route('notices.index') }}" class="btn btn-ssz-green">Notices</a>
                <a href="{{ route('timetables.index') }}" class="btn btn-ssz-green">Timetables</a>
                <a href="{{ route('library.index') }}" class="btn btn-ssz-green">Library</a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-ssz h-100">
            <div class="card-header">Admissions &amp; Results</div>
            <div class="card-body d-grid gap-2">
                <a href="{{ route('enrollment.index') }}" class="btn btn-ssz-green">Enrollment Applications</a>
                <a href="{{ route('results.all') }}" class="btn btn-ssz-green">View All Results</a>
            </div>
        </div>
    </div>
</div>
@endsection
