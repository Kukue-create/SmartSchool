@extends('layouts.app')
@section('title', 'My Attendance')
@section('content')
<h3>My Attendance</h3>
<table class="table table-ssz table-bordered bg-white">
    <thead><tr><th>Date</th><th>Status</th></tr></thead>
    <tbody>
    @forelse($records as $r)
        <tr><td>{{ $r->date->format('d M Y') }}</td><td>{{ ucfirst($r->status) }}</td></tr>
    @empty
        <tr><td colspan="2" class="text-center text-muted">No attendance recorded yet.</td></tr>
    @endforelse
    </tbody>
</table>
@endsection
