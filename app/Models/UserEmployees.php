<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserEmployees extends Model
{
    use HasFactory;
    protected $connection = "mysql";
    protected $table = 'user_employees';
    protected $guarded = ['id'];
    protected $with = ['Division'];


    public function Division()
    {
        return $this->hasOne(Division::class, 'division_code', 'division_code');
    }
    public function Office()
    {
        return $this->belongsTo(Office::class, 'department_code', 'department_code');
    }
    public function credential()
    {
        return $this->hasOne(UserEmployeeCredential::class, 'username', 'empl_id');
    }
    public function latestSemestral()
    {
        return $this->hasOne(Ipcr_Semestral::class, 'employee_code', 'empl_id')->latest();
    }
    public function manySemestral()
    {
        return $this->hasMany(Ipcr_Semestral::class, 'employee_code', 'empl_id')->latest();
    }
    public function employeeSpecialDepartment()
    {
        return $this->hasOne(EmployeeSpecialDepartment::class, 'employee_code', 'empl_id')->latest();
    }
}
