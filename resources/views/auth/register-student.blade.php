@extends('layouts.app')
@section('title', 'Student Registration')
@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card card-ssz">
            <div class="card-header">Student Registration</div>
            <div class="card-body p-4">
                <h4>Welcome, {{ $fullName }}! 🎓</h4>
                <p>Please register here to complete your student account.</p>
                <p>Here is your email: <span class="email-preview">{{ $previewEmail }}</span></p>

                <form method="POST" action="{{ route('register.student.store') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Level</label>
                            <select name="level" id="levelSelect" class="form-select" required>
                                <option value="">-- Select level --</option>
                                @foreach($levels as $level)
                                    <option value="{{ $level }}" {{ old('level')==$level ? 'selected' : '' }}>{{ $level }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Class</label>
                            <select name="school_class" id="classSelect" class="form-select" required>
                                <option value="">-- Select level first --</option>
                            </select>
                        </div>
                    </div>

                    <label class="form-label fw-semibold">Subjects (select all that apply, no limit)</label>
                    <div class="row mb-3">
                        @foreach($subjects as $subject)
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="subjects[]" value="{{ $subject }}" id="subj{{ $loop->index }}"
                                        {{ in_array($subject, old('subjects', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="subj{{ $loop->index }}">{{ $subject }}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold">Gender</label>
                            <select name="gender" class="form-select" required>
                                <option value="">-- Select --</option>
                                @foreach($genders as $g)
                                    <option value="{{ $g }}">{{ $g }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold">Date of Birth</label>
                            <input type="date" name="date_of_birth" class="form-control" required>
                        </div>
                        <div class="col-md-4 mb-3">
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
const classesByLevel = @json($classesByLevel);
const levelSelect = document.getElementById('levelSelect');
const classSelect = document.getElementById('classSelect');

function populateClasses() {
    const level = levelSelect.value;
    classSelect.innerHTML = '';
    if (!level || !classesByLevel[level]) {
        classSelect.innerHTML = '<option value="">-- Select level first --</option>';
        return;
    }
    classSelect.innerHTML = '<option value="">-- Select class --</option>';
    classesByLevel[level].forEach(function (c) {
        const opt = document.createElement('option');
        opt.value = c;
        opt.textContent = c;
        classSelect.appendChild(opt);
    });
}
levelSelect.addEventListener('change', populateClasses);
populateClasses();
</script>
@endsection
