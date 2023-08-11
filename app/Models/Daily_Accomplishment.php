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
        return $this -> hasOne(IPCRTargets::class, 'id', 'idIPCR');
    }

    public function IPCR(){
        return $this -> hasOne(IndividualFinalOutput::class, 'ipcr_code', 'idIPCR');
    }

}
