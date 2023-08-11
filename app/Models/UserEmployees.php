<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserEmployees extends Model
{
    use HasFactory;
    protected $connection = "mysql";
    protected $table='user_employees';
    protected $guarded=['id'];


    public function Division(){
        return $this -> hasOne(Division::class, 'division_code', 'division_code');
    }
    public function Office(){
        return $this -> hasOne(Office::class, 'department_code', 'department_code');
    }
}
