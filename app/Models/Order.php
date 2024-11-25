<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'code',
        'num_bill',
        'fname',
        'discount',
        'vat7',
        'vat3',
        'net',
        'total',
        'payment',
        'sta_date',
        'exp_date',
        'comment',
        'user',
    ];
}
