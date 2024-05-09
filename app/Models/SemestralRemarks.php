<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SemestralRemarks extends Model
{
    use HasFactory;
    protected $connection = "mysql";
    protected $table = 'semestral_remarks';
    protected $guarded = ['id'];
}
