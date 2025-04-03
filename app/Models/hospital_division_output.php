<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class hospital_division_output extends Model
{
    use HasFactory;
    protected $connection = "mysql";
    protected $table = 'hospital_division_outputs';
    protected $guarded = [];
}
