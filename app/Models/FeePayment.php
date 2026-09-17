<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeePayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id', 'fee_structure_id', 'amount', 'proof_path',
        'status', 'verified_by_school_admin_id', 'verified_at',
    ];

    protected $casts = ['verified_at' => 'datetime'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function feeStructure()
    {
        return $this->belongsTo(FeeStructure::class);
    }
}
