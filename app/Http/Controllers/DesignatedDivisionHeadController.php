<?php

namespace App\Http\Controllers;

use App\Models\DesignatedDivisionHead;
use App\Models\Division;
use App\Models\Office;
use App\Models\UserEmployees;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DesignatedDivisionHeadController extends Controller
{
    protected $model;
    public function __construct(DesignatedDivisionHead $model)
    {
        $this->model = $model;
    }
    public function index(Request $request)
    {
        $user = auth()->user()->userEmployee;
        $emp_code = $user->empl_id;
        // $auth_code = $user->empl_id;
        // if ($emp_code != '2960' || $emp_code != '2730') {
        //     // return redirect('/forbidden')->with('error', 'You are not allowed to access this page!');
        //     dd('You are not allowed to access this page!');
        // }
        if (!in_array($emp_code, [2960, 2730])) {
            return redirect('/forbidden');
        }
        $data = $this->model->with(['userEmployee', 'Division', 'Division.Office'])
            ->simplePaginate(10)
            ->withQueryString();
        // dd($data);

        return inertia('DesignatedDivisionHeads/Index', [
            "data" => $data,
            "filters" => $request->only(['search']),
        ]);
    }

    public function create(Request $request)
    {
        // dd("create create");
        $employees = UserEmployees::select(
            'empl_id',
            'employee_name',
            'salary_grade',
            'department_code',
            'designate_department_code',
            'active_status',
            // DB::raw('NULL as office')
        )
            ->with('Office')
            ->where('active_status', 'ACTIVE')
            ->orderBy('employee_name', 'ASC')->get();
        // dd($employees[0]);
        // foreach ($employees as $employee) {
        //     $dept = $employee->department_code;
        //     dd($dept);
        //     $office = Office::where()
        // }
        // dd(count($employees));
        // $offices = Office::where('office', 'LIKE', '%Office%')->where('office', '<>', 'NO OFFICE')->orderBy('office', 'ASC')->get();
        $offices = Office::where(function ($query) {
            $query->where('office', 'LIKE', '%Office%')
                ->orWhere('office', 'LIKE', '%Hospital%');
        })
            ->where('office', '<>', 'NO OFFICE')
            ->orderBy('office', 'ASC')->get();
        $divisions = Division::all();
        // dd($offices);
        $pgdhs = UserEmployees::where('is_pghead', '1')->get();
        // dd($pgdhs);
        return inertia('DesignatedDivisionHeads/Create', [
            "employees" => $employees,
            "offices" => $offices,
            "divisions" => $divisions,
            "pgdhs" => $pgdhs
        ]);
    }
    public function store(Request $request)
    {
        // dd("store");
        // dd($request);
        $attributes = $request->validate([
            'empl_id' => 'required',
            'division_code' => 'required',
            'added_by' => 'required',
            'type' => 'required'
        ]);
        $employee = UserEmployees::where('empl_id', $attributes['empl_id'])->first();
        $slug = $this->generateUniqueSlug($employee->employee_name);
        $count_div = DesignatedDivisionHead::where('division_code', $attributes['division_code'])->count();
        $count_emp = DesignatedDivisionHead::where('empl_id', $attributes['empl_id'])->count();
        // dd($count_div);
        if ($count_div > 0) {
            return redirect()->back()->with('error', 'Division head designate already exists for selected division!');
        }
        if ($count_emp > 0) {
            return redirect()->back()->with('error', 'Employee already designated as division head!');
        }
        // $this->model->create($attributes);
        $desigdivheads = new DesignatedDivisionHead();
        $desigdivheads->empl_id = $attributes['empl_id'];
        $desigdivheads->division_code = $attributes['division_code'];
        $desigdivheads->added_by = $attributes['added_by'];
        $desigdivheads->type = $attributes['type'];
        $desigdivheads->slug = $slug;
        $desigdivheads->save();
        if ($attributes['type'] == 'dpcr') {
            $type_add = "Division";
        } else if ($attributes['type'] == 'hpcr') {
            $type_add = "Hospital";
        } else if ($attributes['type'] == 'spcr') {
            $type_add = "Section";
        }
        return redirect('/designated-division-head')->with('message', $type_add . ' head designate successfully added!');
    }
    public function edit(Request $request, $slug)
    {
        // dd("create create");
        $data = DesignatedDivisionHead::with(['userEmployee', 'Division', 'Division.Office'])
            ->where('slug', $slug)
            ->first();
        $employees = UserEmployees::select(
            'empl_id',
            'employee_name',
            'salary_grade',
            'department_code',
            'designate_department_code',
            'active_status',
            // DB::raw('NULL as office')
        )
            ->with('Office')
            ->where('active_status', 'ACTIVE')
            ->orderBy('employee_name', 'ASC')->get();

        $offices = Office::where(function ($query) {
            $query->where('office', 'LIKE', '%Office%')
                ->orWhere('office', 'LIKE', '%Hospital%');
        })
            ->where('office', '<>', 'NO OFFICE')
            ->orderBy('office', 'ASC')->get();
        $divisions = Division::all();
        // dd($offices);
        $pgdhs = UserEmployees::where('is_pghead', '1')->get();
        // dd($pgdhs);
        return inertia('DesignatedDivisionHeads/Create', [
            "employees" => $employees,
            "offices" => $offices,
            "divisions" => $divisions,
            "editData" => $data
        ]);
    }
    public function update(Request $request, $id)
    {
        // dd($request);
        $attributes = $request->validate([
            'empl_id' => 'required',
            'division_code' => 'required',
            'added_by' => 'required'
        ]);
        $employee = UserEmployees::where('empl_id', $attributes['empl_id'])->first();
        $slug = $this->generateUniqueSlug($employee->employee_name);
        $desigdivheads = DesignatedDivisionHead::find($id);
        $desigdivheads->empl_id = $attributes['empl_id'];
        $desigdivheads->division_code = $attributes['division_code'];
        $desigdivheads->added_by = $attributes['added_by'];
        $desigdivheads->type = $attributes['type'];
        $desigdivheads->slug = $slug;
        $desigdivheads->save();
        return redirect('/designated-division-head')->with('message', 'Division head designate successfully updated!');
    }
    function generateUniqueSlug($employeeName)
    {


        // Generate a random 5-letter word
        function randomWord()
        {
            return Str::random(5);
        }
        // Convert the name to a slug
        $slug = Str::slug($employeeName) . '-' . randomWord();
        // Check for uniqueness and append a random word if necessary
        $originalSlug = $slug;
        while (DesignatedDivisionHead::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . randomWord();
        }

        return $slug;
    }
    public function destroy(Request $request, $id)
    {
        // dd("delete: " . $id);
        $data = $this->model->findOrFail($id);
        $data->delete();

        return redirect('/designated-division-head')->with('deleted', 'Division head designate sauccessfully deleted!');
    }
}
