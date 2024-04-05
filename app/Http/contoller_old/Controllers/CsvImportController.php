<?php

namespace App\Http\Controllers;

use App\Imports\ProgramImport;
use Illuminate\Http\Request;
use App\Model\Program;
use App\Models\Akun;
use App\Models\Item_pagu;
use App\Models\Uraian_subkomponen;
use Maatwebsite\Excel\Facades\Excel;

class CsvImportController extends Controller
{
    function index()
    {
        //$data = Uraian_subkomponen::with(['akuns'])->get();
        //'data' => $data, 
        $item_pagu = Item_pagu::with([
            'akuns', 
            'uraian_subkomponens', 
            'sub_komponens', 
            'komponens', 
            'sub_outputs', 
            'outputs', 
            'kegiatans', 
            'programs'
        ])->get();
        
        return view('layouts/import', ['item_pagu' => $item_pagu]);
    }

    function import(Request $request)
    {
        Excel::import(new ProgramImport, $request->file('csv_file'));
    }
}
 