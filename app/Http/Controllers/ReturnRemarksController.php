<?php

namespace App\Http\Controllers;

use App\Models\Ipcr_Semestral;
use App\Models\MonthlyAccomplishment;
use App\Models\ProbationaryTemporaryEmployees;
use App\Models\ReturnRemarks;
use Illuminate\Http\Request;

class ReturnRemarksController extends Controller
{
    protected $return_remarks, $prob_tempo, $ipcr_semestral, $monthly_accomplishments;
    public function __construct(
        ReturnRemarks $return_remarks,
        ProbationaryTemporaryEmployees $prob_tempo,
        Ipcr_Semestral $ipcr_semestral,
        MonthlyAccomplishment $monthly_accomplishments
    ) {
        $this->return_remarks = $return_remarks;
        $this->prob_tempo = $prob_tempo;
        $this->ipcr_semestral = $ipcr_semestral;
        $this->monthly_accomplishments = $monthly_accomplishments;
    }
    //
    public function returnRemarks(Request $request)
    {
        // dd('return monthly');
        $attributes = $request->validate([
            'type' => 'required',
            'remarks' => 'required',
            'ipcr_semestral_id' => 'required',
            'employee_code' => 'required',
        ]);
        $type = $request->type;
        $id = $request->ipcr_semestral_id;
        if ($type === 'probationary/temporary') {
            $data = $this->prob_tempo->findOrFail($id);
            $data->update([
                'status' => '-2'
            ]);
        } else {
            $data = $this->ipcr_semestral->findOrFail($id);
            $data->update([
                'status' => '-2'
            ]);
        }
        $this->return_remarks->create($attributes);
        return redirect('/review/approve')
            ->with('message', 'Return remarks');
    }
    public function returnRemarksAccomplishments(Request $request)
    {
        // dd('returnRemarksAccomplishments: ' . $request->ipcr_monthly_accomplishment_id);
        $attributes = $request->validate([
            'type' => 'required',
            'remarks' => 'required',
            'ipcr_semestral_id' => 'required',
            'employee_code' => 'required',
            'ipcr_monthly_accomplishment_id' => 'required',
        ]);
        // dd("after validate");
        $type = $request->type;
        $id = $request->ipcr_monthly_accomplishment_id;
        if ($type === 'probationary/temporary') {
            $data = $this->prob_tempo->findOrFail($id);
            $data->update([
                'status' => '-2'
            ]);
        } else {
            // dd('gfdgdfgdfgdfg');
            $data = $this->monthly_accomplishments->findOrFail($id);
            // dd($data);
            $data->update([
                'status' => '-2'
            ]);
        }
        $this->return_remarks->create($attributes);
        return redirect('/approve/accomplishments')
            ->with('update', 'Return remarks');
    }
}
