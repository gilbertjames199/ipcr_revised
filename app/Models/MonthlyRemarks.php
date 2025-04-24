<?php

namespace App\Models;

use App\Traits\LogsImpersonatedActions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyRemarks extends Model
{
    use HasFactory, LogsImpersonatedActions;
    protected $connection = "mysql";
    protected $table = 'monthly_remarks';
    protected $guarded = ['id'];
}
