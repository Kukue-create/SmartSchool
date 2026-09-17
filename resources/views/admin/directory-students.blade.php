@extends('layouts.app')
@section('title', 'All Students')
@section('content')
<h3>All Students <span class="badge bg-secondary">View only</span></h3>
<div class="table-responsive">
<table class="table table-ssz table-bordered bg-white">
    <thead><tr><th>Name</th><th>Email</th><th>Level</th><th>Class</th><th>Gender</th><th>Subjects</th></tr></thead>
    <tbody>
    @foreach($students as $student)
        <tr>
            <td>{{ $student->user->full_name }}</td>
            <td>{{ $student->user->email }}</td>
            <td>{{ $student->level }}</td>
            <td>{{ $student->schoolClass->name }}</td>
            <td>{{ $student->user->gender }}</td>
            <td>@foreach($student->subjects as $s)<span class="pill-ssz">{{ $s->name }}</span>@endforeach</td>
        </tr>
    @endforeach
    </tbody>
</table>
</div>
@endsection
