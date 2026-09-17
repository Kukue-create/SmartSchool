<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamTimetable extends Model
{
    use HasFactory;

    protected $fillable = ['school_admin_id', 'title', 'level', 'file_path'];

    public function schoolAdmin()
    {
        return $this->belongsTo(SchoolAdmin::class);
    }
}
