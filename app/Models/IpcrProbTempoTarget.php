<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IpcrProbTempoTarget extends Model
{
    use HasFactory;
    protected $connection = "mysql";
    protected $table='ipcr_prob_tempo_targets';
    protected $guarded = ['id'];
}
