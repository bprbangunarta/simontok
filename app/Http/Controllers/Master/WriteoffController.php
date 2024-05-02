<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Agunan;
use App\Models\Cif;
use App\Models\Jaminan;
use App\Models\Tugas;
use App\Models\User;
use App\Models\Verifikasi;
use App\Models\Writeoff;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class WriteoffController extends Controller
{
    public function index()
    {
        $kode = Auth::user()->kode;
        $role = Auth::user()->role;
        $data = Writeoff::with('petugas');

        if ($role == 'Staff Remedial') {
            $data->where('kode_petugas', $kode);
        }

        $keyword = request('search');
        if (!empty($keyword)) {
            $data->where('nokredit', 'like', "%{$keyword}%")
                ->orWhere('nama_debitur', 'like', "%{$keyword}%")
                ->orWhere('wilayah', 'like', "%{$keyword}%");
            $data->orWhereHas('petugas', function ($query) use ($keyword) {
                $query->where('name', 'like', "%{$keyword}%");
            });
        }

        $writeoff = $data->orderBy('wilayah', 'ASC')->paginate(10);

        foreach ($writeoff as $item) {
            $item->plafon = number_format($item->plafon, 0, ',', '.');
        }

        return view('master.writeoff.index', [
            'writeoff' => $writeoff,
        ]);
    }

    public function show($nokredit)
    {
        $role   = Auth::user()->role;

        // Data Kredit
        $kredit = Writeoff::with('petugas')->where('nokredit', $nokredit)->first();
        if (!$kredit) {
            abort(404);
        }
        $kredit->plafon = number_format($kredit->plafon, 0, ',', '.');
        $kredit->baki_debet = number_format($kredit->baki_debet, 0, ',', '.');

        $cif = Cif::where('nocif', $kredit->nocif)->first();
        $agunan = DB::connection('sqlsrv')
            ->table('m_detil_jaminan')
            ->select('catatan')
            ->where('nocif', $kredit->nocif)
            ->get();

        // Data Tugas
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

        $petugas = $this->getPetugas($role);

        $jenis = [
            ['jenis' => 'Penagihan'],
            ['jenis' => 'Prospek'],
            ['jenis' => 'Verifikasi'],
        ];

        return view('master.writeoff.show', [
            'kredit'    => $kredit,
            'cif'       => $cif,
            'agunan'    => $agunan,
            'tugas'     => $tugas,
            'petugas'   => $petugas,
            'jenis'     => $jenis,
        ]);
    }
    private function getPetugas($role)
    {
        $query = User::where('is_active', 1)->orderBy('name', 'asc');

        if ($role == 'Kepala Seksi Remedial') {
            $query->where('role', 'Staff Remedial');
        } else {
            $query->where('role', 'Kepala Seksi Remedial');
        }

        return $query->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'nokredit'   => 'required',
            'petugas_id' => 'required',
            'jenis'      => 'required',
        ], [
            'nokredit.required'   => 'Nomer Kredit wajib diisi',
            'petugas_id.required' => 'Petugas wajib diisi',
            'jenis.required'      => 'Jenis Tugas wajib diisi',
        ]);

        $tugas = Tugas::where('nokredit', $request->nokredit)->where('tanggal', date('Y-m-d'))->first();

        if ($tugas) {
            return redirect()->back()->with('error', 'Tugas untuk debitur tersebut sudah dibuat');
        } else {
            $tunggakan = Writeoff::where('nokredit', $request->nokredit)->first();
            $notugas = strtoupper(substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyz'), 0, 9));

            Tugas::create([
                'notugas'           => $notugas,
                'nokredit'          => $request->nokredit,
                'tanggal'           => date('Y-m-d'),
                'jenis'             => $request->jenis,
                'tunggakan_pokok'   => null,
                'tunggakan_bunga'   => $tunggakan->tunggakan_bunga,
                'tunggakan_denda'   => $tunggakan->tunggakan_denda,
                'petugas_id'        => $request->petugas_id,
                'leader_id'         => Auth::id(),
            ]);

            if ($request->jenis == 'Verifikasi') {
                Verifikasi::create([
                    'notugas'       => $notugas,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Tugas berhasil dibuat');
    }

    public function print($nokredit)
    {
        $kredit = Writeoff::with('petugas')->where('nokredit', $nokredit)->first();
        if (!$kredit) {
            abort(404);
        }

        $cif = Cif::where('nocif', $kredit->nocif)->first();
        $agunan = DB::connection('sqlsrv')
            ->table('m_detil_jaminan')
            ->select('catatan')
            ->where('nocif', $kredit->nocif)
            ->get();

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

        $kredit->plafon = number_format($kredit->plafon, 0, ',', '.');
        $kredit->baki_debet = number_format($kredit->baki_debet, 0, ',', '.');
        if ($kredit->tunggakan) {
            $kredit->tunggakan->tunggakan_pokok = number_format($kredit->tunggakan->tunggakan_pokok, 0, ',', '.');
            $kredit->tunggakan->tunggakan_bunga = number_format($kredit->tunggakan->tunggakan_bunga, 0, ',', '.');
            $kredit->tunggakan->tunggakan_denda = number_format($kredit->tunggakan->tunggakan_denda, 0, ',', '.');
        }

        return view('master.writeoff.print', [
            'kredit'    => $kredit,
            'cif'       => $cif,
            'agunan'    => $agunan,
            'tugas'     => $tugas,
        ]);
    }
}
