<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImpersonatorTransactionLog extends Model
{
    use HasFactory;
    protected $connection = "mysql";
    protected $table = 'impersonate_transaction_logs';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $guarded = [
        'id',
    ];
}
