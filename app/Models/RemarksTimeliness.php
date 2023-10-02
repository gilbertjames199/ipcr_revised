<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RemarksTimeliness extends Model
{
    use HasFactory;
    protected $connection = "mysql";
    protected $table='remarks_timelinesses';
    protected $guarded = ['id'];
}
