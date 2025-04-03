<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class hospital_section_output extends Model
{
    use HasFactory;
    protected $connection = "mysql";
    protected $table = 'hospital_section_outputs';
    protected $guarded = [];
}
