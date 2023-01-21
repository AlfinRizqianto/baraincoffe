<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use App\Exports\EmployeeExport;
use App\Imports\EmployeeImport;
use Maatwebsite\Excel\Facades\Excel;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('search')) {
            $employees = Employee::where('nama', 'LIKE', '%' . $request->search . '%')->paginate(5);
        } else {
            $employees = Employee::paginate(5);
        }


        return view('pegawai.datapegawai', compact('employees'));
    }

    public function create()
    {
        return view('pegawai.tambah');
    }

    public function store(Request $request)
    {
        $employees = Employee::create($request->all());
        if ($request->hasFile('foto')) {
            $request->file('foto')->move('fotopegawai', $request->file('foto')->getClientOriginalName());
            $employees->foto = $request->file('foto')->getClientOriginalName();
            $employees->save();
        }
        return redirect()->route('pegawai')->with('success', 'Data Berhasil Ditambahkan');
    }

    public function edit($id)
    {
        $employees = Employee::find($id);
        // dd($employess); 

        return view('pegawai.edit', compact('employees'));
    }

    public function update(Request $request, $id)
    {
        $employees = Employee::find($id);
        $employees->update($request->all());

        return redirect()->route('pegawai')->with('success', 'Data Berhasil Diedit');
    }

    public function destroy($id)
    {
        $employees = Employee::find($id);
        $employees->delete();

        return redirect()->route('pegawai')->with('success', 'Data Berhasil dihapus');
    }

    public function exportPDF()
    {
        $employees = Employee::all();

        view()->share('employees', $employees);
        $pdf = PDF::loadview('pegawai.datapegawai-pdf');
        return $pdf->download('datapegawai.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new EmployeeExport, 'datapegawai.xlsx');
    }

    public function importExcel(Request $request)
    {
        $employees = $request->file('file');

        $namafile = $employees->getClientOriginalName();
        $employees->move('EmployeeData', $namafile);

        Excel::import(new EmployeeImport, \public_path('/EmployeeData/' . $namafile));
        return redirect()->back();
    }
}
