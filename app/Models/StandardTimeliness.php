<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StandardTimeliness extends Model
{
    use HasFactory;
    protected $connection = "mysql";
    protected $table='standard_timelinesses';
    protected $guarded = ['id'];
}
