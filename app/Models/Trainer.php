<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trainer extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'phone',
        'status',
        'image',
    ];
}

// $table->string('code');
// $table->string('name');
// $table->string('phone');
// $table->string('status');
// $table->string('image');
