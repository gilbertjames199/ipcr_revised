<?php

namespace App\Http\Controllers;

use App\Models\IpcrScore;
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use Carbon\Carbon;
use Illuminate\Http\Request;

class IpcrScoreController extends Controller
{
    protected $model;
    public function __construct(IpcrScore $model)
    {
        $this->model = $model;
    }
    public function index(Request $request)
    {
        $dept_code = auth()->user()->department_code;
        $empl_id = auth()->user()->username;
        if ($empl_id == '2960' || $empl_id == '2730' || $empl_id == '8510' || $empl_id == '8354') {
            return inertia('IPCR/Score/Index', []);
        } else {
            return redirect('/forbidden')
                ->with('error', 'Access forbidden!');
        }
    }
    public function import(Request $request)
    {
        // dd("import");
        $date = Carbon::now();
        $dateTime = $date->format('Y-m-d');
        $file = $request->myfile;
        $wng = "";
        $msg = "";
        $validate = $request->validate([
            'myfile' => 'required|mimes:xlsx,csv',
        ]);
        if ($validate) {
            $fileName = $file->getClientOriginalName();
            $file->move(storage_path('app/public'), "file.xlsx");
            $reader = ReaderEntityFactory::createReaderFromFile(storage_path('app/public') . "file.xlsx");
            $reader->open(public_path() . "/storage/file.xlsx");
            // $row_index_arr =[];
            $arr_ipcr_score = [];

            foreach ($reader->getSheetIterator() as $sheet) {
                if ($sheet->getIndex() === 0) {
                    foreach ($sheet->getRowIterator() as $rowIndex => $row) {
                        $cells = $row->getCells();
                        $IPCR_code = $cells[0]->getValue();
                        $rating = $cells[1]->getValue();
                        $adj_rating = $cells[2]->getValue();
                        if ($rating == "5") {
                            $efficiency_max = "1000";
                            $efficiency_min = "130";
                        } else if ($rating == "4") {
                            $efficiency_max = "129";
                            $efficiency_min = "115";
                        } else if ($rating == "3") {
                            $efficiency_max = "114";
                            $efficiency_min = "90";
                        } else if ($rating == "2") {
                            $efficiency_max = "89";
                            $efficiency_min = "51";
                        } else if ($rating == "1") {
                            $efficiency_max = "50";
                            $efficiency_min = "0";
                        }
                        $efficiency = $cells[3]->getValue();
                        $remarks_efficiency = $cells[4]->getValue();
                        $effectiveness = $cells[5]->getValue();
                        $remarks_effectiveness = $cells[6]->getValue();
                        $timeliness = $cells[7]->getValue();
                        $remarks_timeliness = $cells[8]->getValue();
                        if ($rowIndex > 7) {
                            $ipcr_score = [
                                "IPCR_code" => $IPCR_code,
                                "rating" => $rating,
                                "adj_rating" => $adj_rating,
                                "efficiency" => $efficiency,
                                "efficiency_max" => $efficiency_max,
                                "efficiency_min" => $efficiency_min,
                                "remarks_efficiency" => $remarks_efficiency,
                                "effectiveness" => $effectiveness,
                                "remarks_effectiveness" => $remarks_effectiveness,
                                "timeliness" => $timeliness,
                                "remarks_timeliness" => $remarks_timeliness,
                            ];
                            array_push($arr_ipcr_score, $ipcr_score);
                        }
                    }
                }
            }

            //Standard Quantity
            $chunk_data = array_chunk($arr_ipcr_score, 1000);
            foreach ($chunk_data as $key => $value) {
                foreach ($value as $data) {
                    // dd($data);
                    IpcrScore::create(
                        $data
                    );
                }
            }
        }
    }
}
