<?php

namespace App\Traits;

use App\Models\ImpersonatorTransactionLog;
use App\Models\TransactionLog;
use App\Models\UserEmployeeCredential;
use Illuminate\Support\Facades\Auth;
use Lab404\Impersonate\Services\ImpersonateManager;

trait LogsImpersonatedActions
{
    public static function bootLogsImpersonatedActions()
    {
        static::created(function ($model) {
            $model->logAction('created');
        });

        static::updated(function ($model) {
            $model->logAction('updated');
        });

        static::deleted(function ($model) {
            $model->logAction('deleted');
        });
    }

    protected function logAction($action)
    {
        // dd("rrrr");
        $impersonator = session()->get('impersonated_by');
        if ($impersonator) {
            $impersonatorId = UserEmployeeCredential::find($impersonator)->username;
            // $impersonatorUser = UserEmployees::where('id')
            $impersonatedId = auth()->user()->username;

            ImpersonatorTransactionLog::create([
                'impersonator_id' => $impersonatorId,
                'impersonated_id' => $impersonatedId,
                'action' => $action,
                'table_name' => $this->getTable(),
                'row_id' => $this->getKey(),
                'description' => "Impersonated {$action} on {$this->getTable()} (ID: {$this->getKey()})"
            ]);
        }
    }
}
