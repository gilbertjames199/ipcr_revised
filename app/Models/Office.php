<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    use HasFactory;
<<<<<<< HEAD
    protected $connection = "mysql2";
=======
    protected $connection = 'mysql2';
>>>>>>> 70b9ce134b14a4ea6b962549b676987e0d4167cb
    protected $table='offices';
    protected $guarded = [];
}
