<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProbationaryTemporaryMonths extends Model
{
    use HasFactory;
    protected $connection = "mysql";
    protected $table='probationary_temporary_months';
    protected $guarded = ['id'];
}
