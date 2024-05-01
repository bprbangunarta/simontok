<?php

namespace App\Http\Controllers;

use App\Imports\AgunanImport;
use App\Imports\KreditImport;
use App\Imports\TunggakanImport;
use App\Imports\UsersImport;
use App\Imports\WriteoffImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function user(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        $file = $request->file('file');

        // membuat nama file unik
        $nama_file = $file->hashName();

        //temporary file
        $path = $file->storeAs('public/excel/', $nama_file);

        // import data
        $import = Excel::import(new UsersImport(), storage_path('app/public/excel/' . $nama_file));

        //remove from server
        Storage::delete($path);

        if ($import) {
            //redirect
            return redirect()->route('user.index')->with(['success' => 'User Berhasil Diimport!']);
        } else {
            //redirect
            return redirect()->route('user.index')->with(['error' => 'User Gagal Diimport!']);
        }
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

    // public function writeoff(Request $request)
    // {
    //     $request->validate([
    //         'file' => 'required|mimes:csv,xls,xlsx'
    //     ]);

    //     $file = $request->file('file');
    //     $fileName = now() . " " . 'WRITEOFF.' . $file->getClientOriginalExtension();
    //     $file->move('import/writeoff', $fileName);

    //     Excel::import(new WriteoffImport, public_path('/import/writeoff/' . $fileName));

    //     return redirect()->route('writeoff.index')->with('success', 'Writeoff berhasil diimport');
    // }

    public function writeoff(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        $file = $request->file('file');

        // membuat nama file unik
        $nama_file = $file->hashName();

        //temporary file
        $path = $file->storeAs('public/excel/', $nama_file);

        // import data
        $import = Excel::import(new WriteoffImport(), storage_path('app/public/excel/' . $nama_file));

        //remove from server
        Storage::delete($path);

        if ($import) {
            //redirect
            return redirect()->route('writeoff.index')->with(['success' => 'Writeoff Berhasil Diimport!']);
        } else {
            //redirect
            return redirect()->route('writeoff.index')->with(['error' => 'Writeoff Gagal Diimport!']);
        }
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
