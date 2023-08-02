<?php

namespace App\Http\Controllers;

use App\Models\Ipcr_Semestral;
use Illuminate\Http\Request;

class ReviewApproveController extends Controller
{
    protected $ipcr_sem;
    public function __construct(Ipcr_Semestral $ipcr_sem)
    {
        $this->ipcr_sem=$ipcr_sem;
    }
    public function index(Request $request){
        // dd(auth()->user());
        $empl_code = auth()->user()->username;
        // dd($empl_code);
        $targets = $this->ipcr_sem->where('status','<','2')
                            ->where(function($query)use($empl_code){
                                $query->where('immediate_id', $empl_code)
                                        ->orWhere('column2', 'orange');
                            })
                            ->join('user_employees','user_employees.empl_id','ipcr__semestrals.empl_code')
                            ->paginate(10);
        return inertia('IPCR/Review/Index',
            ['targets'=>$targets]
        );
    }

}
