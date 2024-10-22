<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CardRecord extends Model
{
    use HasFactory;
    protected $fillable = [
        'card',
        'price',
        'discount',
        'payment',
        'date_expiry',
        'comment',
        'total',
        'status',
        'method',
        'user',
        'trainer',
    ];
}
