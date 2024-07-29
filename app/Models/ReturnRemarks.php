<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnRemarks extends Model
{
    use HasFactory;
    protected $connection = "mysql";
    protected $table = 'return_remarks';
    protected $guarded = [];

    public function ipcrSemestral()
    {
        return $this->belongsTo(Ipcr_Semestral::class, 'id', 'ipcr_semestral_id',);
    }
    //called in ReturnRemarksController
    public function ipcrSemestral2()
    {
        return $this->belongsTo(Ipcr_Semestral::class, 'ipcr_semestral_id', 'id',);
    }
    //MOnthly
    public function ipcrMonthlyAccomplishment()
    {
        return $this->belongsTo(MonthlyAccomplishment::class, 'ipcr_monthly_accomplishment_id', 'id',);
    }
    public function userEmployee()
    {
        return $this->belongsTo(UserEmployees::class, 'employee_code', 'empl_id');
    }
}
