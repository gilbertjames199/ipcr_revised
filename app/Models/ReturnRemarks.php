<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnRemarks extends Model
{
    use HasFactory;
    protected $connection = "mysql";
    protected $table = 'return_remarks';
    protected $guarded = [];

    public function ipcrSemestral()
    {
        return $this->belongsTo(Ipcr_Semestral::class, 'id', 'ipcr_semestral_id',);
    }
}
