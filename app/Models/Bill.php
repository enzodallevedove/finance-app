<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'value', 'description', 'paymentoption_id', 'user_id'];
}
