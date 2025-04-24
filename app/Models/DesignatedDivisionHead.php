<?php

namespace App\Models;

use App\Traits\LogsImpersonatedActions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DesignatedDivisionHead extends Model
{
    use HasFactory, LogsImpersonatedActions;
    protected $connection = "mysql";
    protected $table = 'designated_division_heads';
    protected $guarded = ['id'];
    // protected $with = ['Division'];
    public function userEmployee()
    {
        return $this->hasOne(UserEmployees::class, 'empl_id', 'empl_id');
    }
    public function Division()
    {
        return $this->hasOne(Division::class, 'division_code', 'division_code');
    }
    public function office()
    {
        return $this->hasOne(Office::class, 'department_code', 'department_code');
    }
    // public function Office()
    // {
    //     return $this->belongsTo(Office::class, 'department_code', 'department_code');
    // }
}
