<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\StoreAudit;
use App\StoreAuditDetail;

class AuditReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $audits = StoreAudit::orderBy('updated_at', 'desc')->get();
        return view('auditreport.index',compact('audits'));
    }

    public function details($id){
        $store_audit = StoreAudit::findOrFail($id);
        $details = StoreAuditDetail::getDetails($store_audit->id);
        \Excel::create("sample", function($excel) use ($details) {
            $excel->sheet('Sheet1', function($sheet) use ($details) {
                $sheet->fromModel($details,null, 'A1', true);
            })->download('xls');

        });
    }
}
