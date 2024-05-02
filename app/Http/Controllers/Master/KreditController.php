<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Agunan;
use App\Models\Cif;
use App\Models\Jaminan;
use App\Models\Kantor;
use App\Models\Kredit;
use App\Models\Tugas;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class KreditController extends Controller
{
    public function index()
    {
        $kode   = Auth::user()->kode;
        $role   = Auth::user()->role;
        $kantor = Kantor::find(Auth::user()->kantor_id);

        // Data Kredit
        $data = Kredit::with('tunggakan', 'petugas');

        if ($role == 'Kepala Seksi Kredit') {
            $data->where('wilayah', $kantor->nama)
                ->whereNotIn('bidang', ['REMEDIAL']);
        } elseif ($role == 'Kepala Seksi Remedial') {
            $data->where('bidang', 'REMEDIAL');
        } elseif ($role == 'AO Kredit' || $role == 'Staff Remedial') {
            $data->where('kode_petugas', $kode);
        }

        $keyword = request('search');
        if (!empty($keyword)) {
            $data->where('nokredit', 'like', "%{$keyword}%")
                ->orWhere('nama_debitur', 'like', "%{$keyword}%")
                ->orWhere('wilayah', 'like', "%{$keyword}%")
                ->orWhere('bidang', 'like', "%{$keyword}%");
            $data->orWhereHas('petugas', function ($query) use ($keyword) {
                $query->where('name', 'like', "%{$keyword}%");
            });
        }

        $kredit = $data->orderBy('hari_tunggakan', 'desc')->paginate(10);

        foreach ($kredit as $item) {
            $item->plafon = number_format($item->plafon, 0, ',', '.');
            if (is_null($item->tunggakan)) {
                $item->tabelColor = "table-warning";
            } else {
                $item->tabelColor = "";
            }
        }

        return view('master.kredit.index', [
            'kredit'    => $kredit,
        ]);
    }

    public function show($nokredit)
    {
        $role   = Auth::user()->role;
        $kantor = Kantor::find(Auth::user()->kantor_id);

        $kredit = Kredit::with('tunggakan', 'petugas')->where('nokredit', $nokredit)->first();
        if (!$kredit) {
            abort(404);
        }

        $cif    = Cif::where('nocif', $kredit->nocif)->first();

        $tugas  = Tugas::with('leader', 'petugas')->where('nokredit', $nokredit)->orderBy('tanggal', 'desc')->get();
        $tugas->each(function ($item) {
            $item->tanggal = Carbon::parse($item->tanggal)->isoFormat('DD-MM-Y');
            if (is_null($item->foto_pelaksanaan)) {
                $item->foto_pelaksanaan = Storage::url('uploads/tugas/' . 'default.png');
            } else {
                $item->foto_pelaksanaan = Storage::url('uploads/tugas/' . $item->foto_pelaksanaan);
            }

            if ($item->pelaksanaan) {
                $item->pelaksanaan = $item->pelaksanaan . " ⇒ " . $item->ket_pelaksanaan;
            } else {
                $item->pelaksanaan = '';
            }

            if ($item->hasil) {
                $item->hasil = $item->hasil . " ⇒ " . $item->ket_hasil;
            } else {
                $item->hasil = '';
            }

            if ($item->catatan_leader) {
                $item->catatan_leader = $item->catatan_leader;
            } else {
                $item->catatan_leader = '';
            }
        });

        $agunan = Jaminan::where('no_spk', $kredit->nospk)->get();
        if ($agunan->isEmpty()) {
            $agunan = Agunan::where('nokredit', $nokredit)->get();
        }

        $kredit->plafon = number_format($kredit->plafon, 0, ',', '.');
        $kredit->baki_debet = number_format($kredit->baki_debet, 0, ',', '.');
        if ($kredit->tunggakan) {
            $kredit->tunggakan->tunggakan_pokok = number_format($kredit->tunggakan->tunggakan_pokok, 0, ',', '.');
            $kredit->tunggakan->tunggakan_bunga = number_format($kredit->tunggakan->tunggakan_bunga, 0, ',', '.');
            $kredit->tunggakan->tunggakan_denda = number_format($kredit->tunggakan->tunggakan_denda, 0, ',', '.');
        }

        $petugas = $this->getPetugas($role, $kantor);
        $jenis = [
            ['jenis' => 'Penagihan'],
            ['jenis' => 'Prospek'],
            ['jenis' => 'Verifikasi'],
        ];

        return view('master.kredit.show', [
            'kredit'    => $kredit,
            'cif'       => $cif,
            'agunan'    => $agunan,
            'tugas'     => $tugas,
            'petugas'   => $petugas,
            'jenis'     => $jenis,
        ]);
    }
    private function getPetugas($role, $kantor)
    {
        $query = User::where('is_active', 1)->orderBy('name', 'asc');

        if ($role == 'Direktur' || $role == 'Kepala Bagian Kredit') {
            $query->whereIn('role', ['Kepala Seksi Kredit', 'Kepala Seksi Remedial', 'Kepala Seksi Customer Care']);
        } elseif ($role == 'Kepala Seksi Kredit') {
            $query->where('kantor_id', $kantor->id)->where('role', 'AO Kredit');
        } elseif ($role == 'Kepala Seksi Remedial') {
            $query->where('kantor_id', $kantor->id)->where('role', 'Staff Remedial');
        } elseif ($role == 'Kepala Seksi Customer Care') {
            $query->where('kantor_id', $kantor->id)->where('role', 'Customer Care');
        }

        return $query->get();
    }

    public function print($nokredit)
    {
        $kredit = Kredit::with('tunggakan', 'petugas')->where('nokredit', $nokredit)->first();
        if (!$kredit) {
            abort(404);
        }

        $cif    = Cif::where('nocif', $kredit->nocif)->first();
        $tugas  = Tugas::with('leader', 'petugas')->where('nokredit', $nokredit)->orderBy('tanggal', 'desc')->get();
        $tugas->each(function ($item) {
            $item->tanggal = Carbon::parse($item->tanggal)->isoFormat('DD-MM-Y');
            $item->foto_pelaksanaan = $item->foto_pelaksanaan ?? 'images/tugas/default.png';

            if ($item->pelaksanaan) {
                $item->pelaksanaan = $item->pelaksanaan . " ⇒ " . $item->ket_pelaksanaan;
            } else {
                $item->pelaksanaan = '';
            }

            if ($item->hasil) {
                $item->hasil = $item->hasil . " ⇒ " . $item->ket_hasil;
            } else {
                $item->hasil = '';
            }

            if ($item->catatan_leader) {
                $item->catatan_leader = $item->catatan_leader;
            } else {
                $item->catatan_leader = '';
            }
        });

        $agunan = Jaminan::where('no_spk', $kredit->nospk)->get();
        if ($agunan->isEmpty()) {
            $agunan = Agunan::where('nokredit', $nokredit)->get();
        }

        $kredit->plafon = number_format($kredit->plafon, 0, ',', '.');
        $kredit->baki_debet = number_format($kredit->baki_debet, 0, ',', '.');
        if ($kredit->tunggakan) {
            $kredit->tunggakan->tunggakan_pokok = number_format($kredit->tunggakan->tunggakan_pokok, 0, ',', '.');
            $kredit->tunggakan->tunggakan_bunga = number_format($kredit->tunggakan->tunggakan_bunga, 0, ',', '.');
            $kredit->tunggakan->tunggakan_denda = number_format($kredit->tunggakan->tunggakan_denda, 0, ',', '.');
        }

        return view('master.kredit.print', [
            'kredit'    => $kredit,
            'cif'       => $cif,
            'agunan'    => $agunan,
            'tugas'     => $tugas,
        ]);
    }
}
