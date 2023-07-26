<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashBoardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //$totalAll = $this->totalAll();



    public function index()
    {
        //dd('create: '.auth()->user()->can('create',User::class).'edit: '.auth()->user()->can('edit',User::class).'delete: '.auth()->user()->can('delete',User::class));

        return inertia('Home');
    }


}
