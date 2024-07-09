<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IPCRTargets extends Model
{
    use HasFactory;
    protected $connection = "mysql";
    protected $table='i_p_c_r_targets';
    protected $guarded = ['id'];

    public function semestralRemarks()
    {
        return $this->hasMany(SemestralRemarks::class, 'idIPCR', 'ipcr_code');
    }

    public function individualOutput()
    {
        return $this->hasMany(IndividualFinalOutput::class, 'ipcr_code', 'ipcr_code');
    }

    
}
