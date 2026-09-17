@extends('layouts.app')
@section('title', 'My Results')
@section('content')
<h3>My Results</h3>
<div class="table-responsive">
<table class="table table-ssz table-bordered bg-white">
    <thead><tr><th>Term</th><th>Subject</th><th>Mark</th><th>%</th><th>Grade</th></tr></thead>
    <tbody>
    @forelse($results as $r)
        <tr>
            <td>{{ $r->term }}</td>
            <td>{{ $r->subject->name }}</td>
            <td>{{ $r->mark }} / {{ $r->total }}</td>
            <td>{{ $r->percentage }}%</td>
            <td><strong>{{ $r->grade }}</strong></td>
        </tr>
    @empty
        <tr><td colspan="5" class="text-center text-muted">No published results yet.</td></tr>
    @endforelse
    </tbody>
</table>
</div>
@endsection
