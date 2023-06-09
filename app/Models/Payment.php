<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'name',
        'email',
        'token',
        'stripe_id',
        'created_at',
        'updated_at'
    ];
}