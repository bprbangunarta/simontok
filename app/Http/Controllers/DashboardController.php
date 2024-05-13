<?php

namespace App\Http\Controllers;

use App\Models\Janji;
use App\Models\Kantor;
use App\Models\Kredit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $kode = Auth::user()->kode;
        $role = Auth::user()->role;
        $kantor = Kantor::find(Auth::user()->kantor_id);

        $kredit = $this->getKredit($role, $kantor, $kode);
        $janji = $this->getJanji($role, $kantor, $kode);

        return view('dashboard', [
            'kredit' => $kredit,
            'janji' => $janji,

        ]);
    }

    private function getKredit($role, $kantor, $kode)
    {
        $getKredit = Kredit::select(DB::raw('SUM(plafon) as plafon'), DB::raw('SUM(baki_debet) as baki_debet'));

        if ($role == 'Kepala Seksi Kredit') {
            $getKredit->where('wilayah', $kantor->nama)
                ->whereNotIn('bidang', ['REMEDIAL'])
                ->groupBy('wilayah');
        } elseif ($role == 'Kepala Seksi Remedial') {
            $getKredit->where('bidang', 'REMEDIAL')
                ->groupBy('bidang');
        } elseif ($role == 'AO Kredit' || $role == 'Staff Remedial') {
            $getKredit->where('kode_petugas', $kode)
                ->groupBy('kode_petugas')
                ->groupBy('wilayah');
        }

        $getKredit->addSelect(DB::raw('FORMAT(SUM(plafon), 0, "id_ID") as plafon'));
        $getKredit->addSelect(DB::raw('FORMAT(SUM(baki_debet), 0, "id_ID") as baki_debet'));

        return $getKredit->first();
    }

    private function getJanji($role, $kantor, $kode)
    {
        $getJanji = Janji::with('kredit')
            ->whereHas('kredit') // Tambahkan ini untuk memastikan hanya data dengan relasi kredit yang diambil
            ->whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year);

        if ($role == 'Kepala Seksi Kredit' || $role == 'AO Kredit') {
            $getJanji->whereHas('kredit', function ($query) use ($kantor) {
                $query->where('wilayah', $kantor->nama)
                    ->whereNotIn('bidang', ['REMEDIAL']);
            });
        } elseif ($role == 'Kepala Seksi Remedial' || $role == 'Staff Remedial') {
            $getJanji->whereHas('kredit', function ($query) use ($kantor) {
                $query->where('bidang', 'REMEDIAL');
            });
        }

        return $getJanji->orderBy('tanggal', 'desc')->paginate(10);
    }
}
