@extends('layouts.app')
@section('title', 'Timetables')
@section('content')
<h3>Timetables</h3>

<div class="row g-4">
    <div class="col-md-6">
        <div class="card card-ssz h-100">
            <div class="card-header">Class Timetables</div>
            <div class="card-body">
                @forelse($classTimetables as $t)
                    <p class="mb-2"><a href="{{ asset('storage/'.$t->file_path) }}" target="_blank">{{ $t->title }}</a> &mdash; {{ $t->schoolClass->level }} {{ $t->schoolClass->name }}</p>
                @empty
                    <p class="text-muted">No class timetables uploaded yet.</p>
                @endforelse

                @auth
                @if(auth()->user()->isTeacher())
                <hr>
                <form method="POST" action="{{ route('timetables.class.store') }}" enctype="multipart/form-data" class="row g-2">
                    @csrf
                    <div class="col-12"><input type="text" name="title" class="form-control" placeholder="Title" required></div>
                    <div class="col-12">
                        <select name="school_class_id" class="form-select" required>
                            @foreach(auth()->user()->teacher->classes as $c)
                                <option value="{{ $c->id }}">{{ $c->level }} {{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12"><input type="file" name="file" class="form-control" required></div>
                    <div class="col-12"><button class="btn btn-ssz-primary w-100">Upload</button></div>
                </form>
                @endif
                @endauth
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card card-ssz h-100">
            <div class="card-header">Exam Timetables</div>
            <div class="card-body">
                @forelse($examTimetables as $t)
                    <p class="mb-2"><a href="{{ asset('storage/'.$t->file_path) }}" target="_blank">{{ $t->title }}</a> {{ $t->level ? '— '.$t->level : '' }}</p>
                @empty
                    <p class="text-muted">No exam timetables uploaded yet.</p>
                @endforelse

                @auth
                @if(auth()->user()->isSchoolAdmin())
                <hr>
                <form method="POST" action="{{ route('timetables.exam.store') }}" enctype="multipart/form-data" class="row g-2">
                    @csrf
                    <div class="col-12"><input type="text" name="title" class="form-control" placeholder="Title" required></div>
                    <div class="col-12"><input type="text" name="level" class="form-control" placeholder="Level (optional)"></div>
                    <div class="col-12"><input type="file" name="file" class="form-control" required></div>
                    <div class="col-12"><button class="btn btn-ssz-primary w-100">Upload</button></div>
                </form>
                @endif
                @endauth
            </div>
        </div>
    </div>
</div>
@endsection
