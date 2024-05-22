<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeSpecialDepartment extends Model
{
    use HasFactory;
    protected $connection = "mysql";
    protected $table = 'employee_special_departments';
    protected $guarded = [];
}
