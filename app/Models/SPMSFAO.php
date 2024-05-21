<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SPMSFAO extends Model
{
    use HasFactory;
    protected $connection = "mysql";
    protected $table = 's_p_m_s_f_a_o_s';
    protected $guarded = ['id'];
}
