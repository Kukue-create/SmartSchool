<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibraryBook extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'author', 'isbn', 'total_copies', 'available_copies'];

    public function borrowings()
    {
        return $this->hasMany(BookBorrowing::class);
    }
}
