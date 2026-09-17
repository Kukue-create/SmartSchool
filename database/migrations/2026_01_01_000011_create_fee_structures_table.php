<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fee_structures', function (Blueprint $table) {
            $table->id();
            $table->string('level');       // fee required per level
            $table->string('term');
            $table->decimal('amount_required', 10, 2);
            $table->foreignId('set_by_school_admin_id')->nullable()->constrained('school_admins')->nullOnDelete();
            $table->timestamps();
            $table->unique(['level', 'term']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fee_structures');
    }
};
