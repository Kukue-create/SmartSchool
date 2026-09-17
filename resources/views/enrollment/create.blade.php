@extends('layouts.app')
@section('title', 'Online Application')
@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card card-ssz">
            <div class="card-header">Apply to Seke 1 High School</div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('enrollment.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Applicant Full Name</label>
                        <input type="text" name="applicant_full_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Contact Email</label>
                        <input type="email" name="contact_email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Contact Phone</label>
                        <input type="text" name="contact_phone" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Level Applying For</label>
                        <select name="level_applied_for" class="form-select" required>
                            @foreach($levels as $level)<option value="{{ $level }}">{{ $level }}</option>@endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Upload your results</label>
                        <input type="file" name="results" class="form-control" accept=".pdf,.jpg,.jpeg,.png" required>
                        <div class="form-text">PDF, JPG or PNG, up to 10MB - e.g. your most recent report or results slip.</div>
                    </div>
                    <button class="btn btn-ssz-primary w-100 py-2">Submit Application</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
