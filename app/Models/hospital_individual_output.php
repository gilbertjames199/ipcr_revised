<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class hospital_individual_output extends Model
{
    use HasFactory;
    protected $connection = "mysql";
    protected $table = 'hospital_individual_outputs';
    protected $guarded = [];
}
