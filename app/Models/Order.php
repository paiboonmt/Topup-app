<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'ref_code',
        'num_bill',
        'fname',
        'discount',
        'price',
        'vat7',
        'vat3',
        'payment',
        'sta_date',
        'exp_date',
        'comment',
        'user',
    ];
}
