<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Pivot-style model for the class_teacher_assignments table: which teacher
 * is the official class (homeroom) teacher of which class. Each class has
 * at most one row here (school_class_id is unique).
 */
class ClassTeacherAssignment extends Model
{
    protected $fillable = ['teacher_id', 'school_class_id'];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class);
    }
}
