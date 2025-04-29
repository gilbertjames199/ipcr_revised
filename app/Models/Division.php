<?php

namespace App\Models;

use App\Traits\LogsImpersonatedActions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    use HasFactory, LogsImpersonatedActions;
    protected $connection = "mysql";
    protected $table = 'divisions';
    protected $guarded = [];

    public function Office()
    {
        return $this->belongsTo(Office::class, 'department_code', 'department_code');
    }
}
