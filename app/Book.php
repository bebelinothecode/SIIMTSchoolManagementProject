<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $table = "pdf";

    protected $fillable = [
        'title',
        'author',
        'isbn_number',
        'publisher',
        'file_path'
    ];

    // public function comm(): HasMany
    // {
    //     return $this->hasMany(Comment::class);
    // }
    // public function borrow()
    // {
    //     return $this->belongsTo(Student::class);
    // }
}
