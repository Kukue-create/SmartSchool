<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Which class(es) a teacher is the official class (homeroom) teacher of.
    // This is separate from teacher_class (the classes a teacher teaches a
    // subject in) - a teacher only marks attendance for classes listed here.
    // A class may have at most one class teacher, so school_class_id is
    // unique on its own (not just the pair), and a teacher may hold at most
    // 2 rows here (enforced in TeacherRegistrationController).
    public function up(): void
    {
        Schema::create('class_teacher_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained()->cascadeOnDelete();
            $table->foreignId('school_class_id')->unique()->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('class_teacher_assignments');
    }
};
