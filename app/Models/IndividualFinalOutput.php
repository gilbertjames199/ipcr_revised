<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndividualFinalOutput extends Model
{
    use HasFactory;
    protected $connection = "mysql";
    protected $table = 'individual_final_outputs';
    protected $guarded = [];

    public function divisionOutput()
    {
        return $this->belongsTo(DivisionOutput::class, 'id_div_output');
    }

    public function ipcrTarget()
    {
        return $this->hasMany(IPCRTargets::class, 'ipcr_code', 'ipcr_code');
    }

    public function timeRange()
    {
        return $this->belongsTo(TimeRange::class, 'time_range_code', 'time_code');
    }

    public function timeRanges()
    {
        return $this->hasMany(TimeRange::class, 'time_code', 'time_range_code');
    }

    public function majorFinalOutputs()
    {
        return $this->belongsTo(MajorFinalOutput::class, 'idmfo');
    }
    public function subMfo()
    {
        return $this->belongsTo(SubMfo::class, 'idsubmfo');
    }

    public function ipcrDailyAccomplishments()
    {
        return $this->hasMany(Daily_Accomplishment::class, 'idIPCR', 'ipcr_code');
    }
    public function monthlyRemarks()
    {
        return $this->hasMany(MonthlyRemarks::class, 'idIPCR', 'ipcr_code');
    }
}
