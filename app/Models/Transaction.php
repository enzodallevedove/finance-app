<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'value', 'description', 'date'];

    public function paymentOption(): BelongsTo
    {
        return $this->belongsTo(PaymentOption::class);
    }
}
