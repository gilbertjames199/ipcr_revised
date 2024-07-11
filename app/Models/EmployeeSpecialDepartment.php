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

    public function Office()
    {
        return $this->belongsTo(Office::class, 'department_code', 'department_code');
    }

    public function PGDH()
    {
        return $this->hasOne(UserEmployees::class, 'empl_id', 'pgdh_cats');
    }
}
