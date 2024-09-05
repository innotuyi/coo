<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Share extends Model
{
    use HasFactory;

    protected $fillable = [
        'userID',
        'amount',
        'joining_date',
        'amount_increase',
        'interest_rate',
        'total_share'

    ];
}
