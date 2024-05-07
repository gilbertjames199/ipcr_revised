<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IpcrScore extends Model
{
    use HasFactory;
    protected $connection = "mysql";
    protected $table = 'ipcr_scores';
    protected $guarded = ['id'];
}
