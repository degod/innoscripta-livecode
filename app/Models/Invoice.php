<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'invoice_number',
        'total_amount',
        'currency',
        'invoice_date',
        'reduction_type',
        'customer_name',
    ];
}
