<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProbTempoEmployees extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table='prob_tempo_employees';
    protected $guarded = [];
}
