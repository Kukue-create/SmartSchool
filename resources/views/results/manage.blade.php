@extends('layouts.app')
@section('title', 'Upload Marks')
@section('content')
<h3>Upload Marks</h3>
<p class="text-muted">You may only upload marks for students in a class you teach, for a subject you teach that they also take.</p>

<div class="card card-ssz mb-4">
    <div class="card-header">Enter a Mark</div>
    <div class="card-body">
        <form method="POST" action="{{ route('results.store') }}" class="row g-3">
            @csrf
            <div class="col-md-4">
                <label class="form-label">Student &amp; Subject</label>
                <select name="combo" class="form-select" id="comboSelect" required>
                    <option value="">-- Select --</option>
                    @foreach($gradableStudents as $row)
                        <option value="{{ $row['student']->id }}|{{ $row['subject']->id }}">
                            {{ $row['student']->user->full_name }} &mdash; {{ $row['subject']->name }}
                        </option>
                    @endforeach
                </select>
                <input type="hidden" name="student_id" id="studentIdInput">
                <input type="hidden" name="subject_id" id="subjectIdInput">
            </div>
            <div class="col-md-2">
                <label class="form-label">Term</label>
                <input type="text" name="term" class="form-control" placeholder="Term 1 2026" required>
            </div>
            <div class="col-md-2">
                <label class="form-label">Mark</label>
                <input type="number" step="0.01" name="mark" class="form-control" required>
            </div>
            <div class="col-md-2">
                <label class="form-label">Out of</label>
                <input type="number" step="0.01" name="total" class="form-control" value="100" required>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="published" value="1" id="pub" checked>
                    <label class="form-check-label" for="pub">Publish</label>
                </div>
            </div>
            <div class="col-12">
                <button class="btn btn-ssz-primary">Save Mark</button>
            </div>
        </form>
    </div>
</div>

<h5>Marks You Have Entered</h5>
<div class="table-responsive">
<table class="table table-ssz table-bordered bg-white">
    <thead><tr><th>Student</th><th>Subject</th><th>Term</th><th>Mark</th><th>%</th><th>Grade</th><th>Published</th></tr></thead>
    <tbody>
    @forelse($myResults as $r)
        <tr>
            <td>{{ $r->student->user->full_name }}</td>
            <td>{{ $r->subject->name }}</td>
            <td>{{ $r->term }}</td>
            <td>{{ $r->mark }}/{{ $r->total }}</td>
            <td>{{ $r->percentage }}%</td>
            <td>{{ $r->grade }}</td>
            <td>{{ $r->published ? 'Yes' : 'No' }}</td>
        </tr>
    @empty
        <tr><td colspan="7" class="text-center text-muted">No marks entered yet.</td></tr>
    @endforelse
    </tbody>
</table>
</div>

<script>
const combo = document.getElementById('comboSelect');
combo.addEventListener('change', function () {
    const [studentId, subjectId] = this.value.split('|');
    document.getElementById('studentIdInput').value = studentId || '';
    document.getElementById('subjectIdInput').value = subjectId || '';
});
</script>
@endsection
