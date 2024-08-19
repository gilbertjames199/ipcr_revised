<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class summary_rating_remarks extends Model
{
    use HasFactory;
    protected $connection = "mysql";
    protected $table = 'summary_rating_remarks';
    protected $guarded = [];
}
