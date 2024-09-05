<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgentProfit extends Model
{
    use HasFactory;

    protected $fillable = [

        'agent_id',
        'profit',
        'month',
    ];
}
