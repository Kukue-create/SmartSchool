<?php

namespace App\Http\Controllers;

use App\Models\FeePayment;
use App\Models\FeeStructure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeeController extends Controller
{
    /** Student: see fee balance and upload proof of payment. */
    public function mine()
    {
        $student = Auth::user()->student;
        $structure = FeeStructure::where('level', $student->level)->latest()->first();
        $payments = $student->feePayments()->latest()->get();
        $verifiedTotal = $payments->where('status', 'verified')->sum('amount');
        $balance = $structure ? max(0, $structure->amount_required - $verifiedTotal) : null;

        return view('fees.mine', compact('structure', 'payments', 'verifiedTotal', 'balance'));
    }

    public function pay(Request $request)
    {
        $student = Auth::user()->student;
        $validated = $request->validate([
            'fee_structure_id' => ['required', 'exists:fee_structures,id'],
            'amount' => ['required', 'numeric', 'min:1'],
            'proof' => ['nullable', 'file', 'max:5120'],
        ]);

        $path = $request->hasFile('proof') ? $request->file('proof')->store('payment_proofs', 'public') : null;

        FeePayment::create([
            'student_id' => $student->id,
            'fee_structure_id' => $validated['fee_structure_id'],
            'amount' => $validated['amount'],
            'proof_path' => $path,
            'status' => 'pending',
        ]);

        return back()->with('status', 'Payment submitted and is pending verification by a School Administrator.');
    }

    /** School Admin: set fee structures per level/term and verify payments. */
    public function manage()
    {
        $structures = FeeStructure::latest()->get();
        $pendingPayments = FeePayment::where('status', 'pending')->with('student.user')->latest()->get();

        return view('fees.manage', compact('structures', 'pendingPayments'));
    }

    public function storeStructure(Request $request)
    {
        $validated = $request->validate([
            'level' => ['required', 'string', 'in:'.implode(',', config('school.levels'))],
            'term' => ['required', 'string', 'max:50'],
            'amount_required' => ['required', 'numeric', 'min:0'],
        ]);

        $schoolAdmin = Auth::user()->schoolAdmin;

        FeeStructure::updateOrCreate(
            ['level' => $validated['level'], 'term' => $validated['term']],
            ['amount_required' => $validated['amount_required'], 'set_by_school_admin_id' => $schoolAdmin->id]
        );

        return back()->with('status', 'Fee structure saved.');
    }

    public function verifyPayment(Request $request, FeePayment $payment)
    {
        $request->validate(['decision' => ['required', 'in:verified,rejected']]);

        $payment->update([
            'status' => $request->input('decision'),
            'verified_by_school_admin_id' => Auth::user()->schoolAdmin->id,
            'verified_at' => now(),
        ]);

        return back()->with('status', 'Payment updated.');
    }
}
