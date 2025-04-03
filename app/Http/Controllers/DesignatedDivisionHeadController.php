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
        if (!in_array($emp_code, [2960, 2730, 8510, 8354])) {
            return redirect('/forbidden');
        }
        $data = $this->model->with(['userEmployee', 'Division', 'Division.Office', 'office'])
            ->simplePaginate(10)
            ->withQueryString();


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
            'position_long_title AS pos'
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
        if ($request->type) {
            if ($request->type == 'hpcr') {
                $attributes = $request->validate([
                    'empl_id' => 'required',
                    'division_code' => function ($attribute, $value, $fail) {
                        if (!is_null($value)) {
                            $fail('Division code must be null when type is HPCR.');
                        }
                    },
                    'department_code' => 'required',
                    'added_by' => 'required',
                    'type' => 'required'
                ]);
            } else {
                $attributes = $request->validate([
                    'empl_id' => 'required',
                    'division_code' => 'required',
                    'added_by' => 'required',
                    'type' => 'required'
                ]);
            }
        } else {
            $attributes = $request->validate([
                'empl_id' => 'required',
                'division_code' => 'required',
                'added_by' => 'required',
                'type' => 'required'
            ]);
        }
        // dd($request->division_code);

        $employee = UserEmployees::where('empl_id', $attributes['empl_id'])->first();
        $slug = $this->generateUniqueSlug($employee->employee_name);

        //For designated Division Head, check if designate exists for the selected division
        if ($request->type == 'dpcr') {
            $count_div = DesignatedDivisionHead::where('division_code', $attributes['division_code'])
                ->where('type', 'dpcr')->count();
            if ($count_div > 0) {
                return redirect()->back()->with('error', 'Division head designate already exists for selected division!');
            }
        }

        //For designated Hospital Head, check if designate exists for the selected hospital
        if ($request->type == 'hpcr') {
            $count_div = DesignatedDivisionHead::where('department_code', $attributes['department_code'])
                ->where('type', 'hpcr')->count();
            if ($count_div > 0) {
                return redirect()->back()->with('error', 'Hospital head designate already exists for selected hospital!');
            }
        }

        //For designated Hospital Division Head, check if designate exists for the selected hospital division
        if ($request->type == 'hdpcr') {
            $count_div = DesignatedDivisionHead::where('division_code', $attributes['division_code'])
                ->where('type', 'hdpcr')->count();
            if ($count_div > 0) {
                return redirect()->back()->with('error', 'Hospital division head designate already exists for selected hospital division!');
            }
        }
        $count_emp = DesignatedDivisionHead::where('empl_id', $attributes['empl_id'])->count();
        // dd($count_div);

        if ($count_emp > 0) {
            return redirect()->back()->with('error', 'Employee already has an existing designation!');
        }
        // $this->model->create($attributes);
        $desigdivheads = new DesignatedDivisionHead();
        $desigdivheads->empl_id = $attributes['empl_id'];
        $desigdivheads->department_code = $request->department_code;
        $desigdivheads->division_code = $request->division_code;
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
        } else if ($attributes['type'] == 'hspcr') {
            $type_add = "Hospital Section";
        } else if ($attributes['type'] == 'hdpcr') {
            $type_add = "Hospital Division";
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
            'position_long_title AS pos'
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
        if ($request->type) {
            if ($request->type == 'hpcr') {
                $attributes = $request->validate([
                    'empl_id' => 'required',
                    'division_code' => function ($attribute, $value, $fail) {
                        if (!is_null($value)) {
                            $fail('Division code must be null when type is HPCR.');
                        }
                    },
                    'department_code' => 'required',
                    'added_by' => 'required',
                    'type' => 'required'
                ]);
            } else {
                $attributes = $request->validate([
                    'empl_id' => 'required',
                    'division_code' => 'required',
                    'added_by' => 'required',
                    'type' => 'required'
                ]);
            }
        } else {
            $attributes = $request->validate([
                'empl_id' => 'required',
                'division_code' => 'required',
                'added_by' => 'required',
                'type' => 'required'
            ]);
        }
        $employee = UserEmployees::where('empl_id', $attributes['empl_id'])->first();
        // $slug = $this->generateUniqueSlug($employee->employee_name);

        //For designated Division Head, check if designate exists for the selected division
        if ($request->type == 'dpcr') {
            $count_div = DesignatedDivisionHead::where('division_code', $attributes['division_code'])
                ->where('empl_id', '<>', $attributes['empl_id'])
                ->where('type', 'dpcr')->count();
            if ($count_div > 0) {
                return redirect()->back()->with('error', 'Division head designate already exists for selected division!');
            }
        }

        //For designated Hospital Head, check if designate exists for the selected hospital
        if ($request->type == 'hpcr') {
            $count_div = DesignatedDivisionHead::where('department_code', $attributes['department_code'])
                ->where('empl_id', '<>', $attributes['empl_id'])
                ->where('type', 'hpcr')->count();
            if ($count_div > 0) {
                return redirect()->back()->with('error', 'Hospital head designate already exists for selected hospital!');
            }
        }

        //For designated Hospital Division Head, check if designate exists for the selected hospital division
        if ($request->type == 'hdpcr') {
            $count_div = DesignatedDivisionHead::where('division_code', $attributes['division_code'])
                ->where('empl_id', '<>', $attributes['empl_id'])
                ->where('type', 'hdpcr')->count();
            if ($count_div > 0) {
                return redirect()->back()->with('error', 'Hospital division head designate already exists for selected hospital division!');
            }
        }


        $employee = UserEmployees::where('empl_id', $attributes['empl_id'])->first();
        // $slug = $this->generateUniqueSlug($employee->employee_name);
        $desigdivheads = DesignatedDivisionHead::find($id);
        $desigdivheads->empl_id = $attributes['empl_id'];
        $desigdivheads->department_code = $request->department_code;
        $desigdivheads->division_code = $request->division_code;
        // $desigdivheads->division_code = $attributes['division_code'];
        $desigdivheads->added_by = $attributes['added_by'];
        $desigdivheads->type = $attributes['type'];
        // $desigdivheads->slug = $slug;
        $desigdivheads->save();
        $type_add = "";
        if ($attributes['type'] == 'dpcr') {
            $type_add = "Division";
        } else if ($attributes['type'] == 'hpcr') {
            $type_add = "Hospital";
        } else if ($attributes['type'] == 'spcr') {
            $type_add = "Section";
        } else if ($attributes['type'] == 'hspcr') {
            $type_add = "Hospital Section";
        } else if ($attributes['type'] == 'hdpcr') {
            $type_add = "Hospital Division";
        }
        return redirect('/designated-division-head')->with('message', $type_add . ' head designate successfully updated!');
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
