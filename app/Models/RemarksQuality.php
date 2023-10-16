<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RemarksQuality extends Model
{
    use HasFactory;
    protected $connection = "mysql";
    protected $table='remarks_qualities';
    protected $guarded = ['id'];
}
