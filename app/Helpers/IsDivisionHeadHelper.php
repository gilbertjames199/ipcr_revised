<?php

use App\Models\EmployeeSpecialDepartment;
use App\Models\UserEmployees;

\Illuminate\Database\Eloquent\Model::preventLazyLoading(false);

function is_division_head($emp_code)
{
    $us = auth()->user()->load('userEmployee', 'userEmployee.DesignatedDivisionHead');
    $is_div_head = 'emp';
    if ($us || $us->userEmployee) {
        // dd("nakitan");
        // dd($us->userEmployee);
        $is_div_head = ($us->userEmployee->DesignatedDivisionHead !== null ||
            $us->userEmployee->salary_grade >= 22) ? 'div' : 'emp';
    }
    return $is_div_head;
}

function employee_division_head($emp_code)
{
    $us = UserEmployees::with(['DesignatedDivisionHead', 'employeeSpecialDepartment'])->where('empl_id', $emp_code)->first();
    // dd($us);
    $emp_type = 'emp';
    if ($us) {

        $dept_code = $us->department_code;
        // dd($dept_code);
        if (floatval($dept_code > 24 || floatval($dept_code) < 21)) {
            if ($us->salary_grade >= 22) {
                $emp_type = 'div';
            }
            if ($us->DesignatedDivisionHead) {
                if ($us->DesignatedDivisionHead->type == 'dpcr') {
                    $emp_type = 'div';
                } else if ($us->DesignatedDivisionHead->type == 'ipcr') {
                    $emp_type = 'emp';
                }
            }
        } else {
            $emp_type = 'hemp';
            // dd($us->DesignatedDivisionHead);
            if ($us->DesignatedDivisionHead) {
                // dd($us->DesignatedDivisionHead->type);
                if ($us->DesignatedDivisionHead->type == 'hdpcr') {
                    $emp_type = 'hdiv';
                }
                if ($us->DesignatedDivisionHead->type == 'hpcr') {
                    $emp_type = 'hos';
                }
                if ($us->DesignatedDivisionHead->type == 'hspcr') {
                    $emp_type = 'hsec';
                }
            } else {
                $emp_special = EmployeeSpecialDepartment::where('employee_code', $emp_code)->first();
                if ($emp_special) {

                    $spd = $emp_special->department_code;
                    if (floatval($spd > 24 || floatval($spd) < 21)) {
                        $emp_type = 'emp';
                    }
                }
            }
            // dd($emp_type);
        }
        // dd($us);
        if($us->position_long_title=='Watchman II' || $us->position_long_title=='Watchman II-B' ){

        }else{
            if($us->employeeSpecialDepartment) {
                $spd = $us->employeeSpecialDepartment->department_code;
                // dd($us->employeeSpecialDepartment);
                if (floatval($spd > 24 || floatval($spd) < 21)) {
                    $emp_type = 'emp';
                }else{
                    $emp_type = 'hemp';
                }
            }
        }


    }
    // dd($emp_type);
    return $emp_type;
}

// function employee_type($emp_code, $dept, $sg)
// function employee_division_head($emp_code)
// {
//     $us = UserEmployees::with('DesignatedDivisionHead')->where('empl_id', $emp_code)->first();
//     $is_div_head = 'emp';
//     if ($us) {
//         // dd("nakitan");
//         // dd($us->userEmployee);
//         // dd($us->DesignatedDivisionHead);
//         // $is_div_head = ($us->DesignatedDivisionHead !== null ||
//         //     $us->salary_grade >= 22) ? $us->DesignatedDivisionHead->type : 'emp';
//         // dd($us);
//         $dept_code = $us->department_code;
//         // dd($dept_code);
//         if (floatval($dept_code > 24 || floatval($dept_code) < 21)) {
//             if ($us->salary_grade >= 22) {
//                 $is_div_head = 'div';
//             }
//             if ($us->DesignatedDivisionHead) {
//                 // dd($us->DesignatedDivisionHead->type);
//                 if ($us->DesignatedDivisionHead->type == 'dpcr') {
//                     $is_div_head = 'div';
//                 }
//             }
//         } else {
//             $is_div_head = 'hemp';
//             if ($us->DesignatedDivisionHead) {
//                 // dd($us->DesignatedDivisionHead->type);
//                 if ($us->DesignatedDivisionHead->type == 'dpcr') {
//                     $is_div_head = 'div';
//                 }
//                 if ($us->DesignatedDivisionHead->type == 'hpcr') {
//                     $is_div_head = 'hos';
//                 }
//                 if ($us->DesignatedDivisionHead->type == 'spcr') {
//                     $is_div_head = 'sec';
//                 }
//             }
//         }
//         dd($is_div_head);
//     }

//     return $is_div_head;
// }
