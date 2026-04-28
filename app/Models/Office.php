<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    use HasFactory;
    protected $connection = 'mysql2';
    protected $table = 'offices';
    protected $guarded = [];

    public function pgHead()
    {
        return $this->belongsTo(UserEmployees::class, 'empl_id', 'empl_id');
    }

    public function employees()
    {
        return $this->hasMany(UserEmployees::class, 'department_code', 'department_code');
    }

    public function userEmployees()
    {
        return $this->hasMany(UserEmployees::class, 'department_code', 'department_code');
    }
}
