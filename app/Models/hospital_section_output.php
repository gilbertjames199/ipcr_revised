<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class hospital_section_output extends Model
{
    use HasFactory, SoftDeletes;
    protected $connection = "mysql";
    protected $table = 'hospital_section_outputs';
    protected $guarded = [];

    public function hospitalDivisionOutput()
    {
        return $this->belongsTo(hospital_division_output::class, 'idhdpcr');
    }
}
