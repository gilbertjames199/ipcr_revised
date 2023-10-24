<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyAccomplishment extends Model
{
    use HasFactory;
    protected $connection = "mysql";
    protected $table = 'ipcr_monthly_accomplishments';
    protected $guarded = ['id'];
}
