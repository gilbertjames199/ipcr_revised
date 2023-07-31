<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ipcr_Semestral extends Model
{
    use HasFactory;
    protected $connection = "mysql";
    protected $table='ipcr__semestrals';
    protected $guarded = ['id'];
}
