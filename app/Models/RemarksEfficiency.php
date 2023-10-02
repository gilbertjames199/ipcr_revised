<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RemarksEfficiency extends Model
{
    use HasFactory;
    protected $connection = "mysql";
    protected $table='remarks_efficiencies';
    protected $guarded = ['id'];
}
