<?php

namespace App\Http\Controllers;

use App\Models\IndividualFinalOutput;
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
            ->leftjoin('division_outputs', 'division_outputs.id', 'individual_final_outputs.id_div_output')
            ->leftjoin('divisions', 'divisions.id', 'division_outputs.division_id')
            ->leftjoin('major_final_outputs', 'major_final_outputs.id', 'division_outputs.idmfo')
            ->leftjoin('sub_mfos', 'sub_mfos.id', 'individual_final_outputs.idsubmfo')
            ->orderBy('individual_final_outputs.ipcr_code')
            ->get()
            ->paginate(10)
            ->withQueryString;
        return inertia('IPCR/Semestral/Index', []);
    }
}
