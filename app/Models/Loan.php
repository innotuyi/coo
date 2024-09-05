<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'userID',
        'amount',
        'interest_rate',
        'start_date',
        'end_date',
        'status'

    ];
}
