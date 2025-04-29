<?php

namespace App\Models;

use App\Traits\LogsImpersonatedActions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyAccomplishmentRating extends Model
{
    use HasFactory, LogsImpersonatedActions;


    public function ipcr_Semestral()
    {
        return $this->belongsTo(Ipcr_Semestral::class, 'ipcr_sem_id', 'id');
    }
}
