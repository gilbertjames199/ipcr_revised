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
}
