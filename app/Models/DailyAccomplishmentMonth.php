<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyAccomplishmentMonth extends Model
{
    use HasFactory;
    protected $connection = "mysql";
    protected $table = 'daily_accomplishment_months';
    protected $guarded = ['id'];
}
