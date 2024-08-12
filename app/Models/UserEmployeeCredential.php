<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//IMpersontate
//Impersonate
use Lab404\Impersonate\Models\Impersonate;

class UserEmployeeCredential extends Model
{
    use HasFactory, Impersonate;
    protected $connection = "mysql";
    protected $table = 'user_employee_credentials';
    protected $guarded = ['id'];
    public function userEmployee()
    {
        return $this->hasOne(UserEmployees::class, 'empl_id', 'username');
    }
    public function employeeSpecialDepartment()
    {
        return $this->hasOne(EmployeeSpecialDepartment::class, 'employee_code', 'username');
    }
}
