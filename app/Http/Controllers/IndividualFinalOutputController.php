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
        $dept_code = auth()->user()->department_code;
        $offices = Office::get();
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
            ->leftjoin('division_outputs', 'division_outputs.id', 'individual_final_outputs.id_div_output')
            ->leftjoin('divisions', 'divisions.id', 'division_outputs.division_id')
            ->leftjoin('major_final_outputs', 'major_final_outputs.id', 'division_outputs.idmfo')
            ->leftjoin('sub_mfos', 'sub_mfos.id', 'individual_final_outputs.idsubmfo')
            ->orderBy('individual_final_outputs.ipcr_code')
            ->paginate(10);
        // dd($data->pluck('performance_measure'));
        return inertia('IPCR/IndividualOutput/Index', [
            "data" => $data,
            "offices" => $offices
        ]);
    }
    public function create(Request $request)
    {
        $office = Office::get();
        $major_final_outputs = MajorFinalOutput::orderBy('FFUNCCOD', 'ASC')
            ->orderBy('mfo_desc', 'ASC')
            ->get();
        $submfo = SubMfo::get();
        $divoutput = DivisionOutput::get();
        // $indiv = IndividualFinalOutput::get();
        return inertia('IPCR/IndividualOutput/Create', [
            "offices" => $office,
            "major_final_outputs" => $major_final_outputs,
            "submfo" => $submfo,
            "divoutput" => $divoutput,
        ]);
    }
    public function store(Request $request)
    {
    }
    public function edit(Request $request)
    {
    }
    public function update(Request $request)
    {
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
        return DivisionOutput::where('id', $request->id_div_output)
            ->get();
    }
    public function get_time_range(Request $request)
    {
        return TimeRange::where('time_code', $request->time_code)
            ->orderBy('rating', 'DESC')
            ->get();
    }
}
