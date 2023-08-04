<?php

namespace App\Http\Controllers;

use App\Models\Ipcr_Semestral;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

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
        $targets_review = $this->ipcr_sem
                            ->select('ipcr__semestrals.id','ipcr__semestrals.status',
                                'ipcr__semestrals.year','ipcr__semestrals.sem',
                                'user_employees.employee_name','user_employees.empl_id'
                            )
                            ->where('status','0')
                            ->where('ipcr__semestrals.immediate_id', $empl_code)
                            ->join('user_employees','user_employees.empl_id','ipcr__semestrals.employee_code')
                            ->distinct('ipcr_semestrals.id')
                            ->get();
        $targets_approve =$this->ipcr_sem
                        ->select('ipcr__semestrals.id','ipcr__semestrals.status',
                            'ipcr__semestrals.year','ipcr__semestrals.sem',
                            'user_employees.employee_name','user_employees.empl_id'
                        )
                        ->where('status','1')
                        ->where('ipcr__semestrals.next_higher', $empl_code)
                        ->join('user_employees','user_employees.empl_id','ipcr__semestrals.employee_code')
                        ->distinct('ipcr_semestrals.id')
                        ->get();
        // dd($targets_review);
        $targeted = $targets_review->concat($targets_approve);
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


        return inertia('IPCR/Review/Index',
            ['targets'=>$targets]
        );
    }
    public function updateStatus(Request $request, $status, $sem_id){
        //dd('status: '.$status.' sem_id:'.$sem_id);
        $data = $this->ipcr_sem::findOrFail($sem_id);
        $data->update([
            'status'=>$request->status,
        ]);
        return redirect('/review/approve')
                ->with('message','Review/Approve');
    }


}
