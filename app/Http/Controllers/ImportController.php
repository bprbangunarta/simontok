<?php

namespace App\Http\Controllers;

use App\Imports\AgunanImport;
use App\Imports\KreditImport;
use App\Imports\TunggakanImport;
use App\Imports\UsersImport;
use App\Imports\WriteoffImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function user(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        $file = $request->file('file');

        $fileName = date('Y_m_d') . " " . 'USER.' . $file->getClientOriginalExtension();
        $file->move('import/users', $fileName);

        Excel::import(new UsersImport, public_path('import/users/' . $fileName));

        return redirect()->back()->with('success', 'User berhasil diimport');
    }


    public function kredit(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        $file = $request->file('file');
        $fileName = date('Y_m_d') . " " . 'KREDIT.' . $file->getClientOriginalExtension();
        $file->move('import/kredit', $fileName);

        Excel::import(new KreditImport, public_path('/import/kredit/' . $fileName));

        return redirect()->route('kredit.index')->with('success', 'Kredit berhasil diimport');
    }

    public function tunggakan(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        $file = $request->file('file');
        $fileName = date('Y_m_d') . " " . 'TUNGGAKAN.' . $file->getClientOriginalExtension();
        $file->move('import/tunggakan', $fileName);

        Excel::import(new TunggakanImport, public_path('/import/tunggakan/' . $fileName));

        return redirect()->route('kredit.index')->with('success', 'Tunggakan berhasil diimport');
    }

    public function writeoff(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        $file = $request->file('file');

        $fileName = date('Y_m_d') . " " . 'WRITEOFF.' . $file->getClientOriginalExtension();
        $file->move('import/writeoff', $fileName);

        Excel::import(new WriteoffImport, public_path('import/writeoff/' . $fileName));

        return redirect()->back()->with('success', 'User Writeoff diimport');
    }

    public function agunan(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        $file = $request->file('file');
        $fileName = date('Y_m_d') . " " . 'AGUNAN.' . $file->getClientOriginalExtension();
        $file->move('import/agunan', $fileName);

        Excel::import(new AgunanImport, public_path('/import/agunan/' . $fileName));

        return redirect()->route('agunan.index')->with('success', 'Agunan berhasil diimport');
    }
}
