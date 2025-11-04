<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class hospital_individual_output extends Model
{
    use HasFactory, SoftDeletes;
    protected $connection = "mysql";
    protected $table = 'hospital_individual_outputs';
    protected $guarded = [];
    public function hospitalSectionOutput()
    {
        return $this->belongsTo(hospital_section_output::class, 'idhspcr');
    }
    public function semestralRemarks()
    {
        return $this->hasMany(SemestralRemarks::class, 'idIPCR', 'id');
    }
}
