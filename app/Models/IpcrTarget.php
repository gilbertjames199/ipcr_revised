<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IpcrTarget extends Model
{
    use HasFactory;
    protected $connection = "mysql";
    protected $table = 'ipcr_targets';
    protected $guarded = ['id'];

    // public function semestralRemarks()
    // {
    //     return $this->hasOne(SemestralRemarks::class, 'idIPCR', 'ipcr_code');
    // }

    public function individualOutput()
    {
        return $this->belongsTo(IndividualFinalOutput::class, 'individual_final_output_id', 'id');
    }

    public function ipcr_Semestral()
    {
        return $this->belongsTo(Ipcr_Semestral::class, 'ipcr_semestral_id', 'id');
    }

    // public function ipcrDailyAccomplishments()
    // {
    //     return $this->hasMany(Daily_Accomplishment::class, 'ipcr_code', 'idIPCR');
    // }

    public function userEmployees()
    {
        return $this->belongsTo(UserEmployees::class, 'employee_code', 'empl_id');
    }

    public function userEmployee()
    {
        return $this->belongsTo(UserEmployees::class, 'employee_code', 'empl_id');
    }
}
