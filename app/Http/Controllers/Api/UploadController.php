<?php

namespace App\Http\Controllers\Api;

use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;
use Box\Spout\Writer\WriterFactory;
use Box\Spout\Writer\Style\StyleBuilder;
use Box\Spout\Writer\Style\Color;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;

use App\StoreAudit;
use App\StoreAuditDetail;

class UploadController extends Controller
{
	public function storeaudit(Request $request)
	{
		// dd($request->all());
		$destinationPath = storage_path().'/uploads/audit/';
		$fileName = $request->file('data')->getClientOriginalName();
		$request->file('data')->move($destinationPath, $fileName);

		$filePath = storage_path().'/uploads/audit/' . $fileName;

		$filename_data = explode("_", $fileName);
		$user_id = $filename_data[0];
		$store_code = $filename_data[1];
	   

		DB::beginTransaction();
		try {
			
		    $reader = ReaderFactory::create(Type::CSV); // for XLSX files
		    $reader->setFieldDelimiter('|');
		    $reader->open($filePath);

		    $first_row = true;
		    $audit_id = 0;
		    foreach ($reader->getSheetIterator() as $sheet) {
		        foreach ($sheet->getRowIterator() as $row) {
		            if($first_row){
		            	$start_date = date_format(date_create($row[11]),"Y-m-d");
		            	$end_date = date_format(date_create($row[12]),"Y-m-d");

		            	$audit = StoreAudit::where('user_id',$row[0])
		            		->where('store_code', $row[9])
		            		->where('start_date', $start_date)
		            		->where('end_date', $end_date)
		            		->first();
		            	if(!empty($audit)){
		            		$audit->user_id = $row[0];
		                $audit->user_name = $row[1];

		                $audit->account = $row[2];
		                $audit->customer_code = $row[3];
		                $audit->customer = $row[4];
		                $audit->region_code = $row[5];
		                $audit->region = $row[6];
		                $audit->distributor_code = $row[7];
		                $audit->distributor = $row[8];

		                $audit->store_code = $row[9];
		                $audit->store_name = $row[10];
		                $audit->start_date = $start_date;
		                $audit->end_date = $end_date;
		                $audit->template_code = $row[13];
		                $audit->template_name = $row[14];
		                $audit->passed = $row[15];

		                $audit->update();
		                $audit_id = $audit->id;

		                StoreAuditDetail::where('store_audit_id',  $audit_id)->delete();
		            	}else{
		            		$audit = new StoreAudit;
		               
		               	$audit->user_id = $row[0];
		                $audit->user_name = $row[1];

		                $audit->account = $row[2];
		                $audit->customer_code = $row[3];
		                $audit->customer = $row[4];
		                $audit->region_code = $row[5];
		                $audit->region = $row[6];
		                $audit->distributor_code = $row[7];
		                $audit->distributor = $row[8];

		                $audit->store_code = $row[9];
		                $audit->store_name = $row[10];
		                $audit->start_date = $start_date;
		                $audit->end_date = $end_date;
		                $audit->template_code = $row[13];
		                $audit->template_name = $row[14];
		                $audit->passed = $row[15];

		                $audit->save();
		                $audit_id = $audit->id;
		            	}
		            	$first_row = false;
		            }else{
		            	// dd($row);
		            	StoreAuditDetail::insert([
                    'store_audit_id' => $audit_id,
                    'category' => $row[0],
                    'group' => $row[1],
                    'prompt' => $row[2],
                    'type' => $row[3],
                    'answer' => $row[4]]);
		            }
		        }
		    }
		   
		    $reader->close();

			
		    DB::commit();
		   
		    return response()->json(array('msg' => 'file uploaded', 'status' => 0));
			
		} catch (Exception $e) {
		    DB::rollback();
		    return response()->json(array('msg' => 'file uploaded error', 'status' => 1));
		}
		
	}
}
