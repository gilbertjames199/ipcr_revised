<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ipcr_Semestral extends Model
{
    use HasFactory;
    protected $connection = "mysql";
    protected $table = 'ipcr__semestrals';
    protected $guarded = ['id'];

    public function monthly_accomplishment()
    {
        return $this->hasMany(MonthlyAccomplishment::class, 'ipcr_semestral_id', 'id');
    }

    public function immediate()
    {
        return $this->hasOne(UserEmployees::class, 'empl_id', 'immediate_id');
    }

    public function next_higher()
    {
        return $this->hasOne(UserEmployees::class, 'empl_id', 'next_higher');
    }

    public function next_higher1()
    {
        return $this->hasOne(UserEmployees::class, 'empl_id', 'next_higher');
    }
    public function userEmployee()
    {
        return $this->belongsTo(UserEmployees::class, 'employee_code', 'empl_id');
    }

    public function latestReturnRemark()
    {
        return $this->hasOne(ReturnRemarks::class, 'ipcr_semestral_id', 'id')->latest('created_at');
    }

    public function latestReturnRemarkNextHigher()
    {
        return $this->hasOne(ReturnRemarks::class, 'ipcr_semestral_id', 'id')->latest('created_at');
    }

    public function ipcrTarget()
    {
        return $this->hasMany(IPCRTargets::class, 'ipcr_semester_id', 'id');
    }

    public function Division()
    {
        return $this->hasOne(Division::class, 'division', 'division_code');
    }
    public function Office()
    {
        return $this->belongsTo(Office::class, 'department_code', 'department_code');
    }
    public function monthRate()
    {
        return $this->hasMany(MonthlyAccomplishmentRating::class, 'ipcr_sem_id', 'id');
    }
    public function SemRate()
    {
        return $this->hasMany(SemestralAccomplishmentRating::class, 'ipcr_sem_id', 'id');
    }
}
