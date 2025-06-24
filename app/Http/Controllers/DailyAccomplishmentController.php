<?php

namespace App\Http\Controllers;

use App\Models\Daily_Accomplishment;
use App\Models\DpcrTarget;
use App\Models\HospitalTarget;
use App\Models\IndividualFinalOutput;
use App\Models\Ipcr_Semestral;
use App\Models\IpcrTarget;
use App\Models\IPCRTargets;
use App\Models\MonthlyTarget;
use App\Models\Office;
use App\Models\TimeRange;
use App\Models\User;
use App\Models\UserEmployees;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Inertia\Inertia;
use Laravel\Ui\Presets\React;

class DailyAccomplishmentController extends Controller
{
    private $model;
    public function __construct(Daily_Accomplishment $model)
    {
        $this->model = $model;
    }

    public function index(Request $request)
    {

        $emp_code = auth()->user()->username;
        // dd($emp_code);
        $data = Daily_Accomplishment::with([
            'individualFinalOutput.divisionOutput',
            'monthlyAccomplishment',
            'ipcr_Semestral'
        ])
            ->whereHas('ipcr_Semestral')
            ->select(
                'ipcr_daily_accomplishments.id',
                'ipcr_daily_accomplishments.date',
                'ipcr_daily_accomplishments.description',
                'ipcr_daily_accomplishments.emp_code',
                'ipcr_daily_accomplishments.individual_final_output_id',
                'ipcr_daily_accomplishments.individual_output',
                'ipcr_daily_accomplishments.sem_id',
            )
            ->when($request->date_from, function ($query, $searchItem) {
                $query->whereDate('ipcr_daily_accomplishments.date', '>=', $searchItem);
            })
            ->when($request->date_to, function ($query, $searchItem) {
                $query->whereDate('ipcr_daily_accomplishments.date', '<=', $searchItem);
            })
            ->when($request->date, function ($query, $searchItem) {
                $query->where('date', $searchItem);
            })
            ->when($request->month, function ($query, $searchItem) {
                $query->whereRaw('MONTH(date) = ?', $searchItem);
            })
            ->when($request->year, function ($query, $searchItem) {
                $query->whereRaw('YEAR(date) = ?', $searchItem);
            })
            ->when($request->ipcr_code, function ($query, $searchItem) {
                $query->where('idIPCR', $searchItem);
            })
            ->where('ipcr_daily_accomplishments.emp_code', $emp_code)
            ->orderBy('ipcr_daily_accomplishments.date', 'DESC')
            ->simplePaginate(10)
            ->withQueryString();

        // dd($data);
        return inertia('Daily_Accomplishment/Index', [
            "data" => fn() => $data,
            "emp_code" => $emp_code,
            // "ipcr_codes" => $ipcr_codes
        ]);
    }

    public function is_division_head(Request $request)
    {
        $us = auth()->user()->load('userEmployee', 'userEmployee.DesignatedDivisionHead');
        $is_div_head = 'emp';
        if ($us || $us->userEmployee) {
            // dd("nakitan");
            // dd($us->userEmployee);
            $is_div_head = ($us->userEmployee->DesignatedDivisionHead !== null ||
                $us->userEmployee->salary_grade >= 22) ? 'div' : 'emp';
        }
        return $is_div_head;
    }
    public function create(Request $request)
    {
        // dd('create');
        session(['previous_url' => url()->previous()]);
        // dd($is_div_head);
        // dd(auth()->user());
        // ********************************************************************
        //adjustments for section heads (SPCR) and hospital chief (HPCR)

        $emp_code = Auth()->user()->username;
        // dd($emp_code);
        $is_div_head = employee_division_head($emp_code);

        $sem = Ipcr_Semestral::select('id', 'sem', 'employee_code', 'year', 'status', DB::raw("IF(sem=1,'First Semester', 'Second Semester') as sem_in_word"), 'status_accomplishment')
            ->where('status', '2')
            ->where('employee_code', $emp_code)
            ->get();

        // dd($sem);

        $data = $this->getTargetData($is_div_head, $emp_code);
        // $is_div_head == "emp" ? $this->data_ipcr($emp_code) : $this->data_dpcr($emp_code);
        // dd($data);
        // dd($this->data_dpcr($emp_code));
        // dd($data);

        return inertia('Daily_Accomplishment/Create', [
            'emp_code' => $emp_code,
            'data' => $data,
            'sem' => $sem,
            'session' => session()->all(),
            'can' => [
                'can_access_validation' => Auth::user()->can('can_access_validation', User::class),
                'can_access_indicators' => Auth::user()->can('can_access_indicators', User::class)
            ],
        ]);
    }
    public function getTargetData($is_division_head, $emp_code)
    {
        // dd($is_division_head);
        if ($is_division_head == 'emp') {
            // $is_division_head = 'emp';
            $targets = $this->data_ipcr($emp_code);
        } else if ($is_division_head == 'div') {
            $targets = $this->data_dpcr($emp_code);
        } else if ($is_division_head == 'hemp') {
            $targets = $this->view_hipcr_targets($emp_code);
        } else if ($is_division_head == 'hsec') {
            $targets = $this->view_hspcr_targets($emp_code);
        } else if ($is_division_head == 'hdiv') {
            $targets = $this->view_hdpcr_targets($emp_code);
        } else if ($is_division_head == 'hos') {
            $targets = $this->view_hpcr_targets($emp_code);
        }
        // dd($targets);
        return $targets;
    }
    public function data_ipcr($emp_code)
    {
        return IpcrTarget::with([
            'individualOutput',
            'ipcr_Semestral',
            // 'individualOutput.majorFinalOutputs',
            // 'individualOutput.subMfo',
        ])
            ->where('employee_code', $emp_code)
            ->where(function ($query) {
                $query->where('is_additional_target', 0)
                    ->orWhere(function ($query) {
                        $query->where('is_additional_target', 1)
                            ->where('status', '>=', 2);
                    });
            })
            // ->orderBy('ipcr_code', 'ASC')
            ->get()
            ->map(function ($item) {
                // dd($item->individualOutput);
                return [
                    "id" => $item->id,
                    "semester" => $item->semester,
                    "individual_final_output_id" => $item->individualOutput ? $item->individualOutput->id : '',
                    "individual_output" => $item->individualOutput ? $item->individualOutput->individual_output : '',
                    "performance_measure" => $item->individualOutput ? $item->individualOutput->performance_measure : '',
                    "sem_id" => $item->ipcr_Semestral ? $item->ipcr_Semestral->id : '',
                    "sem" =>  $item->ipcr_Semestral ? $item->ipcr_Semestral->sem : '',
                    "year" => $item->ipcr_Semestral ? $item->ipcr_Semestral->year : '',
                    "status" => $item->ipcr_Semestral ? $item->ipcr_Semestral->status : '',
                    "pcr_type" => "ipcr"
                ];
            });
    }
    public function data_dpcr($emp_code)
    {
        return DpcrTarget::with([
            'divisionOutput',
            'ipcr_Semestral',
            // 'individualOutput.majorFinalOutputs',
            // 'individualOutput.subMfo',
        ])
            ->where('employee_code', $emp_code)
            ->where(function ($query) {
                $query->where('is_additional_target', 0)
                    ->orWhere(function ($query) {
                        $query->where('is_additional_target', 1)
                            ->where('status', '>=', 2);
                    });
            })
            // ->orderBy('ipcr_code', 'ASC')
            ->get()
            ->map(function ($item) {
                // dd($item->individualOutput);
                return [
                    "id" => $item->id,
                    "semester" => $item->semester,
                    "individual_final_output_id" => $item->divisionOutput ? $item->divisionOutput->id : '',
                    "individual_output" => $item->divisionOutput ? $item->divisionOutput->output : '',
                    "performance_measure" => $item->divisionOutput ? $item->divisionOutput->performance_measure : '',
                    "sem_id" => $item->ipcr_Semestral ? $item->ipcr_Semestral->id : '',
                    "sem" =>  $item->ipcr_Semestral ? $item->ipcr_Semestral->sem : '',
                    "year" => $item->ipcr_Semestral ? $item->ipcr_Semestral->year : '',
                    "status" => $item->ipcr_Semestral ? $item->ipcr_Semestral->status : '',
                    "pcr_type" => "dpcr"
                ];
            });
    }

    public function view_hipcr_targets($emp_code)
    {

        $targets = HospitalTarget::with([
            'ipcr',
            'ipcr.divisionOutput',
            'ipcr.divisionOutput.programAndProject',
            'ipcr.divisionOutput.programAndProject.MFO',
            'hIPCR',
            'hIPCR.hospitalSectionOutput',
            'hIPCR.hospitalSectionOutput.hospitalDivisionOutput',
            'hIPCR.hospitalSectionOutput.hospitalDivisionOutput.hospitalOutput',
            'hIPCR.hospitalSectionOutput.hospitalDivisionOutput.hospitalOutput.programAndProject',
            'hIPCR.hospitalSectionOutput.hospitalDivisionOutput.hospitalOutput.programAndProject.MFO',
            'ipcr_Semestral'
        ])
            ->where('employee_code', $emp_code)
            ->where(function ($query) {
                $query->whereHas('hIPCR')
                    ->orWhereHas('ipcr');
            })
            ->get();

        // Sort by hIPCR.id
        $sortedTargets = $targets->sortBy(function ($item) {
            return optional($item->hIPCR)->id;
        })->values();

        // Map to new structure
        return $sortedTargets->map(function ($item) {
            $pcr_type = "";
            if ($item->pcr_type === 'hipcr') {
                $id = optional($item->hIPCR)->id;
                $output = optional($item->hIPCR)->output;
                $pm = optional($item->hIPCR)->performance_measure;
                $pcr_type = "hipcr";
            } elseif ($item->pcr_type === 'ipcr') {
                $id = optional($item->ipcr)->id;
                $output = optional($item->ipcr)->individual_output;
                $pm = optional($item->ipcr)->performance_measure;
                $pcr_type = "ipcr";
            }

            return [
                "id" => $item->id,
                "semester" => $item->semester,
                "individual_final_output_id" => $id,
                "individual_output" => $output,
                "performance_measure" => $pm,
                "sem_id" => optional($item->ipcr_Semestral)->id,
                "sem" => optional($item->ipcr_Semestral)->sem,
                "year" => optional($item->ipcr_Semestral)->year,
                "status" => optional($item->ipcr_Semestral)->status,
                "pcr_type" => $pcr_type
            ];
        });
        // return $sortedTargets;
    }
    public function view_hspcr_targets($emp_code)
    {

        $targets = HospitalTarget::with([
            'hSPCR',
            'hSPCR.hospitalDivisionOutput',
            'hSPCR.hospitalDivisionOutput.hospitalOutput',
            'hSPCR.hospitalDivisionOutput.hospitalOutput.programAndProject',
            'hSPCR.hospitalDivisionOutput.hospitalOutput.programAndProject.MFO',
            'ipcr_Semestral'
        ])
            ->where('employee_code', $emp_code)
            ->whereHas('hSPCR')
            ->get(); // Reindex the collection after sorting
        // dd($targets);
        $sortedTargets = $targets->sortBy(function ($item) {
            return optional($item->hSPCR)->id; // Sorting by hIPCR.id
        });

        // If you want to reindex the collection after sorting
        $sortedTargets = $sortedTargets->values();

        // Now you can use the sorted collection
        // return $sortedTargets->map(function ($item) {
        //     //Hospital IPCR -for hospital employees
        //     $id = $item->id;
        //     $paps = "";
        //     $mfo = "";
        //     $output = "";
        //     $pm = "";
        //     // dd($item);

        //     // if ($item->pcr_type == 'hspcr') {
        //     $id = $item->idHSPCR; // Use idHSPCR for hSPCR type

        //     // Get paps_desc from hSPCR relation
        //     $paps = optional(optional(optional($item->hSPCR)->hospitalDivisionOutput)->hospitalOutput)->programAndProject->paps_desc;

        //     // Get mfo_desc from hSPCR relation
        //     $mfo = optional(optional(optional($item->hSPCR)->hospitalDivisionOutput)->hospitalOutput)->programAndProject->MFO->mfo_desc;

        //     // Get individual_output and performance_measure from hSPCR relation
        //     $output = optional($item->hSPCR)->output;
        //     $pm = optional($item->hSPCR)->performance_measure;
        //     // }

        //     return [
        //         "individual_final_output_id" => $id,
        //         "paps_desc" => $paps,
        //         "mfo_desc" => $mfo,
        //         "ipcr_type" => $item->type,
        //         "individual_output" => $output,
        //         "performance_measure" => $pm
        //     ];
        // });

        return $sortedTargets->map(function ($item) {
            $pcr_type = "";

            $id = optional($item->hSPCR)->id;
            $output = optional($item->hSPCR)->output;
            $pm = optional($item->hSPCR)->performance_measure;
            $pcr_type = "hspcr";

            return [
                "id" => $item->id,
                "semester" => $item->semester,
                "individual_final_output_id" => $id,
                "individual_output" => $output,
                "performance_measure" => $pm,
                "sem_id" => optional($item->ipcr_Semestral)->id,
                "sem" => optional($item->ipcr_Semestral)->sem,
                "year" => optional($item->ipcr_Semestral)->year,
                "status" => optional($item->ipcr_Semestral)->status,
                "pcr_type" => $pcr_type
            ];
        });
        // return $sortedTargets;
    }
    public function view_hdpcr_targets($emp_code)
    {

        $targets = HospitalTarget::with([
            'dpcr',
            'dpcr.programAndProject',
            'hDPCR',
            'hDPCR.hospitalOutput',
            'hDPCR.hospitalOutput.programAndProject',
            'hDPCR.hospitalOutput.programAndProject.MFO',
            'ipcr_Semestral'
        ])
            ->where('employee_code', $emp_code)
            // ->where('ipcr_semestral_id', $request->sem_id)
            ->where(function ($query) {
                $query->whereHas('hDPCR')
                    ->orWhereHas('dpcr');
            })
            ->get(); // Reindex the collection after sorting
        // dd($targets);
        $sortedTargets = $targets->sortBy(function ($item) {
            return optional($item->hSPCR)->id; // Sorting by hIPCR.id
        });

        // If you want to reindex the collection after sorting
        $sortedTargets = $sortedTargets->values();

        // Now you can use the sorted collection
        return $sortedTargets->map(function ($item) {
            //Hospital IPCR -for hospital employees
            $id = $item->id;
            $paps = "";
            $mfo = "";
            $output = "";
            $pm = "";
            // dd($item);

            if ($item->pcr_type == 'dpcr') {
                $id = $item->idDPCR;
                // $paps = optional(optional($item->dpcr)->programAndProject)->paps_desc;
                // $mfo = optional(optional($item->dpcr)->programAndProject)->MFO->mfo_desc;
                $output = optional($item->dpcr)->output;
                $pm = optional($item->dpcr)->performance_measure;
            }
            // Handle 'hDPCR' pcr_type
            else if ($item->pcr_type == 'hdpcr') {
                $id = $item->idHDPCR;
                // $paps = optional(optional(optional($item->hDPCR)->hospitalOutput)->programAndProject)->paps_desc;
                // $mfo = optional(optional(optional($item->hDPCR)->hospitalOutput)->programAndProject)->MFO->mfo_desc;
                $output = optional($item->hDPCR)->output;
                $pm = optional($item->hDPCR)->performance_measure;
            }

            return [
                "id" => $item->id,
                "semester" => $item->semester,
                "individual_final_output_id" => $id,
                "individual_output" => $output,
                "performance_measure" => $pm,
                "sem_id" => optional($item->ipcr_Semestral)->id,
                "sem" => optional($item->ipcr_Semestral)->sem,
                "year" => optional($item->ipcr_Semestral)->year,
                "status" => optional($item->ipcr_Semestral)->status,
                "pcr_type" => $item->pcr_type
            ];
        });
        // return $sortedTargets;
    }
    public function view_hpcr_targets($emp_code)
    {
        $targets = HospitalTarget::with([
            'hpcr',
            'hpcr.programAndProject',
            'hpcr.programAndProject.MFO',
            'ipcr_Semestral'
        ])
            ->where('employee_code', $emp_code)
            ->whereHas('hpcr')
            ->get(); // Reindex the collection after sorting
        // dd($targets);
        $sortedTargets = $targets->sortBy(function ($item) {
            return optional($item->hpcr)->id; // Sorting by hIPCR.id
        });

        // If you want to reindex the collection after sorting
        $sortedTargets = $sortedTargets->values();

        // Now you can use the sorted collection
        return $sortedTargets->map(function ($item) {
            //Hospital IPCR -for hospital employees
            $id = $item->id;
            // $paps = "";
            // $mfo = "";
            $output = "";
            $pm = "";
            // dd($item);

            if ($item->pcr_type == 'hpcr') {
                $id = $item->idHPCR; // Use idHPCR for hpcr type

                // Get paps_desc from hpcr's programAndProject relation
                // $paps = optional(optional($item->hpcr)->programAndProject)->paps_desc;

                // Get mfo_desc from hpcr's programAndProject->MFO relation
                // $mfo = optional(optional(optional($item->hpcr)->programAndProject)->MFO)->mfo_desc;

                // Get individual_output and performance_measure from hpcr
                $output = optional($item->hpcr)->output;
                $pm = optional($item->hpcr)->performance_measure;
            }

            return [
                "id" => $item->id,
                "semester" => $item->semester,
                "individual_final_output_id" => $id,
                "individual_output" => $output,
                "performance_measure" => $pm,
                "sem_id" => optional($item->ipcr_Semestral)->id,
                "sem" => optional($item->ipcr_Semestral)->sem,
                "year" => optional($item->ipcr_Semestral)->year,
                "status" => optional($item->ipcr_Semestral)->status,
                "pcr_type" => $item->pcr_type
            ];
        });
        // return $sortedTargets;
    }
    public function store(Request $request)
    {
        // dd($request->all());
        // dd($request);
        $is_div_head = $this->is_division_head($request);
        $request->validate([
            'date' => 'required',
            'description' => 'required',
            'individual_final_output_id' => 'required',
            'emp_code' => 'required',
            'individual_output' => 'required',
            'sem_id' => 'required',
        ]);

        // dd($request->all());
        // $type = $is_div_head == "div" ? "dpcr" : "ipcr";
        // $ipcr_id = $is_div_head == "div" ? NULL : $request->individual_final_output_id;
        // $dpcr_id = $is_div_head == "div" ? $request->individual_final_output_id : NULL;
        $ipcr_id = null;
        $dpcr_id = null;
        $idHIPCR = null;
        $idHPCR = null;
        $idHDPCR = null;
        $idHSPCR = null;
        // dd($request->type);
        $type = $request->type;

        if ($type == 'ipcr') {
            //IPCR
            $ipcr_id = $request->individual_final_output_id;
        } else if ($type == 'dpcr') {
            // DPCR
            $dpcr_id = $request->individual_final_output_id;
        } else if ($type == 'hipcr') {
            // Hospital IPCR
            $idHIPCR = $request->individual_final_output_id;
        } else if ($type == 'hpcr') {
            // Hospital PCR
            $idHPCR = $request->individual_final_output_id;
        } else if ($type == 'hdpcr') {
            // Hospital DPCR
            $idHDPCR = $request->individual_final_output_id;
        } else if ($type == 'hspcr') {
            // Hospital SPCR
            $idHSPCR = $request->individual_final_output_id;
        }
        $emp_type = employee_division_head($request->emp_code);
        $type = $request->type;
        $this->model->create([
            'date' => $request->date,
            'description' => $request->description,
            'individual_final_output_id' => $ipcr_id,
            'idDPCR' => $dpcr_id,
            'idHIPCR' => $idHIPCR,
            'idHPCR' => $idHPCR,
            'idHDPCR' => $idHDPCR,
            'idHSPCR' => $idHSPCR,
            'emp_code' => $request->emp_code,
            'individual_output' => $request->individual_output,
            'sem_id' => $request->sem_id,
            'type' => $type,
            'monthly_target_id' => $this->getMonthlyID(
                $request->sem_id,
                $request->individual_final_output_id,
                date('m', strtotime($request->date)),
                $type,
                $emp_type
            )
        ]);
        return redirect('/Daily_Accomplishment')
            ->with('message', 'Daily Accomplishment added');
    }
    public function getMonthlyID($sem_id, $id_ifo, $month, $type, $emp_type)
    {
        // dd($sem_id);

        $month_id = 0;
        $sem = Ipcr_Semestral::where('id', $sem_id)->first()->sem;
        if (intval($sem) > 1) {
            $month = intval($month) - 6;
        }
        // dd($emp_type);
        if ($emp_type == 'emp' || $emp_type == 'div') {
            if ($type == "ipcr") {
                // GET the IPCR Target based on the output id (Individual outputs) and sem ID
                $data = IpcrTarget::where('individual_final_output_id', $id_ifo)
                    ->where('ipcr_semestral_id', $sem_id)
                    ->first();
                // GET THE monthly target based on the previously identified target, month og accomplishment, and sem id
                $monthly_target = MonthlyTarget::where('ipcr_target_id', $data->id)
                    ->where('month', $month)
                    ->where('sem_id', $sem_id)
                    ->where('type', 'ipcr')
                    ->first();
                $month_id = $monthly_target->id;
            } else if ($type == "dpcr") {
                // GET THE DPCR Target based on the output id (Division outputs) and sem ID
                $data = DpcrTarget::where('idDPCR', $id_ifo)
                    ->where('ipcr_semestral_id', $sem_id)
                    ->first();
                // GET THE monthly target based on the previously identified target, month og accomplishment, and sem id
                $monthly_target = MonthlyTarget::where('dpcr_target_id', $data->id)
                    ->where('sem_id', $sem_id)
                    ->where('month', $month)
                    ->where('type', 'dpcr')
                    ->first();
                $month_id = $monthly_target->id;
            }
        } else {
            // dd($type);
            $data = HospitalTarget::where(function ($query) use ($id_ifo) {
                $query->where('idHIPCR', $id_ifo)
                    ->orWhere('idHPCR', $id_ifo)
                    ->orWhere('idHDPCR', $id_ifo)
                    ->orWhere('idHSPCR', $id_ifo)
                    ->orWhere('idIPCR', $id_ifo)
                    ->orWhere('idDPCR', $id_ifo);
            })
                ->where('ipcr_semestral_id', $sem_id)
                ->where('pcr_type', $type)
                ->first();
            // dd($id_ifo);'
            // dd($data);
            // dd($sem_id . " " . $id_ifo);
            $monthly_target = MonthlyTarget::where('hospital_target_id', $data->id)
                ->where('month', $month)
                ->where('sem_id', $sem_id)
                ->where('type', $type)
                ->where('is_hospital', '1')
                ->first();
            // dd($monthly_target);
            $month_id = $monthly_target->id;
        }

        return $month_id;
    }
    // public function getMonthlyIDDPCR($sem_id, $id_ifo, $month, $type)
    // {
    //     $month_id = 0;
    //     $sem = Ipcr_Semestral::where('id', $sem_id)->first()->sem;
    //     if (intval($sem) > 1) {
    //         $month = intval($month) - 6;
    //     }
    //     if ($type == "ipcr") {
    //         $data = IpcrTarget::where('individual_final_output_id', $id_ifo)
    //             ->where('ipcr_semestral_id', $sem_id)
    //             ->first();

    //         $monthly_target = MonthlyTarget::where('ipcr_target_id', $data->id)
    //             ->where('month', $month)->first();
    //         $month_id = $monthly_target->id;
    //     } else if ($type == "ipcr") {
    //         $data = DpcrTarget::where('idDPCR', $id_ifo)
    //             ->where('ipcr_semestral_id', $sem_id)
    //             ->first();

    //         $monthly_target = MonthlyTarget::where('ipcr_target_id', $data->id)
    //             ->where('month', $month)->first();
    //         $month_id = $monthly_target->id;
    //     }
    //     return $month_id;
    // }
    public function edit(Request $request, $id)
    {
        session(['previous_url' => url()->previous()]);

        // $data = $this->model->where('id', $id)->first([
        //     'id',
        //     'emp_code',
        //     'date',
        //     'individual_output',
        //     'individual_final_output_id',
        //     'description',
        //     'sem_id',
        // ]);
        // $is_div_head = $this->is_division_head($request);
        $emp_code = Auth()->user()->username;
        $is_div_head = employee_division_head($emp_code);
        $data = $is_div_head == "emp" ? $this->editIPCRData($id) : ($is_div_head == "div" ? $this->editDPCRData($id) : $this->editHospitalData($id));
        // dd($data);
        // $IPCR = $is_div_head == "emp" ? $this->data_ipcr($emp_code) : $this->data_dpcr($emp_code);
        $IPCR = $this->getTargetData($is_div_head, $emp_code);

        // dd($data);
        $sem = Ipcr_Semestral::select('id', 'sem', 'employee_code', 'year', 'status', DB::raw("IF(sem=1,'First Semester', 'Second Semester') as sem_in_word"))
            ->where('status', '2')
            ->get();
        $emp_code = Auth()->user()->username;
        // $IPCR = IndividualFinalOutput::select(
        //     'ipcr_targets.id',
        //     'individual_final_outputs.individual_output',
        //     'individual_final_outputs.id as individual_final_output_id',
        //     'ipcr__semestrals.id as sem_id',
        //     'ipcr__semestrals.sem',
        //     'ipcr__semestrals.year',
        //     'ipcr__semestrals.status',
        // )
        //     ->join('ipcr_targets', 'ipcr_targets.individual_final_output_id', 'individual_final_outputs.id')
        //     ->Leftjoin('ipcr__semestrals', 'ipcr__semestrals.id', 'ipcr_targets.ipcr_semestral_id')
        //     ->distinct('individual_final_outputs.id')
        //     ->where('ipcr_targets.employee_code', $emp_code)
        //     ->orderBy('individual_final_outputs.id')
        //     ->get();

        // dd($IPCR);

        return inertia('Daily_Accomplishment/Create', [
            "data" => $IPCR,
            "editData" => $data,
            'sem' => $sem,
            'session' => session()->all(),
            'can' => [
                'can_access_validation' => Auth::user()->can('can_access_validation', User::class),
                'can_access_indicators' => Auth::user()->can('can_access_indicators', User::class)
            ],
        ]);
    }
    public function editIPCRData($id)
    {
        return $this->model->where('id', $id)->first([
            'id',
            'emp_code',
            'date',
            'individual_output',
            'individual_final_output_id',
            'description',
            'sem_id',
            'type'
        ]);
    }
    public function editDPCRData($id)
    {
        return $this->model->where('id', $id)->first([
            'id',
            'emp_code',
            'date',
            'individual_output',
            'idDPCR as individual_final_output_id',
            'description',
            'sem_id',
            'type',
        ]);
    }
    public function editHospitalData($id)
    {
        $item = $this->model->where('id', $id)->first();
        // dd($item);
        if (!$item) {
            return null; // or throw an exception or return a default array
        }
        // dd($item);
        if ($item->type == 'hipcr') {
            $individual_final_output_id = $item->idHIPCR;
        } else if ($item->type == 'hpcr') {
            $individual_final_output_id = $item->idHPCR;
        } else if ($item->type == 'hdpcr') {
            $individual_final_output_id = $item->idHDPCR;
        } else if ($item->type == 'hspcr') {
            $individual_final_output_id = $item->idHSPCR;
        } else if ($item->type == 'ipcr') {
            $individual_final_output_id = $item->individual_final_output_id;
        } else if ($item->type == 'dpcr') {
            $individual_final_output_id = $item->idDPCR;
        } else {
            $individual_final_output_id = null; // fallback if type is unknown
        }

        return [
            'id' => $item->id,
            'emp_code' => $item->emp_code,
            'date' => $item->date,
            'individual_output' => $item->individual_output,
            'individual_final_output_id' => $individual_final_output_id,
            'description' => $item->description,
            'sem_id' => $item->sem_id,
            'type' => $item->type,
        ];
        // return $this->model->where('id', $id)->first()->map(function ($item) {
        //     if ($item->pcr_type == 'hipcr') {
        //         $individual_final_output_id = $item->idHIPCR;
        //     } else if ($item->pcr_type == 'hpcr') {
        //         $individual_final_output_id = $item->idHPCR;
        //     } else if ($item->pcr_type == 'hdpcr') {
        //         $individual_final_output_id = $item->idHDPCR;
        //     } else if ($item->pcr_type == 'hspcr') {
        //         $individual_final_output_id = $item->idHSPCR;
        //     }
        //     return [
        //         'id' => $item->id,
        //         'emp_code' => $item->emp_code,
        //         'date' => $item->date,
        //         'individual_output' => $item->individual_output,
        //         'individual_final_output_id' => $individual_final_output_id,
        //         'description' => $item->description,
        //         'sem_id' => $item->sem_id,
        //     ];
        // });
        // ->first([
        //     'id',
        //     'emp_code',
        //     'date',
        //     'individual_output',
        //     'idHIPCR as individual_final_output_id',
        //     'description',
        //     'sem_id',
        // ]);
    }
    public function update(Request $request)
    {
        // dd($request->all());
        // dd(session()->all());
        $prev_url = session('previous_url');
        $data = $this->model->findOrFail($request->id);
        // dd($data);
        // $emp_code = $data->emp_code;
        $data->update([
            // 'date' => $request->date,
            // 'individual_final_output_id' => $request->individual_final_output_id,
            // 'individual_output' => $request->individual_output,
            'description' => $request->description,
            // "sem_id" => $request->sem_id,
        ]);

        return redirect($prev_url)
            ->with('info', 'Accomplishment updated');
    }

    public function destroy(Request $request)
    {
        $data = $this->model->findOrFail($request->id);
        $data->delete();
        //dd($request->raao_id);
        return redirect('/Daily_Accomplishment')->with('warning', 'Accomplishment Deleted');
    }

    public function UserEmployee(Request $request)
    {
        $username = $request->username;
        $date_from = $request->date_from;
        $date_to = $request->date_to;
        $individual_output = $request->individual_output;

        $emp_type = employee_division_head($username);

        $data = Daily_Accomplishment::select(
            'date',
            'description',
            'individual_output',
            'user_employees.employee_name',
            'offices.office as department_name'
        )
            ->leftJoin('user_employees', 'ipcr_daily_accomplishments.emp_code', '=', 'user_employees.empl_id')
            ->leftJoin('fms.offices', 'offices.department_code', 'user_employees.department_code')
            ->where('emp_code', $username)
            ->whereBetween('date', [$date_from, $date_to])
            ->where('individual_output', $individual_output)
            ->orderBy('ipcr_daily_accomplishments.date', 'DESC')
            ->get();


        // dd($data);
        // $accomplishment = Daily_Accomplishment::select(
        //     'ipcr_daily_accomplishments.id',
        //     'ipcr_daily_accomplishments.date',
        //     'ipcr_daily_accomplishments.description',
        //     'ipcr_daily_accomplishments.individual_final_output_id',
        //     'ipcr_daily_accomplishments.emp_code',
        //     'ipcr_daily_accomplishments.remarks',
        //     'ipcr_daily_accomplishments.link',
        //     'ipcr_daily_accomplishments.individual_output',
        //     'individual_final_outputs.performance_measure',
        //     'individual_final_outputs.ipcr_code',
        //     'individual_final_outputs.idmfo',
        //     'individual_final_outputs.idsubmfo',
        //     'individual_final_outputs.id_div_output',
        //     'major_final_outputs.mfo_desc',
        //     'division_outputs.output',
        //     'user_employees.employee_name',
        //     'offices.office as department_name'
        // )
        //     ->leftJoin('individual_final_outputs', 'ipcr_daily_accomplishments.idIPCR', '=', 'individual_final_outputs.ipcr_code')
        //     ->leftJoin('major_final_outputs', 'individual_final_outputs.idmfo', '=', 'major_final_outputs.id')
        //     ->leftJoin('division_outputs', 'individual_final_outputs.id_div_output', '=', 'division_outputs.id')
        //     ->leftJoin('user_employees', 'ipcr_daily_accomplishments.emp_code', '=', 'user_employees.empl_id')
        //     ->leftJoin('fms.offices', 'offices.department_code', 'user_employees.department_code')
        //     ->selectRaw("'$date_from' as date_from, '$date_to' as date_to")
        //     ->where('ipcr_daily_accomplishments.emp_code', $username)
        //     ->whereBetween('ipcr_daily_accomplishments.date', [$date_from, $date_to])
        //     ->distinct('ipcr_daily_accomplishments.id')
        //     ->orderBy('ipcr_daily_accomplishments.date', 'DESC')
        //     ->get();

        return $data;
    }

    public function ipcr_code()
    {
        $data = IPCRTargets::get();
        return $data;
    }

    public function index_target(Request $request, $id)
    {
        $targets = IPCRTargets::where('id', $id)->first();
        $emp_code = $targets->employee_code;
        $data = Daily_Accomplishment::leftJoin('individual_final_outputs', 'ipcr_daily_accomplishments.idIPCR', '=', 'individual_final_outputs.ipcr_code')
            ->leftJoin('major_final_outputs', 'individual_final_outputs.idmfo', '=', 'major_final_outputs.id')
            ->leftJoin('division_outputs', 'individual_final_outputs.id_div_output', '=', 'division_outputs.id')
            ->select(
                'ipcr_daily_accomplishments.id',
                'ipcr_daily_accomplishments.date',
                'ipcr_daily_accomplishments.description',
                'ipcr_daily_accomplishments.quantity',
                'ipcr_daily_accomplishments.idIPCR',
                'ipcr_daily_accomplishments.emp_code',
                'ipcr_daily_accomplishments.remarks',
                'ipcr_daily_accomplishments.link',
                'ipcr_daily_accomplishments.individual_output',
                'individual_final_outputs.ipcr_code',
                'individual_final_outputs.idmfo',
                'individual_final_outputs.idsubmfo',
                'individual_final_outputs.id_div_output',
                'major_final_outputs.mfo_desc',
                'division_outputs.output'
            )->with('IPCRCode', 'IPCR')
            ->where('ipcr_daily_accomplishments.sem_id', $targets->ipcr_semester_id)
            ->where('ipcr_daily_accomplishments.emp_code', $emp_code)
            ->where('ipcr_daily_accomplishments.idIPCR', $targets->ipcr_code)
            ->orderBy('ipcr_daily_accomplishments.date', 'DESC')
            ->get();

        // dd($data);
        return inertia('Daily_Accomplishment/Index', [
            "data" => fn() => $data,
            "emp_code" => $emp_code
        ]);
    }
    public function store_api(Request $request)
    {
        $emp_code = $request->emp_code;
        $current_month = date('m'); // Get the current month (01-12)
        $current_year = date('Y');
        $currentSem = 0;


        if ($current_month < 7) {
            $currentSem  = 1;
        } else {
            $currentSem = 2;
        }

        $data = Ipcr_Semestral::select(
            'ipcr__semestrals.id',
        )
            ->where('ipcr__semestrals.sem', $currentSem)
            ->where('ipcr__semestrals.employee_code', $emp_code)
            ->where('ipcr__semestrals.year', $current_year)
            ->get();

        return $data;
    }

    public function sync_daily(Request $request)
    {
        $date_from = $request->date_from;
        $date_to = $request->date_to;

        $apiUrl = 'http://192.168.80.81/sync-accomplishment?from=' . $date_from . '&to=' . $date_to;



        $data = [];
        try {
            // Initialize GuzzleHTTP client
            $client = new Client();

            // Make an HTTP POST request to the API URL
            $response = $client->get($apiUrl, [
                // If the API requires any specific data in the request body, you can add it here
                'form_params' => [
                    'key' => 'value',
                    // Add more parameters as needed
                ],
                // If the API requires headers or authentication, you can add them here
                'headers' => [
                    'Authorization' => 'Bearer YOUR_API_TOKEN', // Replace with your API token or credentials
                    // Add more headers if needed
                ],
            ]);
            $rated_by_ipcr = 124;
            $data = json_decode($response->getBody(), true);

            // dd($data);

            $length = count($data);
            $mapped_data = [];
            $mapped_data2 = [];
            for ($i = 0; $i < $length; $i++) {
                $reviewed_at = $data[$i]['due_date'];
                // dd($reviewed_at);
                if ($data[$i]['description'] && $data[$i]['due_date'] &&  $data[$i]['ipcr_code'] && $data[$i]['started_at']  && $data[$i]['completed_at'] && $data[$i]['cats'] && $data[$i]['cats_reviewer']) {
                    if ($data[$i]['rated_by_ipcr_code'] == null) {
                        $data[$i]['rated_by_ipcr_code'] = $rated_by_ipcr;
                    }
                    if ($data[$i]['reviewed_at'] == null) {
                        $data[$i]['reviewed_at'] = $reviewed_at;
                    }
                    $val = $this->SyncReviewee($data[$i]);
                    array_push($mapped_data, $val);
                    $val1 = $this->SyncReviewer($data[$i]);
                    array_push($mapped_data2, $val1);
                }
            }
            $chunk_data = array_chunk($mapped_data, 1000);

            foreach ($chunk_data as $key => $value) {
                foreach ($value as $datas) {
                    Daily_Accomplishment::updateOrCreate(
                        [
                            'idPM' => $datas['idPM'],
                            'emp_code' => $datas['emp_code'],
                        ],
                        $datas
                    );
                }
            }
            $chunk_data2 = array_chunk($mapped_data2, 1000);
            foreach ($chunk_data2 as $key => $value) {
                foreach ($value as $datas) {
                    Daily_Accomplishment::updateOrCreate(
                        [
                            'idPM' => $datas['idPM'],
                            'emp_code' => $datas['emp_code']
                        ],
                        $datas
                    );
                }
            }
        } catch (\Exception $e) {
            //throw $th;
            return Inertia::render('ErrorView', [
                'message' => 'Failed to retrieve data from the API.',
            ]);
        }

        return redirect('Daily_Accomplishment/')
            ->with('message', 'PM synced successfully!');
    }

    public function SyncReviewee($datum)
    {

        $date_daily = $datum['reviewed_at'];
        $due_date = $datum['due_date'];
        $ipcr_code = $datum['ipcr_code'];
        $emp_code = $datum['cats'];
        $description = $datum['description'];
        $carbonDate = Carbon::parse($date_daily)->startOfDay();
        $carbonDue = Carbon::parse($due_date)->startOfDay();
        $year = $carbonDate->format("Y"); // Four-digit year
        $month = $carbonDate->format("n");
        $dateOnly = $carbonDate->format("Y-m-d");


        if ($description == null) {
            $description = "";
        }

        $currentSem = 0;
        if ($month < 7) {
            $currentSem  = 1;
        } else {
            $currentSem = 2;
        }
        $data = Ipcr_Semestral::select(
            'ipcr__semestrals.id',
        )
            ->where('ipcr__semestrals.sem', $currentSem)
            ->where('ipcr__semestrals.employee_code', $emp_code)
            ->where('ipcr__semestrals.year', $year)
            ->first();

        $output = IndividualFinalOutput::select(
            'individual_final_outputs.individual_output',
            'individual_final_outputs.quality_error',
            'individual_final_outputs.unit_of_time',
            'individual_final_outputs.time_range_code',
        )
            ->where('individual_final_outputs.ipcr_code', $ipcr_code)
            ->first();

        $time_range_code = $output->time_range_code;
        $time_range = TimeRange::select(
            'time_ranges.time_code',
            'time_ranges.equivalent_time_to',
        )
            ->where('time_ranges.time_code', $time_range_code)
            ->where('time_ranges.rating', 4)
            ->first();

        $quality = 0;
        //quality = 1 error
        //quality = 2 ave. feedback
        if ($output->quality_error == 1) {
            $quality = 5;
        } else if ($output->quality_error == 2) {
            if ($carbonDate->lessThanOrEqualTo($carbonDue)) {
                $quality = 5;
            } else {
                $quality = 4;
            }
        }


        $quantity = 1;
        $timeliness = $time_range->equivalent_time_to;
        $average_timeliness = $quantity * $timeliness;

        $syncing = [
            'date' => $dateOnly,
            'description' => $description,
            'quantity' => 1,
            'timeliness' => $time_range->equivalent_time_to,
            'average_timeliness' => $average_timeliness,
            'quality' => $quality,
            'idIPCR' => $datum['ipcr_code'],
            'emp_code' => $datum['cats'],
            'sem_id' => $data->id,
            'individual_output' => $output->individual_output,
            'idPM' => $datum['id'],
        ];

        return $syncing;
    }

    public function SyncReviewer($datum)
    {
        $date_daily = $datum['completed_at'];
        $date_review = $datum['reviewed_at'];
        $ipcr_code = $datum['rated_by_ipcr_code'];
        $emp_code = $datum['cats_reviewer'];
        $description = $datum['description'];
        $carbonDate = Carbon::parse($date_daily)->startOfDay();
        $carbonReview = Carbon::parse($date_review)->startOfDay();
        $year = $carbonDate->format("Y"); // Four-digit year
        $month = $carbonDate->format("n");
        $dateOnly = $carbonDate->format("Y-m-d");
        if ($description == null) {
            $description = "";
        }
        $currentSem = 0;
        if ($month < 7) {
            $currentSem  = 1;
        } else {
            $currentSem = 2;
        }
        $data = Ipcr_Semestral::select(
            'ipcr__semestrals.id',
        )
            ->where('ipcr__semestrals.sem', $currentSem)
            ->where('ipcr__semestrals.employee_code', $emp_code)
            ->where('ipcr__semestrals.year', $year)
            ->first();

        $output = IndividualFinalOutput::select(
            'individual_final_outputs.individual_output',
            'individual_final_outputs.quality_error',
            'individual_final_outputs.unit_of_time',
            'individual_final_outputs.time_range_code',
        )
            ->where('individual_final_outputs.ipcr_code', $ipcr_code)
            ->first();
        $time_range_code = $output->time_range_code;
        $time_range = TimeRange::select(
            'time_ranges.time_code',
            'time_ranges.equivalent_time_to',
        )
            ->where('time_ranges.time_code', $time_range_code)
            ->where('time_ranges.rating', 4)
            ->first();
        $quality = 0;

        $daysdiff = $carbonReview->diffInDays($carbonDate);
        //quality = 1 error
        //quality = 2 ave. feedback
        if ($output->quality_error == 1) {
            $quality = 5;
        } else if ($output->quality_error == 2) {
            if ($daysdiff <= 3) {
                $quality = 5;
            } else {
                $quality = 4;
            }
        }

        $quantity = 1;
        $timeliness = $time_range->equivalent_time_to;
        $average_timeliness = $quantity * $timeliness;
        $syncing = [
            'date' => $dateOnly,
            'description' => "Reviewed - " . $description,
            'quantity' => 1,
            'timeliness' => $time_range->equivalent_time_to,
            'average_timeliness' => $average_timeliness,
            'quality' => $quality,
            'idIPCR' => $ipcr_code,
            'emp_code' => $datum['cats_reviewer'],
            'sem_id' => $data->id,
            'individual_output' => $output->individual_output,
            'idPM' => $datum['id'],
        ];
        return $syncing;
    }
}
