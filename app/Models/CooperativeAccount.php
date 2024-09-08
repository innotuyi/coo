<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CooperativeAccount extends Model
{
    use HasFactory;

     // Specify the fields that can be mass-assigned
     protected $fillable = [
        'type',
        'account_number',
        'account_holder_name',
        'balance',
        'interest_rate',
        'opening_date',
        'punishimentDate',
    ];
}
