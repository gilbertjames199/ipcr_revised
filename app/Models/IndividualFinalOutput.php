<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndividualFinalOutput extends Model
{
    use HasFactory;
    protected $connection = "mysql";
    protected $table='individual_final_outputs';
    protected $guarded = [];

    public function divisionOutput()
    {
        return $this->belongsTo(DivisionOutput::class, 'id_div_output');
    }
}
