@extends('layouts.app')
@section('title', 'All Results')
@section('content')
<h3>All Results <span class="badge bg-secondary">View only</span></h3>
<div class="table-responsive">
<table class="table table-ssz table-bordered bg-white">
    <thead><tr><th>Student</th><th>Subject</th><th>Term</th><th>Mark</th><th>%</th><th>Grade</th><th>Teacher</th></tr></thead>
    <tbody>
    @foreach($results as $r)
        <tr>
            <td>{{ $r->student->user->full_name }}</td>
            <td>{{ $r->subject->name }}</td>
            <td>{{ $r->term }}</td>
            <td>{{ $r->mark }}/{{ $r->total }}</td>
            <td>{{ $r->percentage }}%</td>
            <td>{{ $r->grade }}</td>
            <td>{{ $r->teacher->user->full_name }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</div>
{{ $results->links() }}
@endsection
