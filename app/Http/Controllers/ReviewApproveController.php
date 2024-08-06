<?php

namespace App\Http\Controllers;

use App\Models\Ipcr_Semestral;
use App\Models\IPCRTargets;
use App\Models\ProbationaryTemporaryEmployees;
use App\Models\ReturnRemarks;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class ReviewApproveController extends Controller
{
    protected $ipcr_sem, $return_remarks;
    public function __construct(Ipcr_Semestral $ipcr_sem, ReturnRemarks $return_remarks)
    {
        $this->ipcr_sem = $ipcr_sem;
        $this->return_remarks = $return_remarks;
    }
    public function index(Request $request)
    {

        // // dd(auth()->user());
        $empl_code = auth()->user()->username;
        // dd($empl_code);
        $targets_review = $this->ipcr_sem
            ->select(
                'ipcr__semestrals.id AS id',
                DB::raw('NULL as id_target'),
                'ipcr__semestrals.status AS status',
                'ipcr__semestrals.year AS year',
                'ipcr__semestrals.sem AS sem',
                'user_employees.employee_name',
                'user_employees.empl_id',
                DB::raw('NULL as is_additional_target'),
                DB::raw('NULL as target_status'),
                DB::raw('NULL as ipcr_code'),
                DB::raw('NULL as individual_output'),
                'ipcr__semestrals.immediate_id',
                'ipcr__semestrals.next_higher'
            )
            ->where('status', '0')
            ->where('ipcr__semestrals.immediate_id', $empl_code)
            ->when($request->search, function ($query, $searchItem) {
                $query->where('user_employees.employee_name', 'like', '%' . $searchItem . '%');
            })
            ->join('user_employees', 'user_employees.empl_id', 'ipcr__semestrals.employee_code')
            ->union(
                Ipcr_Semestral::select(
                    'ipcr__semestrals.id AS id',
                    'i_p_c_r_targets.id as id_target',
                    'ipcr__semestrals.status AS status',
                    'ipcr__semestrals.year AS year',
                    'ipcr__semestrals.sem AS sem',
                    'user_employees.employee_name',
                    'user_employees.empl_id',
                    'i_p_c_r_targets.is_additional_target',
                    'i_p_c_r_targets.status AS target_status',
                    'i_p_c_r_targets.ipcr_code',
                    'individual_final_outputs.individual_output',
                    'ipcr__semestrals.immediate_id',
                    'ipcr__semestrals.next_higher'
                )
                    ->leftJoin('i_p_c_r_targets', 'ipcr__semestrals.id', '=', 'i_p_c_r_targets.ipcr_semester_id')
                    ->leftJoin('individual_final_outputs', 'individual_final_outputs.ipcr_code', 'i_p_c_r_targets.ipcr_code')
                    ->join('user_employees', 'user_employees.empl_id', 'ipcr__semestrals.employee_code')
                    ->where('i_p_c_r_targets.is_additional_target', 1)
                    ->where('i_p_c_r_targets.status', '0')
                    ->where('ipcr__semestrals.immediate_id', $empl_code)
                    ->when($request->search, function ($query, $searchItem) {
                        $query->where('user_employees.employee_name', 'like', '%' . $searchItem . '%');
                    })

            )
            ->distinct('ipcr_semestrals.id')
            ->get()->map(function ($item) {

                return [
                    'id' => $item->id,
                    'id_target' => $item->id_target,
                    'status' => $item->status,
                    'year' => $item->year,
                    'sem' => $item->sem,
                    'employee_name' => $item->employee_name,
                    'empl_id' => $item->empl_id,
                    'is_additional_target' => $item->is_additional_target,
                    'target_status' => $item->target_status,
                    'ipcr_code' => $item->ipcr_code,
                    'individual_output' => $item->individual_output,
                    'immediate_id' => $item->immediate_id,
                    'next_higher' => $item->next_higher
                ];
            });

        $targets_approve = $this->ipcr_sem
            ->select(
                'ipcr__semestrals.id AS id',
                DB::raw('NULL as id_target'),
                'ipcr__semestrals.status AS status',
                'ipcr__semestrals.year AS year',
                'ipcr__semestrals.sem AS sem',
                'user_employees.employee_name',
                'user_employees.empl_id',
                DB::raw('NULL as is_additional_target'),
                DB::raw('NULL as target_status'),
                DB::raw('NULL as ipcr_code'),
                DB::raw('NULL as individual_output'),
                'ipcr__semestrals.immediate_id',
                'ipcr__semestrals.next_higher'
            )
            ->where(function ($query) {
                $query->where('status', 1);
                // ->orWhere('status', 2);
            })
            ->where('ipcr__semestrals.next_higher', $empl_code)
            ->when($request->search, function ($query, $searchItem) {
                $query->where('user_employees.employee_name', 'like', '%' . $searchItem . '%');
            })
            ->join('user_employees', 'user_employees.empl_id', 'ipcr__semestrals.employee_code')
            ->distinct('ipcr_semestrals.id')
            ->union(
                Ipcr_Semestral::select(
                    'ipcr__semestrals.id AS id',
                    'i_p_c_r_targets.id as id_target',
                    'ipcr__semestrals.status AS status',
                    'ipcr__semestrals.year AS year',
                    'ipcr__semestrals.sem AS sem',
                    'user_employees.employee_name',
                    'user_employees.empl_id',
                    'i_p_c_r_targets.is_additional_target',
                    'i_p_c_r_targets.status AS target_status',
                    'i_p_c_r_targets.ipcr_code',
                    'individual_final_outputs.individual_output',
                    'ipcr__semestrals.immediate_id',
                    'ipcr__semestrals.next_higher'
                )
                    ->leftJoin('i_p_c_r_targets', 'ipcr__semestrals.id', '=', 'i_p_c_r_targets.ipcr_semester_id')
                    ->leftJoin('individual_final_outputs', 'individual_final_outputs.ipcr_code', 'i_p_c_r_targets.ipcr_code')
                    ->join('user_employees', 'user_employees.empl_id', 'ipcr__semestrals.employee_code')
                    ->when($request->search, function ($query, $searchItem) {
                        $query->where('user_employees.employee_name', 'like', '%' . $searchItem . '%');
                    })
                    ->where('i_p_c_r_targets.is_additional_target', 1)
                    ->where(function ($query) {
                        $query->where('ipcr__semestrals.status', 1);
                        // ->orWhere('ipcr__semestrals.status', 2);
                    })
                    ->where('ipcr__semestrals.next_higher', $empl_code)
                    ->where(function ($query) {
                        $query->where('i_p_c_r_targets.status', 1)
                            ->orWhere('i_p_c_r_targets.status', 2);
                    })
            )
            ->get()->map(function ($item) {

                return [
                    'id' => $item->id,
                    'id_target' => $item->id_target,
                    'status' => $item->status,
                    'year' => $item->year,
                    'sem' => $item->sem,
                    'employee_name' => $item->employee_name,
                    'empl_id' => $item->empl_id,
                    'is_additional_target' => $item->is_additional_target,
                    'target_status' => $item->target_status,
                    'ipcr_code' => $item->ipcr_code,
                    'individual_output' => $item->individual_output,
                    'immediate_id' => $item->immediate_id,
                    'next_higher' => $item->next_higher
                ];
            });
        // dd($targets_approve);
        // $rr = $this->ipcr_sem->where('next_higher', $empl_code)->where('ipcr__semestrals.status', '1')->get();
        // dd($rr);
        // dd($targets_approve);
        // dd($targets_review);

        $targets_prob = ProbationaryTemporaryEmployees::select(
            'probationary_temporary_employees.id',
            DB::raw('NULL as id_target'),
            'probationary_temporary_employees.status',
            'probationary_temporary_employees.date_from',
            'probationary_temporary_employees.prob_status',
            'user_employees.employee_name',
            'user_employees.empl_id',
            DB::raw('NULL as is_additional_target'),
            DB::raw('NULL as target_status'),
            DB::raw('NULL as ipcr_code'),
            DB::raw('NULL as individual_output'),
            'probationary_temporary_employees.immediate_cats AS immediate_id',
            'probationary_temporary_employees.next_higher_cats AS next_higher'
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
            ->when($request->search, function ($query, $searchItem) {
                $query->where('user_employees.employee_name', 'like', '%' . $searchItem . '%');
            })
            ->join('user_employees', 'user_employees.empl_id', 'probationary_temporary_employees.employee_code')
            ->get()
            ->map(function ($item) {
                $years = json_decode($item->date_from);
                $date = \Carbon\Carbon::parse($years[0]);
                $year = strval($date->year);
                return [
                    'id' => $item->id,
                    'id_target' => $item->id_target,
                    'status' => $item->status,
                    'year' => $item->year,
                    'sem' => $item->sem,
                    'employee_name' => $item->employee_name,
                    'empl_id' => $item->empl_id,
                    'is_additional_target' => $item->is_additional_target,
                    'target_status' => $item->target_status,
                    'immediate_id' => $item->immediate_id,
                    'next_higher' => $item->next_higher
                ];
            });
        // dd($targets_review);
        $targeted = $targets_review->concat($targets_approve)->concat($targets_prob);
        $targeted = $targeted->sortBy(function ($item) {
            // dd($item['target_status']);
            // Sorting logic based on multiple conditions
            if ($item['status'] === '0') {
                // dd('s0: ' . $item['status']);

                return 1; // Rows with 0 in status and 0 in target_status come first
            } elseif ($item['target_status'] === '0') {
                // dd('ts0: ' . $item['target_status']);

                return 2; // Rows with 0 in status and 1 in target_status come next
            } elseif ($item['status'] === '1') {
                // dd('s1: ' . $item['status']);

                return 3; // Rows with 1 in status and 0 in target_status come third
            } elseif ($item['target_status'] === '1') {
                // dd('ts1: ' . $item['status']);

                return 4; // Rows with 1 in status and 1 in target_status come fourth
            } elseif ($item['status'] === '2') {

                // dd('s2: ' . $item['status']);
                return 5; // Rows with 2 in status and 0 in target_status come fifth
            } elseif ($item['target_status'] === '2') {
                // dd('ts2: ' . $item['status']);

                return 6; // Rows with 2 in status and 1 in target_status come sixth
            }

            // Any other cases
        });
        $targeted = $targeted->values();
        // dd($targets_approve);
        // dd($empl_code);
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
        // dd($targets);

        return inertia(
            'IPCR/Review/Index',
            [
                'targets' => $targets,
                "filters" => $request->only(['search']),
            ]
        );
    }
    public function updateStatus(Request $request, $status, $sem_id)
    {
        $attributes = $request->validate([
            'type' => 'required',
            'ipcr_semestral_id' => 'required',
            'employee_code' => 'required',
        ]);

        $data = $this->ipcr_sem::findOrFail($sem_id);
        // dd($data);
        $data->update([
            'status' => $request->status,
        ]);

        $msg = "Reviewed IPCR Target!";
        $type = "info";

        // Assuming $status is defined somewhere in your code
        if ($status == "2") {
            $type = "message";
            $msg = "Approved IPCR Target!";
        }
        if ($status == "-2") {
            $type = "message";
            $msg = "Returned IPCR Target";
        }
        // if ($request->remarks) {
        $rem = new ReturnRemarks();
        $rem->type = $request->type;
        $rem->ipcr_semestral_id = $request->ipcr_semestral_id;
        $rem->remarks = $request->remarks;
        $rem->employee_code = $request->employee_code;
        $rem->acted_by = auth()->user()->username;
        $rem->save();
        // }

        // Check if 'remarks' exists in the request and is not null
        // if ($request->has('remarks') && $request->input('remarks') !== null) {
        //     $attributes['remarks'] = $request->input('remarks');
        // }

        // Check if 'remarks' attribute is present in the $attributes array
        // If it's present and not null, create return_remarks
        // if (array_key_exists('remarks', $attributes) && $attributes['remarks'] !== null) {
        //     $this->return_remarks->create($attributes);
        // }

        //dd('status: '.$status.' sem_id:'.$sem_id);
        // dd($request);
        // $attributes = $request->validate([
        //     'type' => 'required',
        //     'remarks' => 'nullable|required',
        //     'ipcr_semestral_id' => 'required',
        //     'employee_code' => 'required',
        // ]);
        // $data = $this->ipcr_sem::findOrFail($sem_id);
        // $data->update([
        //     'status' => $request->status,
        // ]);
        // $msg = "Reviewed IPCR Target!";
        // $type = "info";
        // if ($status == "2") {
        //     $type = "message";
        //     $msg = "Approved IPCR Target!";
        // }
        // if ($status == "-2") {
        //     $type = "error";
        //     $msg = "Returned IPCR Target";
        // }


        // $this->return_remarks->create($attributes);
        return redirect('/review/approve')
            ->with($type, $msg);
    }
    public function updateStatusSem(Request $request, $status, $sem_id)
    {
        // dd($sem_id);
        $attributes = $request->validate([
            'type' => 'required',
            'ipcr_semestral_id' => 'required',
            'employee_code' => 'required',
        ]);

        $data = $this->ipcr_sem::findOrFail($sem_id);
        // dd($data);
        $data->update([
            'status_accomplishment' => $request->status,
        ]);

        $msg = "Reviewed IPCR Target!";
        $type = "info";

        // Assuming $status is defined somewhere in your code
        if ($status == "2") {
            $type = "message";
            $msg = "Approved IPCR Target!";
        }
        if ($status == "-2") {
            $type = "message";
            $msg = "Returned IPCR Semestral Accomplishment";
        }
        // if ($request->remarks) {
        $rem = new ReturnRemarks();
        $rem->type = 'return semestral accomplishment';
        $rem->ipcr_semestral_id = $request->ipcr_semestral_id;
        $rem->remarks = $request->remarks;
        $rem->employee_code = $request->employee_code;
        $rem->acted_by = auth()->user()->username;
        $rem->save();
        // dd($rem);


        // $this->return_remarks->create($attributes);
        return redirect('/acted/particulars/accomp/lishments')
            ->with($type, $msg);
    }
    public function updateStatusProb(Request $request, $status, $sem_id)
    {
        // dd('PROB status: '.$status.' sem_id:'.$sem_id);
        $data = ProbationaryTemporaryEmployees::findOrFail($sem_id);
        $data->update([
            'status' => $request->status,
        ]);
        $msg = "Reviewed IPCR Target!";
        if ($status == "2") {
            $msg = "Approved ipcr Target!";
        }
        return redirect('/review/approve')
            ->with('message', $msg);
    }

    // /BACKUP
    public function index3(Request $request)
    {
        // dd(auth()->user());
        $empl_code = auth()->user()->username;
        // dd($empl_code);
        $targets_review = $this->ipcr_sem
            ->select(
                'ipcr__semestrals.id AS id',
                DB::raw('NULL as id_target'),
                'ipcr__semestrals.status AS status',
                'ipcr__semestrals.year AS year',
                'ipcr__semestrals.sem AS sem',
                'user_employees.employee_name',
                'user_employees.empl_id',
                DB::raw('NULL as is_additional_target'),
                DB::raw('NULL as target_status'),
                DB::raw('NULL as ipcr_code'),
                DB::raw('NULL as individual_output'),
            )
            ->where('status', '0')
            ->where('ipcr__semestrals.immediate_id', $empl_code)
            ->join('user_employees', 'user_employees.empl_id', 'ipcr__semestrals.employee_code')
            ->union(
                Ipcr_Semestral::select(
                    'ipcr__semestrals.id AS id',
                    'i_p_c_r_targets.id as id_target',
                    'ipcr__semestrals.status AS status',
                    'ipcr__semestrals.year AS year',
                    'ipcr__semestrals.sem AS sem',
                    'user_employees.employee_name',
                    'user_employees.empl_id',
                    'i_p_c_r_targets.is_additional_target',
                    'i_p_c_r_targets.status AS target_status',
                    'i_p_c_r_targets.ipcr_code',
                    'individual_final_outputs.individual_output'
                )
                    ->leftJoin('i_p_c_r_targets', 'ipcr__semestrals.id', '=', 'i_p_c_r_targets.ipcr_semester_id')
                    ->leftJoin('individual_final_outputs', 'individual_final_outputs.ipcr_code', 'i_p_c_r_targets.ipcr_code')
                    ->join('user_employees', 'user_employees.empl_id', 'ipcr__semestrals.employee_code')
                    ->where('i_p_c_r_targets.is_additional_target', 1)
                    ->where('i_p_c_r_targets.status', '0')
                    ->where('ipcr__semestrals.immediate_id', $empl_code)

            )
            ->distinct('ipcr_semestrals.id')
            ->get()->map(function ($item) {

                return [
                    'id' => $item->id,
                    'id_target' => $item->id_target,
                    'status' => $item->status,
                    'year' => $item->year,
                    'sem' => $item->sem,
                    'employee_name' => $item->employee_name,
                    'empl_id' => $item->empl_id,
                    'is_additional_target' => $item->is_additional_target,
                    'target_status' => $item->target_status,
                    'ipcr_code' => $item->ipcr_code,
                    'individual_output' => $item->individual_output
                ];
            });

        $targets_approve = $this->ipcr_sem
            ->select(
                'ipcr__semestrals.id AS id',
                DB::raw('NULL as id_target'),
                'ipcr__semestrals.status AS status',
                'ipcr__semestrals.year AS year',
                'ipcr__semestrals.sem AS sem',
                'user_employees.employee_name',
                'user_employees.empl_id',
                DB::raw('NULL as is_additional_target'),
                DB::raw('NULL as target_status'),
                DB::raw('NULL as ipcr_code'),
                DB::raw('NULL as individual_output'),
            )
            ->where(function ($query) {
                $query->where('status', 1)
                    ->orWhere('status', 2);
            })
            ->where('ipcr__semestrals.next_higher', $empl_code)
            ->join('user_employees', 'user_employees.empl_id', 'ipcr__semestrals.employee_code')
            ->distinct('ipcr_semestrals.id')
            ->union(
                Ipcr_Semestral::select(
                    'ipcr__semestrals.id AS id',
                    'i_p_c_r_targets.id as id_target',
                    'ipcr__semestrals.status AS status',
                    'ipcr__semestrals.year AS year',
                    'ipcr__semestrals.sem AS sem',
                    'user_employees.employee_name',
                    'user_employees.empl_id',
                    'i_p_c_r_targets.is_additional_target',
                    'i_p_c_r_targets.status AS target_status',
                    'i_p_c_r_targets.ipcr_code',
                    'individual_final_outputs.individual_output'
                )
                    ->leftJoin('i_p_c_r_targets', 'ipcr__semestrals.id', '=', 'i_p_c_r_targets.ipcr_semester_id')
                    ->leftJoin('individual_final_outputs', 'individual_final_outputs.ipcr_code', 'i_p_c_r_targets.ipcr_code')
                    ->join('user_employees', 'user_employees.empl_id', 'ipcr__semestrals.employee_code')
                    ->where('i_p_c_r_targets.is_additional_target', 1)
                    ->where(function ($query) {
                        $query->where('ipcr__semestrals.status', 1)
                            ->orWhere('ipcr__semestrals.status', 2);
                    })
                    ->where('ipcr__semestrals.next_higher', $empl_code)
                    ->where(function ($query) {
                        $query->where('i_p_c_r_targets.status', 1)
                            ->orWhere('i_p_c_r_targets.status', 2);
                    })
            )
            ->get()->map(function ($item) {

                return [
                    'id' => $item->id,
                    'id_target' => $item->id_target,
                    'status' => $item->status,
                    'year' => $item->year,
                    'sem' => $item->sem,
                    'employee_name' => $item->employee_name,
                    'empl_id' => $item->empl_id,
                    'is_additional_target' => $item->is_additional_target,
                    'target_status' => $item->target_status,
                    'ipcr_code' => $item->ipcr_code,
                    'individual_output' => $item->individual_output
                ];
            });
        // dd($targets_approve);
        // $rr = $this->ipcr_sem->where('next_higher', $empl_code)->where('ipcr__semestrals.status', '1')->get();
        // dd($rr);
        // dd($targets_approve);
        // dd($targets_review);

        $targets_prob = ProbationaryTemporaryEmployees::select(
            'probationary_temporary_employees.id',
            DB::raw('NULL as id_target'),
            'probationary_temporary_employees.status',
            'probationary_temporary_employees.date_from',
            'probationary_temporary_employees.prob_status',
            'user_employees.employee_name',
            'user_employees.empl_id',
            DB::raw('NULL as is_additional_target'),
            DB::raw('NULL as target_status'),
            DB::raw('NULL as ipcr_code'),
            DB::raw('NULL as individual_output'),
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
                    'id_target' => $item->id_target,
                    'status' => $item->status,
                    'year' => $item->year,
                    'sem' => $item->sem,
                    'employee_name' => $item->employee_name,
                    'empl_id' => $item->empl_id,
                    'is_additional_target' => $item->is_additional_target,
                    'target_status' => $item->target_status
                ];
            });
        // dd($targets_review);
        $targeted = $targets_review->concat($targets_approve)->concat($targets_prob);
        dd($targeted);
        $targeted = $targeted->sortBy(function ($item) {
            // dd($item['target_status']);
            // Sorting logic based on multiple conditions
            if ($item['status'] === '0') {
                // dd('s0: ' . $item['status']);

                return 1; // Rows with 0 in status and 0 in target_status come first
            } elseif ($item['target_status'] === '0') {
                // dd('ts0: ' . $item['target_status']);

                return 2; // Rows with 0 in status and 1 in target_status come next
            } elseif ($item['status'] === '1') {
                // dd('s1: ' . $item['status']);

                return 3; // Rows with 1 in status and 0 in target_status come third
            } elseif ($item['target_status'] === '1') {
                // dd('ts1: ' . $item['status']);

                return 4; // Rows with 1 in status and 1 in target_status come fourth
            } elseif ($item['status'] === '2') {

                // dd('s2: ' . $item['status']);
                return 5; // Rows with 2 in status and 0 in target_status come fifth
            } elseif ($item['target_status'] === '2') {
                // dd('ts2: ' . $item['status']);

                return 6; // Rows with 2 in status and 1 in target_status come sixth
            }

            // Any other cases
        });
        $targeted = $targeted->values();
        // dd($targets_approve);
        // dd($empl_code);
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
        // dd($targets);

        return inertia(
            'IPCR/Review/Index',
            ['targets' => $targets]
        );
    }
}
