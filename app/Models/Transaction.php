<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'invoice_id',
        'amount',
        'currency',
        'transaction_date',
        'type',
        'reference_code',
        'details',
    ];

    protected $casts = [];
}
