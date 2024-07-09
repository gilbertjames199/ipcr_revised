<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ipcr_Semestral extends Model
{
    use HasFactory;
    protected $connection = "mysql";
    protected $table = 'ipcr__semestrals';
    protected $guarded = ['id'];

    public function monthly_accomplishment()
    {
        return $this->hasMany(MonthlyAccomplishment::class, 'ipcr_semestral_id', 'id');
    }

    public function immediate()
    {
        return $this->hasOne(UserEmployees::class, 'empl_id', 'immediate_id');
    }

    public function next_higher()
    {
        return $this->hasOne(UserEmployees::class, 'empl_id', 'next_higher');
    }

    public function userEmployee()
    {
        return $this->belongsTo(UserEmployees::class, 'employee_code', 'empl_id');
    }
}
