<?php

namespace App\Http\Controllers;

use App\Models\Ipcr_Semestral;
use App\Models\Office;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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

        // Separate the DDOPH entries
        $ddophOffices = $offices->filter(function ($office) {
            return strpos(
                $office->office,
                'DAVAO DE ORO PROVINCIAL HOSPITAL (DDOPH)'
            ) === 0;
        });

        // Filter out DDOPH entries from the main list
        $otherOffices = $offices->filter(function ($office) {
            return strpos(
                $office->office,
                'DAVAO DE ORO PROVINCIAL HOSPITAL (DDOPH)'
            ) !== 0;
        });

        // Insert DDOPH entries after "PROVINCIAL ECONOMIC ENTERPRISE & MGT OFFICE"
        $finalOffices = collect();
        foreach ($otherOffices as $office) {
            $finalOffices->push($office);
            // After "PROVINCIAL ECONOMIC ENTERPRISE & MGT OFFICE", append DDOPH entries
            if ($office->office === 'PROVINCIAL ECONOMIC ENTERPRISE & MGT OFFICE') {
                foreach ($ddophOffices as $ddoph) {
                    $finalOffices->push($ddoph);
                }
            }
        }
        // dd($finalOffices->pluck('office'));
        return inertia('Offices/Index', [
            "offices" => $finalOffices
        ]);
    }
}
