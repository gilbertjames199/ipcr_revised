<?php

namespace App\Http\Controllers;

use App\Models\ChangeLog;
use App\Models\EmailChangeLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChangeLogController extends Controller
{
    //
    protected $change_log;
    public function __construct(ChangeLog $change_log)
    {
        $this->change_log = $change_log;
    }
    public function index(Request $request)
    {
        // dd('Change log');
        // dd(Auth::user());
        // $dept = auth()->user()->department_code;
        $usn = auth()->user()->username;
        $ipAddress = $request->ip();
        $hostname = gethostname();

        // dd($hostname);

        if ($usn == '8510' || $usn == '8354' || $usn == '2730' || $usn == '2960') {
            $data = ChangeLog::with('acted')->with('emp')->with('impersonated')
                ->when($request->type == 'reset', function ($query) {
                    return $query->whereColumn('employee_cats', '!=', 'acted_by');
                })
                ->when($request->type == 'changed', function ($query) {
                    return $query->whereColumn('employee_cats', '=', 'acted_by');
                })
                ->when($request->date_from, function ($query) use ($request) {
                    // return $query->where('created_at', '>', Carbon::parse($request->date_from));
                    return $query->whereDate('created_at', '>=', $request->date_from);
                })
                ->when($request->date_to, function ($query) use ($request) {
                    // return $query->where('created_at', '<=', Carbon::parse($request->date_to));
                    return $query->whereDate('created_at', '<=', $request->date_to);
                })
                ->when($request->search, function ($query) use ($request) {
                    return $query->whereHas('emp', function ($query) use ($request) {
                        $query->where('employee_name', 'like', '%' . $request->search . '%');
                    })->orWhereHas('acted', function ($query) use ($request) {
                        $query->where('employee_name', 'like', '%' . $request->search . '%');
                    });
                })
                ->orderby('created_at', 'desc')
                ->paginate(10)
                ->through(function ($item) {
                    $created_at = $item->created_at->format('Y-m-d');

                    return [
                        "emp_cats" => $item->employee_cats,
                        "emp" => $item->emp->employee_name,
                        "acted_cats" => $item->acted_by,
                        "acted_by" => $item->acted->employee_name,
                        "requested_by" => $item->requested_by,
                        "impersonated" => $item->impersonated ? $item->impersonated->employee_name : "",
                        "created_at" => $created_at
                    ];
                })
                ->withQueryString();
            return inertia('Employees/PasswordChangeLog/Index', [
                "filters" => $request->only(['search']),
                "data" => $data
            ]);
        } else {
            return redirect('forbidden')->with('error', 'You are forbidden to access this page!');
        }

        // dd($data);

    }
    public function email(Request $request)
    {
        // dd('email');
        $usn = auth()->user()->username;
        if ($usn == '8510' || $usn == '8354' || $usn == '2730' || $usn == '2960') {
            $data = EmailChangeLog::paginate(10);
            return inertia('Employees/PasswordChangeLog/Email', [
                "filters" => $request->only(['search']),
                "data" => $data
            ]);
        }
    }
}
