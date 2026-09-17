<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->foreignId('subject_id')->constrained()->cascadeOnDelete();
            $table->foreignId('teacher_id')->constrained()->cascadeOnDelete();
            $table->string('term');            // e.g. Term 1 2026
            $table->decimal('mark', 5, 2);      // raw mark out of total
            $table->decimal('total', 5, 2)->default(100);
            $table->decimal('percentage', 5, 2);
            $table->string('grade', 5);
            $table->boolean('published')->default(false);
            $table->timestamps();
            $table->unique(['student_id', 'subject_id', 'term']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('results');
    }
};
