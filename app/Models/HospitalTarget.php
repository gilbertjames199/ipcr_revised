<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HospitalTarget extends Model
{
    use HasFactory;
    protected $connection = "mysql";
    protected $table = 'hospital_targets';
    protected $guarded = ['id'];

    //IPCR
    public function ipcr()
    {
        return $this->belongsTo(IndividualFinalOutput::class, 'idIPCR');
    }

    //DPCR
    public function dpcr()
    {
        return $this->belongsTo(DivisionOutput::class, 'idDPCR');
    }

    //Hospital IPCR
    public function hIPCR()
    {
        return $this->belongsTo(hospital_individual_output::class, 'idHIPCR');
    }
    //Hospital SPCR
    public function hSPCR()
    {
        return $this->belongsTo(hospital_section_output::class, 'idHSPCR');
    }

    //Hospital DPCR
    public function hDPCR()
    {
        return $this->belongsTo(hospital_division_output::class, 'idHDPCR');
    }

    //Hospital Output
    public function hpcr()
    {
        return $this->belongsTo(hospital_output::class, 'idHPCR');
    }

    public function monthlyTargets()
    {
        return $this->hasMany(MonthlyTarget::class, 'hospital_target_id');
    }

    public function ipcr_Semestral()
    {
        return $this->belongsTo(Ipcr_Semestral::class, 'ipcr_semestral_id', 'id');
    }
}
