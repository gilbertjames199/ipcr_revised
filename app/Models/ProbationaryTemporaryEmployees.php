<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProbationaryTemporaryEmployees extends Model
{
    use HasFactory;
    protected $connection = "mysql";
    protected $table='probationary_temporary_employees';
    protected $guarded = ['id'];
    public function return_remarks(){
        return $this -> hasMany(ReturnRemarks::class, 'ipcr_semestral_id', 'id')
                        ->where('type', 'probationary/temporary');
    }

    public function user()
    {
        return $this->belongsTo(UserEmployees::class, 'employee_code', 'empl_id');
    }
    public function ipcrSemestral()
    {
        return $this->hasOne(Ipcr_Semestral::class, 'id', 'sem_id')->latest();
    }
}
