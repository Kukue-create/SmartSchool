@extends('layouts.app')
@section('title', 'Student Dashboard')
@section('content')
<h3>Welcome back, {{ $student->user->full_name }}!</h3>
<div class="row g-4 mt-1">
    <div class="col-md-4">
        <div class="card card-ssz h-100">
            <div class="card-header">My Class</div>
            <div class="card-body">
                <p class="mb-1"><strong>Level:</strong> {{ $student->level }}</p>
                <p class="mb-1"><strong>Class:</strong> {{ $student->schoolClass->name }}</p>
                <p class="mb-0"><strong>Subjects:</strong></p>
                @foreach($student->subjects as $subject)
                    <span class="pill-ssz">{{ $subject->name }}</span>
                @endforeach
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-ssz h-100">
            <div class="card-header">Quick Links</div>
            <div class="card-body d-grid gap-2">
                <a href="{{ route('results.mine') }}" class="btn btn-ssz-green">My Results</a>
                <a href="{{ route('fees.mine') }}" class="btn btn-ssz-green">My Fees</a>
                <a href="{{ route('attendance.mine') }}" class="btn btn-ssz-green">My Attendance</a>
                <a href="{{ route('library.index') }}" class="btn btn-ssz-green">Library</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-ssz h-100">
            <div class="card-header">Latest Notices</div>
            <div class="card-body">
                @forelse($notices as $notice)
                    <p class="mb-2"><strong>{{ $notice->title }}</strong><br><small class="text-muted">{{ $notice->created_at->format('d M Y') }}</small></p>
                @empty
                    <p class="text-muted mb-0">No notices yet.</p>
                @endforelse
                <a href="{{ route('notices.index') }}" class="small">View all &raquo;</a>
            </div>
        </div>
    </div>
</div>
@endsection
