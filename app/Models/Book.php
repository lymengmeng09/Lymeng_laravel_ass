<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $table = "books";

    protected $fillable = [
    'title',
    'authorId',
    'year',            // If you really use this column
    'publicationYear', // or this one, pick one
    'isbn',
    'genre',
    'availableCopies',
];


    // Relationship: A book belongs to one author
    public function author()
    {
        return $this->belongsTo(Authors::class, 'authorId');
    }
}
