<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'school_class_id', 'level', 'date_of_birth'];

    protected $casts = ['date_of_birth' => 'date'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class);
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'student_subject');
    }

    public function results()
    {
        return $this->hasMany(Result::class);
    }

    public function feePayments()
    {
        return $this->hasMany(FeePayment::class);
    }

    public function attendance()
    {
        return $this->hasMany(Attendance::class);
    }

    public function borrowings()
    {
        return $this->hasMany(BookBorrowing::class);
    }
}
