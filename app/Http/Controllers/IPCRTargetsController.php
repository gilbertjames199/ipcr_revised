<?php

namespace App\Http\Controllers;

use App\Models\IPCRTargets;
use App\Models\UserEmployeeCredential;
use App\Models\UserEmployees;
use Illuminate\Http\Request;

class IPCRTargetsController extends Controller
{
    protected $ipcr_target;
    public function __construct(IPCRTargets $ipcr_target)
    {
        $this->ipcr_target = $ipcr_target;
    }
    public function index(Request $request, $id){
        return inertia('IPCR/Targets/Index',[
            "id"=>$id
        ]);
    }
    public function create(Request $request, $id){
        $emp = UserEmployees::where('id',$id)
                ->first();

        return inertia('IPCR/Targets/Create',[
            "id"=>$id,
            "emp"=>$emp
        ]);
    }
}
