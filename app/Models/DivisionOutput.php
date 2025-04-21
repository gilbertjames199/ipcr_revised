<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DivisionOutput extends Model
{
    use HasFactory;
    protected $connection = "mysql";
    protected $table = 'division_outputs';
    protected $guarded = [];

    public function division()
    {
        return $this->belongsTo(Division::class, 'division_id');
    }
    public function programAndProject()
    {
        return $this->belongsTo(ProgramAndProject::class, 'idpaps');
    }
    public function majorFinalOutput()
    {
        return $this->belongsTo(MajorFinalOutput::class, 'idmfo');
    }
    public function monthlyRemarks()
    {
        return $this->hasMany(MonthlyRemarks::class, 'target_output_id', 'id');
    }
}
