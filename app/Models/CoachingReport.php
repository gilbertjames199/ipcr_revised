<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoachingReport extends Model
{
    use HasFactory;
    protected $connection = "mysql";
    protected $table = 'coaching_reports';
    protected $guarded = [];


}
