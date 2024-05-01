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

        // membuat nama file unik
        $nama_file = $file->hashName();

        //temporary file
        $path = $file->storeAs('public/excel/', $nama_file);

        // import data
        $import = Excel::import(new KreditImport(), storage_path('app/public/excel/' . $nama_file));

        //remove from server
        Storage::delete($path);

        if ($import) {
            //redirect
            return redirect()->route('kredit.index')->with(['success' => 'Kredit Berhasil Diimport!']);
        } else {
            //redirect
            return redirect()->route('kredit.index')->with(['error' => 'Kredit Gagal Diimport!']);
        }
    }

    public function tunggakan(Request $request)
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
        $import = Excel::import(new TunggakanImport(), storage_path('app/public/excel/' . $nama_file));

        //remove from server
        Storage::delete($path);

        if ($import) {
            //redirect
            return redirect()->route('kredit.index')->with(['success' => 'Tunggakan Berhasil Diimport!']);
        } else {
            //redirect
            return redirect()->route('kredit.index')->with(['error' => 'Tunggakan Gagal Diimport!']);
        }
    }

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

        // membuat nama file unik
        $nama_file = $file->hashName();

        //temporary file
        $path = $file->storeAs('public/excel/', $nama_file);

        // import data
        $import = Excel::import(new AgunanImport(), storage_path('app/public/excel/' . $nama_file));

        //remove from server
        Storage::delete($path);

        if ($import) {
            //redirect
            return redirect()->route('agunan.index')->with(['success' => 'Agunan Berhasil Diimport!']);
        } else {
            //redirect
            return redirect()->route('agunan.index')->with(['error' => 'Agunan Gagal Diimport!']);
        }
    }
}
