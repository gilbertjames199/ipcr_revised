<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyTarget extends Model
{
    use HasFactory;
    protected $connection = "mysql";
    protected $table = 'monthly_targets';
    protected $guarded = ['id'];
    public function returnRemarks()
    {
        return $this->hasOne(ReturnRemarks::class, 'ipcr_monthly_target_id', 'id')->latest();
    }
    public function dailyAccomplishments()
    {
        return $this->hasMany(Daily_Accomplishment::class, 'monthly_target_id', 'id');
    }
}
