<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->string('applicant_full_name');
            $table->string('contact_email');
            $table->string('contact_phone')->nullable();
            $table->string('level_applied_for');
            $table->enum('status', ['submitted', 'under_review', 'approved', 'rejected'])->default('submitted');
            $table->foreignId('reviewed_by_school_admin_id')->nullable()->constrained('school_admins')->nullOnDelete();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};
