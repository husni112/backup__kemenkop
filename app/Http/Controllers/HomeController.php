<?php

namespace App\Http\Controllers;
use App\Models\Item_pagu;
use App\Imports\ProgramImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function home(Request $request)
    {
        $perPage = 14;
        $totalData = Item_pagu::count();
        // Initialize the query builder with eager loading
        $query = Item_pagu::with([
            'akuns', 
            'uraian_subkomponens', 
            'sub_komponens', 
            'komponens', 
            'sub_outputs', 
            'outputs', 
            'kegiatans', 
            'programs'
        ]);

        // Conditionally apply search term conditions to the query
        if ($request->has('search_term')) {
            $searchTerm = $request->search_term;

        // Create a new query instance for search conditions
            $query->where(function ($q) use ($searchTerm) {
            $q->where('cons_item', 'like', '%' . $searchTerm . '%')
                ->orWhere('uraian_item', 'like', '%' . $searchTerm . '%')
                ->orWhere('kode_mak', 'like', '%' . $searchTerm . '%')
                ->orWhereHas('akuns', function ($subquery) use ($searchTerm){
                    $subquery->where('kode_akun', 'like', '%' . $searchTerm . '%');
                })
                ->orWhereHas('uraian_subkomponens', function ($subquery) use ($searchTerm){
                    $subquery->where('uraian_subkomponen', 'like', '%' . $searchTerm . '%');
                })
                ->orWhereHas('sub_komponens', function ($subquery) use ($searchTerm){
                    $subquery->where('kode_subkomponen', 'like', '%' . $searchTerm . '%');
                });
            });
        }
        
        // Paginate the results after applying conditions
        $item_pagu = $query->paginate($perPage);

        if ($request->ajax()) {
            return view('data', compact('totalData', 'item_pagu', 'perPage'));
        }

        return view('dashboard', compact('totalData', 'item_pagu', 'perPage'));

    }

}
