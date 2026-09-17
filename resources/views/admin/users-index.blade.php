@extends('layouts.app')
@section('title', 'Manage Users')
@section('content')
<h3>All Registered Users</h3>
<div class="mb-3">
    <a href="{{ route('system-admin.users.index') }}" class="btn btn-sm btn-outline-secondary">All</a>
    <a href="{{ route('system-admin.users.index', ['role'=>'student']) }}" class="btn btn-sm btn-outline-secondary">Students</a>
    <a href="{{ route('system-admin.users.index', ['role'=>'teacher']) }}" class="btn btn-sm btn-outline-secondary">Teachers</a>
    <a href="{{ route('system-admin.users.index', ['role'=>'school_admin']) }}" class="btn btn-sm btn-outline-secondary">School Admins</a>
</div>
<div class="table-responsive">
<table class="table table-ssz table-bordered bg-white">
    <thead><tr><th>Name</th><th>Email</th><th>Role</th><th>Gender</th><th>Nationality</th><th>Actions</th></tr></thead>
    <tbody>
    @foreach($users as $user)
        <tr>
            <td>{{ $user->full_name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ ucfirst(str_replace('_',' ',$user->role)) }}</td>
            <td>{{ $user->gender }}</td>
            <td>{{ $user->nationality }}</td>
            <td>
                <a href="{{ route('system-admin.users.edit', $user) }}" class="btn btn-sm btn-ssz-accent">Edit</a>
                <form action="{{ route('system-admin.users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Remove this account permanently?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger">Delete</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
</div>
{{ $users->links() }}
@endsection
