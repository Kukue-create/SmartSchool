@extends('layouts.app')
@section('title', 'My Fees')
@section('content')
<h3>My Fees</h3>
@if($structure)
<div class="card card-ssz mb-4">
    <div class="card-body row text-center">
        <div class="col-md-4"><h5>Required</h5><p class="fs-4">${{ number_format($structure->amount_required,2) }}</p></div>
        <div class="col-md-4"><h5>Paid (verified)</h5><p class="fs-4">${{ number_format($verifiedTotal,2) }}</p></div>
        <div class="col-md-4"><h5>Balance</h5><p class="fs-4">${{ number_format($balance,2) }}</p></div>
    </div>
</div>
<div class="card card-ssz mb-4">
    <div class="card-header">Submit a Payment</div>
    <div class="card-body">
        <form method="POST" action="{{ route('fees.pay') }}" enctype="multipart/form-data" class="row g-3">
            @csrf
            <input type="hidden" name="fee_structure_id" value="{{ $structure->id }}">
            <div class="col-md-4">
                <label class="form-label">Amount</label>
                <input type="number" step="0.01" name="amount" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Proof of payment (optional)</label>
                <input type="file" name="proof" class="form-control">
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button class="btn btn-ssz-primary w-100">Submit</button>
            </div>
        </form>
    </div>
</div>
@else
<div class="alert alert-info">No fee structure has been set for your level yet.</div>
@endif

<h5>Payment History</h5>
<table class="table table-ssz table-bordered bg-white">
    <thead><tr><th>Date</th><th>Amount</th><th>Status</th></tr></thead>
    <tbody>
    @forelse($payments as $p)
        <tr><td>{{ $p->created_at->format('d M Y') }}</td><td>${{ number_format($p->amount,2) }}</td><td>{{ ucfirst($p->status) }}</td></tr>
    @empty
        <tr><td colspan="3" class="text-center text-muted">No payments yet.</td></tr>
    @endforelse
    </tbody>
</table>
@endsection
