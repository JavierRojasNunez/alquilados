<?php

namespace App\Http\Controllers;


use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsersExport;
use App\Imports\ProductsImport;
use Maatwebsite\Excel\Concerns\FromCollection;
use App\Invoice;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class ExcelController extends Controller
{
    /**
     * Muestra la lista de usuarios registrados.
     *
     * @return Response
     */
    public function UserExport()
    {       
    
        $fileyear = Carbon::now()->year;
        $fileMonth = Carbon::now()->month;
        $fileName = $fileMonth . '-' . $fileyear;
        Excel::store(new UsersExport('User'), 'exports/users/'. $fileName .'/users.xlsx', 'public');
        return Excel::download(new UsersExport('User'), 'users.xlsx');

    
    }

    public function productImport() 
    {
        $ok = Excel::import(new ProductsImport, 'ventas2.csv');

        if ($ok)
        {
            return redirect()->route('home')->with(['statuss_' => 'productos subidos a la bbdd con exito']);
        }
        

    }

}
