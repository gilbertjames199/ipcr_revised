<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StandardQuality extends Model
{
    use HasFactory;
    protected $connection = "mysql";
    protected $table='standard_qualities';
    protected $guarded = ['id'];
}
