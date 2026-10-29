<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'company_name',
        'email',
        'phone',
        'address',
        'category',
        'payment_terms',
        'status',
        'rating',
    ];

    protected $casts = [
        'rating' => 'decimal:1',
    ];
}
