<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class hospital_division_output extends Model
{
    use HasFactory, SoftDeletes;
    protected $connection = "mysql";
    protected $table = 'hospital_division_outputs';
    protected $guarded = [];

    public function hospitalOutput()
    {
        return $this->belongsTo(hospital_output::class, 'idhpcr');
    }
}
