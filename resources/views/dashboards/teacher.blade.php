@extends('layouts.app')
@section('title', 'Teacher Dashboard')
@section('content')
<h3>Welcome back, {{ $teacher->user->full_name }}!</h3>
<div class="row g-4 mt-1">
    <div class="col-md-4">
        <div class="card card-ssz h-100">
            <div class="card-header">My Classes</div>
            <div class="card-body">
                @foreach($teacher->classes as $class)
                    <span class="pill-ssz">{{ $class->level }} - {{ $class->name }}</span>
                @endforeach
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-ssz h-100">
            <div class="card-header">Subjects I Teach</div>
            <div class="card-body">
                @foreach($teacher->subjects as $subject)
                    <span class="pill-ssz">{{ $subject->name }}</span>
                @endforeach
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-ssz h-100">
            <div class="card-header">Quick Links</div>
            <div class="card-body d-grid gap-2">
                <a href="{{ route('results.manage') }}" class="btn btn-ssz-green">Upload Marks</a>
                <a href="{{ route('attendance.manage') }}" class="btn btn-ssz-green">Mark Attendance</a>
                <a href="{{ route('library.index') }}" class="btn btn-ssz-green">Library Resources</a>
            </div>
        </div>
    </div>
</div>

<div class="card card-ssz mt-4">
    <div class="card-header">Latest Notices</div>
    <div class="card-body">
        @forelse($notices as $notice)
            <p class="mb-2"><strong>{{ $notice->title }}</strong> &mdash; {{ $notice->body }} <br><small class="text-muted">{{ $notice->created_at->format('d M Y') }}</small></p>
        @empty
            <p class="text-muted mb-0">No notices yet.</p>
        @endforelse
    </div>
</div>
@endsection
