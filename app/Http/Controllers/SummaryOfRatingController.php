<?php

namespace App\Http\Controllers;

use App\Models\Ipcr_Semestral;
use App\Models\Office;
use Illuminate\Http\Request;

class SummaryOfRatingController extends Controller
{
    protected $ipcr_sem;
    public function __construct(Ipcr_Semestral $ipcr_sem)
    {
        $this->ipcr_sem = $ipcr_sem;
    }
    public function getOffices(Request $request)
    {
        // dd('offices');
        $offices = Office::where(function ($query) {
            $query->where('office', 'LIKE', '%Office%')
                ->orWhere('office', 'LIKE', '%Hospital%');
        })
            ->where('office', '<>', 'NO OFFICE')
            ->orderBy('office', 'ASC')
            ->get();


        return inertia('Offices/Index', [
            "offices" => $offices
        ]);
    }
}
