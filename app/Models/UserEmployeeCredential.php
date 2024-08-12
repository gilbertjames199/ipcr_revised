<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserEmployeeCredential extends Model
{
    use HasFactory;
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
    public function getTargNotifQueryAttribute()
    {
        return Ipcr_Semestral::query()
            ->where(function ($query) {
                $query->where('status', '0')
                    ->where('immediate_id', $this->empl_code);
            })
            ->orWhere(function ($query) {
                $query->where('status', '1')
                    ->where('next_higher', $this->empl_code);
            })
            ->count();
    }
}
