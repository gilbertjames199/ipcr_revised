<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Daily_Accomplishment extends Model
{
    use HasFactory;
    protected $connection = "mysql";
    protected $table='ipcr_daily_accomplishments';
    protected $guarded = [];

    public function IPCRCode(){
        return $this->hasOne(IPCRTargets::class, 'id', 'idIPCR');
    }

    // public function IPCR(){
    //     return $this->hasOne(IndividualFinalOutput::class, 'ipcr_code', 'idIPCR');
    // }

    public function individualFinalOutput(){
        return $this->belongsTo(IndividualFinalOutput::class, 'idIPCR', 'ipcr_code');
    }

    public function monthlyAccomplishment(){
        return $this->belongsTo(MonthlyAccomplishment::class, 'sem_id', 'ipcr_semestral_id');
    }



}
