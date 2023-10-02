<?php

namespace App\Http\Controllers;

use App\Models\RemarksEfficiency;
use App\Models\RemarksQuality;
use App\Models\RemarksTimeliness;
use App\Models\StandardQuality;
use App\Models\StandardQuantity;
use App\Models\StandardTimeliness;
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PerformanceStandardController extends Controller
{
    protected $standard_quality, $standard_quantity, $standard_time;
    public function __construct(StandardQuality $standard_quality,
                                StandardQuantity $standard_quantity,
                                StandardTimeliness $standard_time
    ){
        $this->standard_quality =$standard_quality;
        $this->standard_quantity=$standard_quantity;
        $this->standard_time=$standard_time;
    }
    //
    public function import_performance_standard(Request $request){
        //dd("performance standard");
        return inertia('PerformanceStandard/Index');
    }
    public function upload_performance_standard(Request $request){
        $date = Carbon::now();
        $dateTime = $date->format('Y-m-d');
        $file = $request->myfile;
        $wng="";
        $msg="";
        $validate = $request->validate([
            'myfile' => 'required|mimes:xlsx,csv',
        ]);
        if($validate){
            $fileName = $file->getClientOriginalName();
            $file->move(storage_path('app/public'), "file.xlsx");
            $reader = ReaderEntityFactory::createReaderFromFile(storage_path('app/public') . "file.xlsx");
            $reader->open(public_path() . "/storage/file.xlsx");
            // $row_index_arr =[];
            $arr_standard_efficiency =[];
            $arr_standard_qual =[];
            $arr_standard_time =[];
            $arr_remarks_eff = [];
            $arr_remarks_qual = [];
            $arr_remarks_time = [];
            foreach ($reader->getSheetIterator() as $sheet) {
                if($sheet->getIndex()===0){
                    foreach($sheet->getRowIterator() as $rowIndex => $row){
                        $cells = $row->getCells();
                        $ipcr_code = $cells[0]->getValue();
                        //Efficiency
                        $eff_rating = $cells[1]->getValue();
                        $eff_adj_rating = $cells[2]->getValue();
                        $efficiency = $cells[3]->getValue();
                        $eff_remarks = $cells[4]->getValue();
                        //Quality
                        $qual_rating = $cells[1]->getValue();
                        $qual_adj_rating = $cells[2]->getValue();
                        $quality = $cells[5]->getValue();
                        $qual_remarks = $cells[6]->getValue();
                        //Timeliness
                        $time_rating = $cells[1]->getValue();
                        $time_adj_rating = $cells[2]->getValue();
                        $timeliness = $cells[7]->getValue();
                        $time_remarks = $cells[8]->getValue();
                        if($rowIndex>=7){
                            $standard_eff = [
                                                "IPCR_Code"=>$ipcr_code,
                                                "rating"=>$eff_rating,
                                                "adj_rating"=>$eff_adj_rating,
                                                "efficiency"=>$efficiency
                                            ];
                            $standard_qual = [
                                                "IPCR_Code"=>$ipcr_code,
                                                "rating"=>$qual_rating,
                                                "adj_rating"=>$qual_adj_rating,
                                                "effectiveness"=>$quality
                                            ];
                            $standard_time = [
                                                "IPCR_Code"=>$ipcr_code,
                                                "rating"=>$time_rating,
                                                "adj_rating"=>$time_adj_rating,
                                                "time"=>$timeliness
                                            ];
                            $rem_eff = [
                                            "ipcr_code"=>$ipcr_code,
                                            "remarks_efficiencies"=>$eff_remarks
                                        ];
                            $rem_qual = [
                                            "ipcr_code"=>$ipcr_code,
                                            "remarks_qualities"=>$qual_remarks
                                        ];
                            $rem_time = [
                                            "ipcr_code"=>$ipcr_code,
                                            "remarks_timeliness"=>$time_remarks
                                        ];
                            array_push($arr_standard_efficiency, $standard_eff);
                            array_push($arr_standard_qual, $standard_qual);
                            array_push($arr_standard_time, $standard_time);
                            if($eff_remarks){
                                array_push($arr_remarks_eff, $rem_eff);
                            }
                            if($qual_remarks){
                                array_push($arr_remarks_qual, $rem_qual);
                            }
                            if($time_remarks){
                                array_push($arr_remarks_time, $rem_time);
                            }
                        }
                    }
                }
            }

            //Standard Quantity
            $chunk_data = array_chunk($arr_standard_efficiency,1000);
            foreach($chunk_data as $key=>$value){
                foreach ($value as $data) {
                    StandardQuantity::create(
                        $data
                    );
                }
            }


            //Standard Quality
            $chunk_data = array_chunk($arr_standard_qual,1000);
            foreach($chunk_data as $key=>$value){
                foreach ($value as $data) {
                    StandardQuality::create(
                        $data
                    );
                }
            }

            //Standard Timeliness
            $chunk_data = array_chunk($arr_standard_time,1000);
            foreach($chunk_data as $key=>$value){
                foreach ($value as $data) {
                    StandardTimeliness::create(
                        $data
                    );
                }
            }

            //Remarks Quantity
            $chunk_data = array_chunk($arr_remarks_eff,1000);
            foreach($chunk_data as $key=>$value){
                foreach ($value as $data) {
                    RemarksEfficiency::create(
                        $data
                    );
                }
            }

            //Remarks Quality
            $chunk_data = array_chunk($arr_remarks_qual,1000);
            foreach($chunk_data as $key=>$value){
                foreach ($value as $data) {
                    RemarksQuality::create(
                        $data
                    );
                }
            }

            //Remarks Timeliness
            $chunk_data = array_chunk($arr_remarks_time,1000);
            foreach($chunk_data as $key=>$value){
                foreach ($value as $data) {
                    RemarksTimeliness::create(
                        $data
                    );
                }
            }

            $wng="message";
            $msg="Performance standards successfully imported!";

        }else{
            $wng="error";
            $msg = "Error importing";
            // dd("Not Validated");
        }
        ///imports/performance/standard
        return redirect('/imports/performance/standard')
                ->with($wng, $msg);
    }
}
