<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StandardQuantity extends Model
{
    use HasFactory;
    protected $connection = "mysql";
    protected $table='standard_quantities';
    protected $guarded = ['id'];
}
