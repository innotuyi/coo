<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expenditure extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'description',
        'amount',
        'date',
        'paid_to',
        'employee_id'
    ];
}
