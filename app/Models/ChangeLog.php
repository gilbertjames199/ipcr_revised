<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChangeLog extends Model
{
    use HasFactory;
    protected $connection = "mysql";
    protected $table = 'password_change_logs';
    protected $guarded = [];

    public function emp()
    {
        return $this->hasOne(UserEmployees::class, 'empl_id', 'employee_cats');
    }
    public function acted()
    {
        return $this->hasOne(UserEmployees::class, 'empl_id', 'acted_by');
    }
}
