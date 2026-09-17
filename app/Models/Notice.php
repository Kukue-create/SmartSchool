<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    use HasFactory;

    protected $fillable = ['school_admin_id', 'title', 'body'];

    public function schoolAdmin()
    {
        return $this->belongsTo(SchoolAdmin::class);
    }
}
