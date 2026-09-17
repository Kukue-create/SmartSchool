<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    use HasFactory;

    protected $fillable = ['level', 'name'];

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'teacher_class');
    }

    /** The single official class (homeroom) teacher of this class, if any. */
    public function classTeacher()
    {
        return $this->hasOneThrough(
            Teacher::class,
            ClassTeacherAssignment::class,
            'school_class_id', // FK on class_teacher_assignments
            'id',               // FK on teachers
            'id',               // local key on school_classes
            'teacher_id'        // local key on class_teacher_assignments
        );
    }
}
