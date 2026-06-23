<?php

namespace App\Models;

use App\Traits\LogsImpersonatedActions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserEmployees extends Model
{
    use HasFactory, LogsImpersonatedActions;
    protected $connection = "mysql";
    protected $table = 'user_employees';
    protected $guarded = ['id'];
    protected $with = ['Division'];


    public function Division()
    {
        return $this->hasOne(Division::class, 'division_code', 'division_code');
    }
    public function DesignatedDivisionHead()
    {
        return $this->hasOne(DesignatedDivisionHead::class, 'empl_id', 'empl_id');
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

    public function ipcr_semestral()
    {
        return $this->hasMany(Ipcr_Semestral::class, 'employee_code', 'empl_id');
    }

    public function manySemestral()
    {
        return $this->hasMany(Ipcr_Semestral::class, 'employee_code', 'empl_id')->latest();
    }
    public function employeeSpecialDepartment()
    {
        return $this->hasOne(EmployeeSpecialDepartment::class, 'employee_code', 'empl_id')->latest();
    }
    public function semestralRatingRemarks()
    {
        return $this->hasMany(summary_rating_remarks::class, 'employee_code', 'empl_id')->latest();
    }
    public function probationaryTemporaryEmployees()
    {
        return $this->hasMany(ProbationaryTemporaryEmployees::class, 'employee_code', 'empl_id');
    }
    public function CoachingReport()
    {
        return $this->hasMany(CoachingReport::class, 'employee_cats_id', 'empl_id');
    }

    public function forReview(){
        return $this->hasMany(Ipcr_Semestral::class, 'immediate_id', 'empl_id');
    }

    public function forApprove(){
        return $this->hasMany(Ipcr_Semestral::class, 'next_higher', 'empl_id');
    }
}
