<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Agunan;
use App\Models\Kantor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AgunanController extends Controller
{
    public function index()
    {
        $role = Auth::user()->role;
        $kantor = Kantor::find(auth()->user()->kantor_id);

        $data = Agunan::with('kredit');
        if ($role == 'Kepala Seksi Kredit') {
            $data->whereHas('kredit', function ($query) use ($kantor) {
                $query->where('wilayah', $kantor->nama)
                    ->whereNotIn('bidang', ['REMEDIAL']);
            });
        } elseif ($role == 'Kepala Seksi Remedial') {
            $data->whereHas('kredit', function ($query) use ($kantor) {
                $query->where('bidang', 'REMEDIAL');;
            });
        } elseif ($role == 'AO Kredit' || $role == 'Staff Remedial') {
            $data->whereHas('kredit', function ($query) {
                $query->where('kode_petugas', Auth::user()->kode);
            });
        }

        $keyword = request('search');
        if (!empty($keyword)) {
            $data->whereHas('kredit', function ($query) use ($keyword) {
                $query->where('nama_debitur', 'like', "%{$keyword}%")
                    ->orWhere('nokredit', 'like', "%{$keyword}%");
            });
        }

        $agunan = $data->paginate(10);

        foreach ($agunan as $item) {
            $item->shortAgunan = Str::limit($item->agunan, 60);
        }

        return view('master.agunan.index', [
            'agunan' => $agunan,
        ]);
    }
}
