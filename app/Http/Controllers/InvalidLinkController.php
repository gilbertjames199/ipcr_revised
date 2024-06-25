<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InvalidLinkController extends Controller
{
    public function index()
    {
        return view('auth.invalid-link');
    }
}
