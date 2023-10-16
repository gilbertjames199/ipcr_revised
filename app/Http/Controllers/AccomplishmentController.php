<?php

namespace App\Http\Controllers;

use App\Models\Daily_Accomplishment;
use Illuminate\Http\Request;

class AccomplishmentController extends Controller
{
    private $model;
    public function __construct(Daily_Accomplishment $model)
    {
        $this->model = $model;
    }

    public function index(Request $request)
    {
        $emp_code = Auth()->user()->username;

        return inertia('Monthly_Accomplishment/Index', [
            // "data" => $data,
            "emp_code" => $emp_code
        ]);
    }
}
