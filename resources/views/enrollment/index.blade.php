@extends('layouts.app')
@section('title', 'Enrollment Applications')
@section('content')
<h3>Enrollment Applications</h3>
<table class="table table-ssz table-bordered bg-white">
    <thead><tr><th>Applicant</th><th>Email</th><th>Level</th><th>Results</th><th>Status</th><th>Update</th></tr></thead>
    <tbody>
    @foreach($enrollments as $e)
        <tr>
            <td>{{ $e->applicant_full_name }}</td>
            <td>{{ $e->contact_email }}</td>
            <td>{{ $e->level_applied_for }}</td>
            <td>
                @if($e->results_file_path)
                    <a href="{{ asset('storage/'.$e->results_file_path) }}" target="_blank" class="btn btn-sm btn-ssz-green">View</a>
                @else
                    <span class="text-muted">-</span>
                @endif
            </td>
            <td>{{ ucfirst(str_replace('_',' ',$e->status)) }}</td>
            <td>
                <form method="POST" action="{{ route('enrollment.update',$e) }}" class="d-flex gap-1">
                    @csrf @method('PATCH')
                    <select name="status" class="form-select form-select-sm">
                        @foreach(['submitted','under_review','approved','rejected'] as $s)
                            <option value="{{ $s }}" {{ $e->status==$s?'selected':'' }}>{{ ucfirst(str_replace('_',' ',$s)) }}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-sm btn-ssz-accent">Save</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
{{ $enrollments->links() }}
@endsection
