<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DivisionOutput extends Model
{
    use HasFactory;
    protected $connection = "mysql";
    protected $table='division_outputs';
    protected $guarded = [];

    public function division()
    {
        return $this->belongsTo(Division::class, 'division_id');
    }

    public function majorFinalOutput()
    {
        return $this->belongsTo(MajorFinalOutput::class, 'idmfo');
    }
}
