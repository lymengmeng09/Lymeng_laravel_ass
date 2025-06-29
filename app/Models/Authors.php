<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Authors extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'bio', 'nationality'];

    // Relationship: An author has many books
    public function books()
    {
        return $this->hasMany(Book::class, 'authorId');
    }
}
