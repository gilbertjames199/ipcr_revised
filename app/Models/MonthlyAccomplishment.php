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

    public function returnRemarks()
    {
        return $this->hasOne(ReturnRemarks::class, 'ipcr_monthly_accomplishment_id', 'id')->latest();
    }

    public function ipcrSemestral()
    {
        return $this->belongsTo(Ipcr_Semestral::class, 'ipcr_semestral_id');
    }

    public function deadline()
    {
        // Assuming 'month' in both tables have the same format
        return $this->belongsTo(
                DailyAccomplishmentMonth::class,
                'month',
                'month'
            );
                // ->whereExists(function ($query) {
                //     $query->select('ipcr__semestrals.id')
                //           ->from('ipcr__semestrals')
                //           ->whereColumn('ipcr__semestrals.id', '=', 'ipcr_monthly_accomplishments.ipcr_semestral_id')
                //           ->whereColumn('ipcr__semestrals.year', '=', 'daily_accomplishment_months.year');
                // });
    }

}
