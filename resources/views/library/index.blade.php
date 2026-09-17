@extends('layouts.app')
@section('title', 'Library')
@section('content')
<h3>Library</h3>
<div class="row g-4">
    <div class="col-md-6">
        <div class="card card-ssz h-100">
            <div class="card-header">Physical Books</div>
            <div class="card-body">
                <table class="table table-sm">
                    <thead><tr><th>Title</th><th>Author</th><th>Available</th><th></th></tr></thead>
                    <tbody>
                    @foreach($books as $book)
                        <tr>
                            <td>{{ $book->title }}</td>
                            <td>{{ $book->author }}</td>
                            <td>{{ $book->available_copies }}/{{ $book->total_copies }}</td>
                            <td>
                                @auth
                                @if(auth()->user()->isStudent() && $book->available_copies > 0)
                                    <form method="POST" action="{{ route('library.borrow',$book) }}">
                                        @csrf
                                        <button class="btn btn-sm btn-ssz-green">Borrow</button>
                                    </form>
                                @endif
                                @endauth
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                @auth
                @if(auth()->user()->isSchoolAdmin())
                <hr>
                <form method="POST" action="{{ route('library.books.store') }}" class="row g-2">
                    @csrf
                    <div class="col-6"><input type="text" name="title" class="form-control" placeholder="Title" required></div>
                    <div class="col-6"><input type="text" name="author" class="form-control" placeholder="Author"></div>
                    <div class="col-6"><input type="text" name="isbn" class="form-control" placeholder="ISBN"></div>
                    <div class="col-6"><input type="number" name="total_copies" class="form-control" placeholder="Copies" min="1" required></div>
                    <div class="col-12"><button class="btn btn-ssz-primary w-100">Add Book</button></div>
                </form>
                @endif
                @endauth
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card card-ssz h-100">
            <div class="card-header">Digital Resources (Past Papers &amp; Notes)</div>
            <div class="card-body">
                @forelse($resources as $r)
                    <p class="mb-2"><a href="{{ asset('storage/'.$r->file_path) }}" target="_blank">{{ $r->title }}</a>
                        <span class="pill-ssz">{{ $r->subject->name }}</span>
                        <span class="text-muted small">by {{ $r->teacher->user->full_name }}</span>
                    </p>
                @empty
                    <p class="text-muted">No resources uploaded yet.</p>
                @endforelse

                @auth
                @if(auth()->user()->isTeacher())
                <hr>
                <form method="POST" action="{{ route('library.resources.store') }}" enctype="multipart/form-data" class="row g-2">
                    @csrf
                    <div class="col-6">
                        <select name="subject_id" class="form-select" required>
                            @foreach(auth()->user()->teacher->subjects as $s)
                                <option value="{{ $s->id }}">{{ $s->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6">
                        <select name="type" class="form-select" required>
                            <option value="past_paper">Past Paper</option>
                            <option value="question_paper">Question Paper</option>
                            <option value="revision_notes">Revision Notes</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div class="col-12"><input type="text" name="title" class="form-control" placeholder="Title" required></div>
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
