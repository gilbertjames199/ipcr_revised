<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailChangeLog extends Model
{
    use HasFactory;
    protected $connection = "mysql";
    protected $table = 'email_change_logs';
    protected $guarded = [];
}
