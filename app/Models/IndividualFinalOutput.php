<?php

namespace App\Models;

use App\Traits\LogsImpersonatedActions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndividualFinalOutput extends Model
{
    use HasFactory, LogsImpersonatedActions;
    protected $connection = "mysql";
    protected $table = 'individual_final_outputs';
    protected $guarded = [];

    public function divisionOutput()
    {
        return $this->belongsTo(DivisionOutput::class, 'idDPCR');
    }

    public function ipcrTarget()
    {
        return $this->hasMany(IPCRTargets::class, 'id', 'individual_final_output_id');
    }

    public function majorFinalOutputs()
    {
        return $this->belongsTo(MajorFinalOutput::class, 'idmfo');
    }

    public function ipcrDailyAccomplishments()
    {
        return $this->hasMany(Daily_Accomplishment::class, 'individual_final_output_id', 'individual_final_output_id');
    }
    public function monthlyRemarks()
    {
        return $this->hasMany(MonthlyRemarks::class, 'target_output_id', 'id');
    }
    public function semestralRemarks()
    {
        return $this->hasMany(SemestralRemarks::class, 'idIPCR', 'id');
    }
}
