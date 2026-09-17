<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeStructure extends Model
{
    use HasFactory;

    protected $fillable = ['level', 'term', 'amount_required', 'set_by_school_admin_id'];

    public function payments()
    {
        return $this->hasMany(FeePayment::class);
    }
}
