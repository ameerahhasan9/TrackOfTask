<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $table = 'tasks';

    protected $fillable = ['title', 'is_completed'];

    protected $casts = [
        'title' => 'string',
        'is_completed' => 'boolean',
    ];


}
