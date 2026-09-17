@extends('layouts.app')
@section('title', 'Notices')
@section('content')
<h3>School Notices</h3>

@auth
@if(auth()->user()->isSchoolAdmin())
<div class="card card-ssz mb-4">
    <div class="card-header">Publish a Notice</div>
    <div class="card-body">
        <form method="POST" action="{{ route('notices.store') }}">
            @csrf
            <div class="mb-2"><input type="text" name="title" class="form-control" placeholder="Title" required></div>
            <div class="mb-2"><textarea name="body" class="form-control" rows="3" placeholder="Notice content" required></textarea></div>
            <button class="btn btn-ssz-primary">Publish to Everyone</button>
        </form>
    </div>
</div>
@endif
@endauth

@forelse($notices as $notice)
    <div class="card card-ssz mb-3">
        <div class="card-body">
            <h5>{{ $notice->title }}</h5>
            <p>{{ $notice->body }}</p>
            <small class="text-muted">By {{ $notice->schoolAdmin->user->full_name }} on {{ $notice->created_at->format('d M Y') }}</small>
        </div>
    </div>
@empty
    <p class="text-muted">No notices yet.</p>
@endforelse
{{ $notices->links() }}
@endsection
