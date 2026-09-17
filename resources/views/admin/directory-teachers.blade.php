@extends('layouts.app')
@section('title', 'All Teachers')
@section('content')
<h3>All Teachers <span class="badge bg-secondary">View only</span></h3>
<div class="table-responsive">
<table class="table table-ssz table-bordered bg-white">
    <thead><tr><th>Name</th><th>Email</th><th>Gender</th><th>Classes</th><th>Subjects</th></tr></thead>
    <tbody>
    @foreach($teachers as $teacher)
        <tr>
            <td>{{ $teacher->user->full_name }}</td>
            <td>{{ $teacher->user->email }}</td>
            <td>{{ $teacher->user->gender }}</td>
            <td>@foreach($teacher->classes as $c)<span class="pill-ssz">{{ $c->level }} {{ $c->name }}</span>@endforeach</td>
            <td>@foreach($teacher->subjects as $s)<span class="pill-ssz">{{ $s->name }}</span>@endforeach</td>
        </tr>
    @endforeach
    </tbody>
</table>
</div>
@endsection
