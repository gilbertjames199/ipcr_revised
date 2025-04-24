<?php

namespace App\Http\Middleware;

use App\Models\ImpersonatorTransactionLog;
use App\Models\UserEmployeeCredential;
use App\Models\UserEmployees;
// use App\Models\TransactionLog;
use Closure;
use Illuminate\Http\Request;

class LogImpersonatedActions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $impersonator = session()->get('impersonated_by');
        if ($impersonator) {
            $impersonatorId = UserEmployeeCredential::find($impersonator)->username;
            // $impersonatorUser = UserEmployees::where('id')
            $impersonatedId = auth()->user()->username;

            ImpersonatorTransactionLog::create([
                'impersonator_id' => $impersonatorId,
                'impersonated_id' => $impersonatedId,
                'action' => 'impersonated_action',
                'description' => "Impersonated action on {$request->path()}"
            ]);
        }
        return $next($request);
    }
}
