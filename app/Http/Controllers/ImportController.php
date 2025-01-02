<?php

namespace App\Http\Controllers;

use App\Imports\AgunanImport;
use App\Imports\KlasifikasiImport;
use App\Imports\KreditImport;
use App\Imports\NominatifImport;
use App\Imports\TunggakanImport;
use App\Imports\UsersImport;
use App\Imports\WriteoffImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

        // temporary file
        $path = $file->storeAs('public/excel/', $nama_file);

        // import data
        $import = Excel::import(new UsersImport(), storage_path('app/public/excel/' . $nama_file));

        // remove from server
        Storage::delete($path);

        if ($import) {
            // redirect
            return redirect()->route('user.index')->with(['success' => 'User Berhasil Diimport!']);
        } else {
            // redirect
            return redirect()->route('user.index')->with(['error' => 'User Gagal Diimport!']);
        }
    }

    public function kredit(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        $filePath = $request->file('file')->store('temp');
        $import = new KreditImport();

        DB::table('data_kredit')->truncate();
        DB::table('data_tunggakan')->truncate();

        Excel::queueImport($import, $filePath);

        if ($import) {
            return redirect()->back()->with(['success' => 'Import kredit sedang diproses!']);
        } else {
            return redirect()->back()->with(['error' => 'Import kredit gagal diproses!']);
        }
    }

    public function tunggakan(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        $filePath = $request->file('file')->store('temp');
        $import = new TunggakanImport();

        Excel::queueImport($import, $filePath);

        if ($import) {
            return redirect()->back()->with(['success' => 'Import tunggakan sedang diproses!']);
        } else {
            return redirect()->back()->with(['error' => 'Import tunggakan gagal diproses!']);
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

        // temporary file
        $path = $file->storeAs('public/excel/', $nama_file);

        // truncate table
        DB::table('data_writeoff')->truncate();

        // import data
        $import = Excel::import(new WriteoffImport(), storage_path('app/public/excel/' . $nama_file));

        // remove from server
        Storage::delete($path);

        if ($import) {
            // redirect
            return redirect()->route('writeoff.index')->with(['success' => 'Writeoff Berhasil Diimport!']);
        } else {
            // redirect
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

        // temporary file
        $path = $file->storeAs('public/excel/', $nama_file);

        // truncate table
        DB::table('data_agunan')->truncate();

        // import data
        $import = Excel::import(new AgunanImport(), storage_path('app/public/excel/' . $nama_file));

        // remove from server
        Storage::delete($path);

        if ($import) {
            // redirect
            return redirect()->route('agunan.index')->with(['success' => 'Agunan Berhasil Diimport!']);
        } else {
            // redirect
            return redirect()->route('agunan.index')->with(['error' => 'Agunan Gagal Diimport!']);
        }
    }

    public function klasifikasi(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        $file      = $request->file('file');
        $nama_file = $file->hashName();
        $path      = $file->storeAs('public/excel/', $nama_file);

        $import = Excel::import(new KlasifikasiImport(), storage_path('app/public/excel/' . $nama_file));
        Storage::delete($path);

        if ($import) {
            return redirect()->back()->with(['success' => 'Klasifikasi Berhasil Diimport!']);
        } else {
            return redirect()->back()->with(['error' => 'Klasifikasi Gagal Diimport!']);
        }
    }
}
