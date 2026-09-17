<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'is_class_teacher'];

    protected $casts = ['is_class_teacher' => 'boolean'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function classes()
    {
        return $this->belongsToMany(SchoolClass::class, 'teacher_class', 'teacher_id', 'school_class_id');
    }

    /**
     * The class(es) this teacher is the official class (homeroom) teacher
     * of - at most 2, and each class has at most one class teacher. Only
     * these classes may have their attendance marked by this teacher, and
     * only if is_class_teacher is true.
     */
    public function classTeacherOf()
    {
        return $this->belongsToMany(SchoolClass::class, 'class_teacher_assignments', 'teacher_id', 'school_class_id');
    }

    public function canMarkAttendanceForClass(int $schoolClassId): bool
    {
        return $this->is_class_teacher
            && $this->classTeacherOf()->where('school_classes.id', $schoolClassId)->exists();
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'teacher_subject');
    }

    public function results()
    {
        return $this->hasMany(Result::class);
    }

    /**
     * Whether this teacher is allowed to upload a mark for the given student in
     * the given subject: the student must share BOTH the teacher's class and
     * the teacher's subject. This is the core rule from the project brief.
     */
    public function canGradeStudentInSubject(Student $student, Subject $subject): bool
    {
        $teachesClass = $this->classes()->where('school_classes.id', $student->school_class_id)->exists();
        $teachesSubject = $this->subjects()->where('subjects.id', $subject->id)->exists();
        $studentTakesSubject = $student->subjects()->where('subjects.id', $subject->id)->exists();

        return $teachesClass && $teachesSubject && $studentTakesSubject;
    }
}
