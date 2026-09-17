@extends('layouts.app')
@section('title', 'Mark Attendance')
@section('content')
<h3>Mark Attendance</h3>
<div class="card card-ssz">
    <div class="card-body">
        <form method="POST" action="{{ route('attendance.store') }}" class="row g-3">
            @csrf
            <div class="col-md-5">
                <label class="form-label">Student</label>
                <select name="student_id" class="form-select" required>
                    <option value="">-- Select --</option>
                    @foreach($teacher->classTeacherOf as $class)
                        <optgroup label="{{ $class->level }} {{ $class->name }}">
                            @foreach($class->students as $student)
                                <option value="{{ $student->id }}">{{ $student->user->full_name }}</option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Date</label>
                <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select" required>
                    <option value="present">Present</option>
                    <option value="absent">Absent</option>
                    <option value="late">Late</option>
                </select>
            </div>
            <div class="col-md-1 d-flex align-items-end">
                <button class="btn btn-ssz-primary w-100">Save</button>
            </div>
        </form>
    </div>
</div>
@endsection
