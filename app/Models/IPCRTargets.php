<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IPCRTargets extends Model
{
    use HasFactory;
    protected $connection = "mysql";
    protected $table = 'i_p_c_r_targets';
    protected $guarded = ['id'];

    public function semestralRemarks()
    {
        return $this->hasOne(SemestralRemarks::class, 'idIPCR', 'ipcr_code');
    }

    public function individualOutput()
    {
        return $this->belongsTo(IndividualFinalOutput::class, 'ipcr_code', 'ipcr_code');
    }

    public function ipcr_Semestral()
    {
        return $this->belongsTo(Ipcr_Semestral::class, 'ipcr_semester_id', 'id');
    }

    public function ipcrDailyAccomplishments()
    {
        return $this->hasMany(Daily_Accomplishment::class, 'ipcr_code', 'idIPCR');
    }
}
