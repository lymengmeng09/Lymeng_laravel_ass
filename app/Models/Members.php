<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Members extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'membership_date',
    ];
     protected $casts = [
        'membership_date' => 'date',
    ];
}
