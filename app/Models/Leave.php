<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_name',
        'department_name',
        'designation_name',
        'employee_id',
        'from_date',
        'to_date',
        'total_days',
        'leave_type_id',
        'description'
    ];
}
