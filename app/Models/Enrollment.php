<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;

    protected $fillable = [
        'applicant_full_name', 'contact_email', 'contact_phone', 'level_applied_for', 'results_file_path',
        'status', 'reviewed_by_school_admin_id', 'notes',
    ];
}
