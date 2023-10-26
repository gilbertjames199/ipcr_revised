<?php

namespace App\Http\Controllers;

use App\Models\Ipcr_Semestral;
use App\Models\MonthlyAccomplishment;
use App\Models\ProbationaryTemporaryEmployees;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class MonthlyAccomplishmentController extends Controller
{
    protected $model, $ipcr_sem;
    public function __construct(MonthlyAccomplishment $model, Ipcr_Semestral $ipcr_sem)
    {
        $this->model = $model;
        $this->ipcr_sem = $ipcr_sem;
    }
    public function approve_monthly(Request $request)
    {
        $empl_code = auth()->user()->username;
        // dd($empl_code);
        $targets_review = $this->ipcr_sem
            ->select(
                'ipcr__semestrals.id AS id',
                'ipcr__semestrals.status AS status',
                'ipcr__semestrals.year AS year',
                'ipcr__semestrals.sem AS sem',
                'user_employees.employee_name',
                'user_employees.empl_id'
            )
            ->where('status', '0')
            ->where('ipcr__semestrals.immediate_id', $empl_code)
            ->join('user_employees', 'user_employees.empl_id', 'ipcr__semestrals.employee_code')
            ->distinct('ipcr_semestrals.id')
            ->get()->map(function ($item) {
                return [
                    'id' => $item->id,
                    'status' => $item->status,
                    'year' => $item->year,
                    'sem' => $item->sem,
                    'employee_name' => $item->employee_name,
                    'empl_id' => $item->empl_id
                ];
            });
        $targets_approve = $this->ipcr_sem
            ->select(
                'ipcr__semestrals.id',
                'ipcr__semestrals.status',
                'ipcr__semestrals.year',
                'ipcr__semestrals.sem',
                'user_employees.employee_name',
                'user_employees.empl_id'
            )
            ->where('status', '1')
            ->where('ipcr__semestrals.next_higher', $empl_code)
            ->join('user_employees', 'user_employees.empl_id', 'ipcr__semestrals.employee_code')
            ->distinct('ipcr_semestrals.id')
            ->get()->map(function ($item) {
                return [
                    'id' => $item->id,
                    'status' => $item->status,
                    'year' => $item->year,
                    'sem' => $item->sem,
                    'employee_name' => $item->employee_name,
                    'empl_id' => $item->empl_id
                ];
            });
        // dd($targets_review);
        $targets_prob = ProbationaryTemporaryEmployees::select(
            'probationary_temporary_employees.id',
            'probationary_temporary_employees.status',
            'probationary_temporary_employees.date_from',
            'probationary_temporary_employees.prob_status',
            'user_employees.employee_name',
            'user_employees.empl_id'
        )
            ->where(function ($query) use ($empl_code) {
                $query->where(function ($query) use ($empl_code) {
                    $query->where('probationary_temporary_employees.immediate_cats', '=', $empl_code)
                        ->where('probationary_temporary_employees.status', '=', '0');
                })->orWhere(function ($query) use ($empl_code) {
                    $query->where('probationary_temporary_employees.next_higher_cats', '=', $empl_code)
                        ->where('probationary_temporary_employees.status', '=', '1');
                });
            })
            ->join('user_employees', 'user_employees.empl_id', 'probationary_temporary_employees.employee_code')
            ->get()
            ->map(function ($item) {
                $years = json_decode($item->date_from);
                $date = \Carbon\Carbon::parse($years[0]);
                $year = strval($date->year);
                return [
                    'id' => $item->id,
                    'status' => $item->status,
                    'year' => $year,
                    'sem' => $item->prob_status,
                    'employee_name' => $item->employee_name,
                    'empl_id' => $item->empl_id
                ];
            });
        // dd($targets_prob);
        $targeted = $targets_review->concat($targets_approve)->concat($targets_prob);

        // dd($targeted);
        // Paginate the merged collection
        $perPage = 10; // Set the number of items per page here
        $page = request()->get('page', 1); // Get the current page number from the request

        $targets = new LengthAwarePaginator(
            $targeted->forPage($page, $perPage),
            $targeted->count(),
            $perPage,
            $page,
            ['path' => request()->url()] // Use the current URL as the path
        );


        return inertia(
            'IPCR/Review_Accomplishments/Index',
            ['targets' => $targets]
        );
    }
}
