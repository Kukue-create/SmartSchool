@extends('layouts.app')
@section('title', 'All School Admins')
@section('content')
<h3>All School Administrators <span class="badge bg-secondary">View only</span></h3>
<div class="table-responsive">
<table class="table table-ssz table-bordered bg-white">
    <thead><tr><th>Name</th><th>Email</th><th>Gender</th><th>Nationality</th></tr></thead>
    <tbody>
    @foreach($schoolAdmins as $admin)
        <tr>
            <td>{{ $admin->user->full_name }}</td>
            <td>{{ $admin->user->email }}</td>
            <td>{{ $admin->user->gender }}</td>
            <td>{{ $admin->user->nationality }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</div>
@endsection
