<?php

namespace App\Http\Controllers;

use App\Models\DivisionOutput;
use App\Models\IndividualFinalOutput;
use App\Models\MajorFinalOutput;
use App\Models\Office;
use App\Models\SubMfo;
use App\Models\TimeRange;
use Illuminate\Http\Request;

class IndividualFinalOutputController extends Controller
{
    protected $ifo, $submfo, $mfo, $division, $div_output;
    public function __construct(IndividualFinalOutput $ifo)
    {
        $this->ifo = $ifo;
    }
    public function index(Request $request)
    {
        // $dept_code = auth()->user()->department_code;
        $empl_id = auth()->user()->username;
        // dd(auth()->user()->username);
        if ($empl_id == '2960' || $empl_id == '2730' || $empl_id == '8510' || $empl_id == '8354') {
            $offices = Office::where(
                function ($query) {
                    $query->where('offices.office', 'LIKE', '%Office%')
                        ->orWhere('offices.office', 'LIKE', '%Hospital%');
                }
            )->orderBy('offices.office', 'ASC')
                ->get();
            // dd('uindid');
            // dd($request->search);
            $data = IndividualFinalOutput::with(
                'DivisionOutput',
                'DivisionOutput.division',
                'majorFinalOutputs',
                'subMfo'
            )
                ->when($request->search, function ($query, $searchValue) {
                    // dd($searchValue);
                    return $query->where(function ($query) use ($searchValue) {
                        $query->where('individual_final_outputs.individual_output', 'LIKE', '%' . $searchValue . '%')
                            ->orWhere('individual_final_outputs.performance_measure', 'LIKE', '%' . $searchValue . '%')
                            ->orWhere('individual_final_outputs.ipcr_code', 'LIKE', '%' . $searchValue . '%');
                    });
                })
                ->when($request->office, function ($query, $FFUNCCOD) {
                    $query->whereHas('majorFinalOutputs', function ($query) use ($FFUNCCOD) {
                        $query->where('FFUNCCOD', $FFUNCCOD);
                    });
                })
                ->orderBy('ipcr_code', 'ASC')
                ->simplePaginate(10)
                ->through(function ($item) {
                    $div = "";
                    $output = "";
                    $mfo_desc = "";
                    $FFUNCCOD = "";
                    $submfo_description = "";
                    if ($item->DivisionOutput) {
                        $output = $item->DivisionOutput->output;
                        if ($item->DivisionOutput->division) {
                            $div = $item->DivisionOutput->division;
                        }
                    }
                    if ($item->majorFinalOutputs) {
                        $mfo_desc = $item->majorFinalOutputs->mfo_desc;
                        $FFUNCCOD = $item->majorFinalOutputs->FFUNCCOD;
                    }
                    if ($item->subMfo) {
                        $submfo_description = $item->subMfo->submfo_description;
                    }
                    return [
                        "ipcr_code" => $item->ipcr_code,
                        "id" => $item->id,
                        "individual_output" => $item->individual_output,
                        "performance_measure" => $item->performance_measure,
                        "division" => $div,
                        "output" => $output,
                        "mfo_desc" => $mfo_desc,
                        "FFUNCCOD" => $FFUNCCOD,
                        "submfo_description" => $submfo_description,
                    ];
                })
                ->withQueryString();
            // dd($data);

            // dd($data->pluck('performance_measure'));
            return inertia('IPCR/IndividualOutput/Index', [
                "data" => $data,
                "offices" => $offices
            ]);
        } else {
            return redirect('/forbidden')
                ->with('error', 'Access forbidden!');
        }
    }

    public function create(Request $request)
    {
        $office = Office::get();
        $major_final_outputs = MajorFinalOutput::orderBy('FFUNCCOD', 'ASC')
            ->orderBy('mfo_desc', 'ASC')
            ->get();
        $submfo = SubMfo::get();
        $divoutput = DivisionOutput::get();
        $t_r = TimeRange::groupBy('time_code')->get();
        $error_feedback = IndividualFinalOutput::select('error_feedback')
            ->distinct('error_feedback')->get();
        // dd($error_feedback);
        // dd("create");
        // $indiv = IndividualFinalOutput::get();
        return inertia('IPCR/IndividualOutput/Create', [
            "offices" => $office,
            "major_final_outputs" => $major_final_outputs,
            "submfo" => $submfo,
            "divoutput" => $divoutput,
            "time_ranges" => $t_r,
            "error_feedback" => $error_feedback,
        ]);
    }
    public function store(Request $request)
    {
        // dd('store');
        // dd($request);
        $maxIpcrCode = IndividualFinalOutput::max('ipcr_code');
        $maxIpcrCode = intval($maxIpcrCode) + 1;
        $attribute = $request->validate([
            'idmfo' => 'required',
            // 'idsubmfo' => 'required',
            // 'id_div_output' => 'required',
            'individual_output' => 'required',
            'performance_measure' => 'required',
            'success_indicator' => 'required',
            // 'quantity_type' => 'required',
            // 'quality_error' => 'required',
            // 'time_range_code' => 'required',
            // 'time_based' => 'required',
            // 'activity' => 'required',
            // 'verb' => 'required',
            // 'error_feedback' => 'required',
            // 'within' => 'required',
            // 'unit_of_time' => 'required',
            // 'concatenate' => 'required',
        ]);
        $indiv = new IndividualFinalOutput();
        $indiv->ipcr_code = $maxIpcrCode;
        $indiv->idmfo = $request->idmfo;
        $indiv->idsubmfo = $request->idsubmfo;
        $indiv->id_div_output = $request->id_div_output;
        $indiv->individual_output = $request->individual_output;
        $indiv->performance_measure = $request->performance_measure;
        $indiv->success_indicator = $request->success_indicator;
        $indiv->quantity_type = $request->quantity_type;
        $indiv->quality_error = $request->quality_error;
        $indiv->time_range_code = $request->time_range_code;
        $indiv->time_based = $request->time_based;
        $indiv->activity = $request->activity;
        $indiv->verb = $request->verb;
        $indiv->error_feedback = $request->error_feedback;
        $indiv->within = $request->within;
        $indiv->unit_of_time = $request->unit_of_time;
        $indiv->concatenate = $request->concatenate;
        $indiv->save();
        return redirect('/individual-final-output-crud/')
            ->with('message', 'Successfully added IPCR');
        // $indiv->concatenate = $request->concatenate;
    }
    public function edit(Request $request)
    {
        // dd('edit id: ' . $request->id);
        $data = IndividualFinalOutput::where('id', $request->id)->first();
        // dd($data);
        $FFUNCCOD = "";
        $mfo_selected = MajorFinalOutput::where('id', $data->idmfo)->first();
        if ($mfo_selected) {
            $FFUNCCOD = $mfo_selected->FFUNCCOD;
        }
        $office = Office::get();
        $major_final_outputs = MajorFinalOutput::orderBy('FFUNCCOD', 'ASC')
            ->orderBy('mfo_desc', 'ASC')
            ->get();
        $submfo = SubMfo::get();
        $divoutput = DivisionOutput::get();
        $t_r = TimeRange::groupBy('time_code')->get();
        $error_feedback = IndividualFinalOutput::select('error_feedback')
            ->distinct('error_feedback')->get();
        // dd($error_feedback);
        // dd("create");
        return inertia('IPCR/IndividualOutput/Create', [
            "offices" => $office,
            "major_final_outputs" => $major_final_outputs,
            "submfo" => $submfo,
            "divoutput" => $divoutput,
            "time_ranges" => $t_r,
            "error_feedback" => $error_feedback,
            "editData" => $data,
            "FFUNCCOD_selected" => $FFUNCCOD
        ]);
    }
    public function update(Request $request)
    {
        // dd('update');
        $attribute = $request->validate([
            'idmfo' => 'required',
            // 'idsubmfo' => 'required',
            // 'id_div_output' => 'required',
            'individual_output' => 'required',
            'performance_measure' => 'required',
            'success_indicator' => 'required',
            // 'quantity_type' => 'required',
            // 'quality_error' => 'required',
            // 'time_range_code' => 'required',
            // 'time_based' => 'required',
            // 'activity' => 'required',
            // 'verb' => 'required',
            // 'error_feedback' => 'required',
            // 'within' => 'required',
            // 'unit_of_time' => 'required',
            // 'concatenate' => 'required',
        ]);
        // dd($request->id);
        $indiv = IndividualFinalOutput::findOrFail($request->id);
        $indiv->idmfo = $request->idmfo;
        $indiv->idsubmfo = $request->idsubmfo;
        $indiv->id_div_output = $request->id_div_output;
        $indiv->individual_output = $request->individual_output;
        $indiv->performance_measure = $request->performance_measure;
        $indiv->success_indicator = $request->success_indicator;
        $indiv->quantity_type = $request->quantity_type;
        $indiv->quality_error = $request->quality_error;
        $indiv->time_range_code = $request->time_range_code;
        $indiv->time_based = $request->time_based;
        $indiv->activity = $request->activity;
        $indiv->verb = $request->verb;
        $indiv->error_feedback = $request->error_feedback;
        $indiv->within = $request->within;
        $indiv->unit_of_time = $request->unit_of_time;
        $indiv->concatenate = $request->concatenate;
        $indiv->save();
        $my_page = floatval($indiv->ipcr_code) / 10;
        $current_page = intval(intval($indiv->ipcr_code) / 10);
        $myPage2 = floatval($current_page);
        if ($my_page > $myPage2) {
            $current_page = intval($current_page) + 1;
        }
        return redirect('/individual-final-output-crud?page=' . $current_page)
            ->with('info', 'Successfully updated IPCR');
        // dd($indiv);
    }
    public function destroy(Request $request, $id)
    {
        // dd($id);
        // $my_page = floatval($id) / 10;
        $current_page = intval(intval($id) / 10);

        IndividualFinalOutput::where('id', $id)->delete();
        return redirect('/individual-final-output-crud?page=' . $current_page)
            ->with('deleted', 'Successfully deleted IPCR');
    }
    public function get_mfos(Request $request)
    {
        // dd($request->FFUNCCOD);
        return MajorFinalOutput::where('FFUNCCOD', $request->FFUNCCOD)
            ->orderBy('major_final_outputs.mfo_desc', 'ASC')
            ->get();
    }
    public function get_submfos(Request $request)
    {
        // dd($request->idmfo);
        return SubMfo::where('idmfo', $request->idmfo)->get();
    }
    public function get_div_output(Request $request)
    {
        return DivisionOutput::where('idmfo', $request->idmfo)
            ->get();
    }
    public function get_time_range(Request $request)
    {
        return TimeRange::where('time_code', $request->time_code)
            ->orderBy('rating', 'DESC')
            ->get();
    }
    public function dataBackupCode(Request $request)
    {
        $data = IndividualFinalOutput::select(
            'individual_final_outputs.ipcr_code',
            'individual_final_outputs.id',
            'individual_final_outputs.individual_output',
            'individual_final_outputs.performance_measure',
            'divisions.division_name1 AS division',
            'division_outputs.output',
            'major_final_outputs.mfo_desc',
            'major_final_outputs.FFUNCCOD',
            'sub_mfos.submfo_description'
        )
            ->when($request->office, function ($query, $searchValue) {
                // dd($searchValue);
                $query->where('major_final_outputs.FFUNCCOD', $searchValue);
            })
            ->when($request->search, function ($query, $searchValue) {
                // dd($searchValue);
                return $query->where(function ($query) use ($searchValue) {
                    $query->where('individual_final_outputs.individual_output', 'LIKE', '%' . $searchValue . '%')
                        ->orWhere('individual_final_outputs.performance_measure', 'LIKE', '%' . $searchValue . '%')
                        ->orWhere('individual_final_outputs.ipcr_code', 'LIKE', '%' . $searchValue . '%');
                });
            })
            ->leftjoin('division_outputs', 'division_outputs.id', 'individual_final_outputs.id_div_output')
            ->leftjoin('divisions', 'divisions.id', 'division_outputs.division_id')
            ->leftjoin('major_final_outputs', 'major_final_outputs.id', 'individual_final_outputs.idmfo')
            ->leftjoin('sub_mfos', 'sub_mfos.id', 'individual_final_outputs.idsubmfo')
            ->orderBy('individual_final_outputs.ipcr_code')
            ->paginate(10)->withQueryString();
    }
}
