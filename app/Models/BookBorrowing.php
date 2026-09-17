<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookBorrowing extends Model
{
    use HasFactory;

    protected $fillable = ['library_book_id', 'student_id', 'borrowed_on', 'due_on', 'returned_on'];

    protected $casts = ['borrowed_on' => 'date', 'due_on' => 'date', 'returned_on' => 'date'];

    public function book()
    {
        return $this->belongsTo(LibraryBook::class, 'library_book_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
