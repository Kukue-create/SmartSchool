@extends('layouts.app')
@section('title', 'Teacher Registration')
@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card card-ssz">
            <div class="card-header">Teacher Registration</div>
            <div class="card-body p-4">
                <h4>Welcome, {{ $fullName }}! 🧑‍🏫</h4>
                <p>Please register here to complete your teacher account.</p>
                <p>Here is your email: <span class="email-preview">{{ $previewEmail }}</span></p>

                <form method="POST" action="{{ route('register.teacher.store') }}">
                    @csrf
                    <label class="form-label fw-semibold">Classes you teach (choose up to {{ $maxClasses }})</label>
                    <div class="row mb-3" style="max-height: 260px; overflow-y:auto;">
                        @foreach($allClasses as $class)
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input class-check" type="checkbox" name="classes[]" value="{{ $class }}" id="class{{ $loop->index }}"
                                        {{ in_array($class, old('classes', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="class{{ $loop->index }}">{{ $class }}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <p id="classLimitMsg" class="text-danger small d-none">You can select at most {{ $maxClasses }} classes.</p>

                    <label class="form-label fw-semibold">Subjects you teach</label>
                    <div class="row mb-3">
                        @foreach($subjects as $subject)
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="subjects[]" value="{{ $subject }}" id="tsubj{{ $loop->index }}"
                                        {{ in_array($subject, old('subjects', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="tsubj{{ $loop->index }}">{{ $subject }}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" role="switch" id="isClassTeacher" name="is_class_teacher" value="1" {{ old('is_class_teacher') ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold" for="isClassTeacher">I am a class (homeroom) teacher</label>
                    </div>

                    <div id="classTeacherSection" class="mb-3 d-none">
                        <label class="form-label fw-semibold">Which class(es) are you the class teacher of? (choose up to {{ $maxClassTeacherClasses }})</label>
                        <p class="text-muted small">Only these class(es) will appear on your Attendance page - you may mark attendance only for students in the class(es) you choose here.</p>
                        <div class="row" style="max-height: 220px; overflow-y:auto;">
                            @foreach($allClasses as $class)
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input class-teacher-check" type="checkbox" name="class_teacher_classes[]" value="{{ $class }}" id="ctclass{{ $loop->index }}"
                                            {{ in_array($class, old('class_teacher_classes', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="ctclass{{ $loop->index }}">{{ $class }}</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <p id="classTeacherLimitMsg" class="text-danger small d-none mt-1">You can select at most {{ $maxClassTeacherClasses }} class(es).</p>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Gender</label>
                            <select name="gender" class="form-select" required>
                                <option value="">-- Select --</option>
                                @foreach($genders as $g)
                                    <option value="{{ $g }}">{{ $g }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Nationality</label>
                            <input type="text" name="nationality" class="form-control" value="Zimbabwean" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-ssz-primary w-100 py-2 mt-2">Register</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
const maxClasses = {{ $maxClasses }};
const checks = document.querySelectorAll('.class-check');
const msg = document.getElementById('classLimitMsg');
checks.forEach(function (chk) {
    chk.addEventListener('change', function () {
        const checked = document.querySelectorAll('.class-check:checked');
        if (checked.length > maxClasses) {
            chk.checked = false;
            msg.classList.remove('d-none');
        } else {
            msg.classList.add('d-none');
        }
    });
});

// Class-teacher toggle + its own max-selection limit.
const maxClassTeacherClasses = {{ $maxClassTeacherClasses }};
const isClassTeacherSwitch = document.getElementById('isClassTeacher');
const classTeacherSection = document.getElementById('classTeacherSection');
const classTeacherChecks = document.querySelectorAll('.class-teacher-check');
const classTeacherMsg = document.getElementById('classTeacherLimitMsg');

function syncClassTeacherSection() {
    classTeacherSection.classList.toggle('d-none', !isClassTeacherSwitch.checked);
    if (!isClassTeacherSwitch.checked) {
        classTeacherChecks.forEach(function (chk) { chk.checked = false; });
        classTeacherMsg.classList.add('d-none');
    }
}
isClassTeacherSwitch.addEventListener('change', syncClassTeacherSection);
syncClassTeacherSection();

classTeacherChecks.forEach(function (chk) {
    chk.addEventListener('change', function () {
        const checked = document.querySelectorAll('.class-teacher-check:checked');
        if (checked.length > maxClassTeacherClasses) {
            chk.checked = false;
            classTeacherMsg.classList.remove('d-none');
        } else {
            classTeacherMsg.classList.add('d-none');
        }
    });
});
</script>
@endsection
