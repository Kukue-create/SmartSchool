@extends('layouts.app')
@section('title', 'Manage Fees')
@section('content')
<h3>Fees Management</h3>
<div class="card card-ssz mb-4">
    <div class="card-header">Set Fee Structure</div>
    <div class="card-body">
        <form method="POST" action="{{ route('fees.structure.store') }}" class="row g-3">
            @csrf
            <div class="col-md-4">
                <label class="form-label">Level</label>
                <select name="level" class="form-select" required>
                    @foreach(config('school.levels') as $level)<option value="{{ $level }}">{{ $level }}</option>@endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Term</label>
                <input type="text" name="term" class="form-control" placeholder="Term 1 2026" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Amount Required</label>
                <input type="number" step="0.01" name="amount_required" class="form-control" required>
            </div>
            <div class="col-md-1 d-flex align-items-end">
                <button class="btn btn-ssz-primary w-100">Save</button>
            </div>
        </form>
    </div>
</div>

<h5>Existing Fee Structures</h5>
<table class="table table-ssz table-bordered bg-white mb-4">
    <thead><tr><th>Level</th><th>Term</th><th>Amount</th></tr></thead>
    <tbody>
    @foreach($structures as $s)
        <tr><td>{{ $s->level }}</td><td>{{ $s->term }}</td><td>${{ number_format($s->amount_required,2) }}</td></tr>
    @endforeach
    </tbody>
</table>

<h5>Pending Payments to Verify</h5>
<table class="table table-ssz table-bordered bg-white">
    <thead><tr><th>Student</th><th>Amount</th><th>Proof</th><th>Action</th></tr></thead>
    <tbody>
    @forelse($pendingPayments as $p)
        <tr>
            <td>{{ $p->student->user->full_name }}</td>
            <td>${{ number_format($p->amount,2) }}</td>
            <td>{{ $p->proof_path ? 'Uploaded' : '—' }}</td>
            <td>
                <form method="POST" action="{{ route('fees.payments.verify',$p) }}" class="d-inline">
                    @csrf
                    <input type="hidden" name="decision" value="verified">
                    <button class="btn btn-sm btn-ssz-green">Verify</button>
                </form>
                <form method="POST" action="{{ route('fees.payments.verify',$p) }}" class="d-inline">
                    @csrf
                    <input type="hidden" name="decision" value="rejected">
                    <button class="btn btn-sm btn-outline-danger">Reject</button>
                </form>
            </td>
        </tr>
    @empty
        <tr><td colspan="4" class="text-center text-muted">No pending payments.</td></tr>
    @endforelse
    </tbody>
</table>
@endsection
