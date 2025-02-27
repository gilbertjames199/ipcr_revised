<?php

use App\Models\UserEmployees;

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
    $us = UserEmployees::with('DesignatedDivisionHead')->where('empl_id', $emp_code)->first();
    $is_div_head = 'emp';
    if ($us) {
        // dd("nakitan");
        // dd($us->userEmployee);
        $is_div_head = ($us->DesignatedDivisionHead !== null ||
            $us->salary_grade >= 22) ? 'div' : 'emp';
    }
    return $is_div_head;
}
