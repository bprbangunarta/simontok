<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Agunan;
use App\Models\Cif;
use App\Models\Jaminan;
use App\Models\Janji;
use App\Models\Kredit;
use App\Models\Tugas;
use App\Models\Tunggakan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TelebillingController extends Controller
{
    public function index()
    {
        $data = Kredit::with('tunggakan')
            ->whereNotIn('produk_id', ['7', '10', '14', '16'])
            ->whereBetween('hari_tunggakan', [1, 30])
            ->orderBy('hari_tunggakan', 'asc');

        $keyword = request('search');
        if (!empty($keyword)) {
            $data->where(function ($query) use ($keyword) {
                $query->where('nama_debitur', 'like', "%{$keyword}%")
                    ->orWhere('wilayah', 'like', "%{$keyword}%")
                    ->orWhere('hari_tunggakan', '=', $keyword)
                    ->orWhere('kode_petugas', 'like', "%{$keyword}%");
            });
        }

        $kredit = $data->paginate(10);

        $kredit->each(function ($item) {
            $item->total = $item->tunggakan->tunggakan_pokok + $item->tunggakan->tunggakan_bunga + $item->tunggakan->tunggakan_denda;
            $item->total = number_format($item->total, 0, ',', '.');

            $cif = Cif::where('nocif', $item->nocif)->first();
            $item->nohp = $cif->nohp ?? '0';
            $item->nohp = substr($item->nohp, 0, 1) == '0' ? '62' . substr($item->nohp, 1) : $item->nohp;
            $item->whatsapp = "https://api.whatsapp.com/send/?phone=$item->nohp&text=Yth.+Bpk%2FIbu+%2A$item->nama_debitur%2A+%0A%0AKami+dari+BPR+BANGUNARTA%2C+kredit+anda+sdh+Jt+Tempo+$item->hari_tunggakan+hari.+Lakukan+pembayaran+tunggakan+sebesar+%2ARp.+$item->total%2A+melalui+Virtual+Account+atau+Kantor+BPR+BANGUNARTA+terdekat+%0A%0ATerima+kasih.";
        });

        return view('master.telebilling.index', [
            'kredit' => $kredit,
        ]);
    }

    public function show($nokredit)
    {
        $janji = Janji::where('nokredit', $nokredit)->first();
        $kredit = Kredit::with('tunggakan')->where('nokredit', $nokredit)->first();
        if (!$kredit) {
            abort(404);
        }
        $kredit->plafon = number_format($kredit->plafon, 0, ',', '.');
        $kredit->baki_debet = number_format($kredit->baki_debet, 0, ',', '.');
        $kredit->tunggakan_pokok = number_format($kredit->tunggakan->tunggakan_pokok, 0, ',', '.');
        $kredit->tunggakan_bunga = number_format($kredit->tunggakan->tunggakan_bunga, 0, ',', '.');
        $kredit->tunggakan_denda = number_format($kredit->tunggakan->tunggakan_denda, 0, ',', '.');
        $total = $kredit->tunggakan->tunggakan_pokok + $kredit->tunggakan->tunggakan_bunga + $kredit->tunggakan->tunggakan_denda;
        $kredit->total = number_format($total, 0, ',', '.');

        $cif = Cif::where('nocif', $kredit->nocif)->first();
        $tugas = Tugas::with('petugas')->where('nokredit', $nokredit)->where('jenis', 'Telebilling')->orderBy('tanggal', 'desc')->get();
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

        $hasil = [
            ['hasil' => 'Janji Bayar'],
            ['hasil' => 'Telepon Tidak Aktif'],
            ['hasil' => 'Telepon Tidak Aktif (FU AO)'],
            ['hasil' => 'Telepon Tidak Diangkat'],
            ['hasil' => 'Lainnya'],
        ];

        return view('master.telebilling.show', [
            'janji'  => $janji,
            'kredit' => $kredit,
            'cif'    => $cif,
            'tugas'  => $tugas,
            'agunan' => $agunan,
            'hasil'  => $hasil,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'ket_hasil' => 'required',
        ], [
            'ket_hasil.required' => 'Keterangan tidak boleh kosong',
        ]);

        $tugas = Tugas::where('nokredit', $request->nokredit)
            ->where('tanggal', date('Y-m-d'))
            ->where('jenis', 'Telebilling')
            ->first();

        if ($tugas) {
            return redirect()->back()->with('error', 'Tugas untuk debitur tersebut sudah dibuat');
        } else {
            $notugas = strtoupper(substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyz'), 0, 9));
            $tunggakan = Tunggakan::where('nokredit', $request->nokredit)->first();

            $leader = User::where('role', 'Kepala Seksi Customer Care')
                ->where('kantor_id', Auth::user()->kantor_id)
                ->where('is_active', 1)
                ->first();

            Tugas::create([
                'notugas'           => $notugas,
                'nokredit'          => $request->nokredit,
                'tanggal'           => date('Y-m-d'),
                'jenis'             => 'Telebilling',

                'pelaksanaan'       => 'Telebilling',
                'ket_pelaksanaan'   => 'Penagihan melalui telepon',
                'hasil'             => $request->hasil,
                'ket_hasil'         => $request->ket_hasil,
                'status'            => 'Selesai',

                'tunggakan_pokok'   => $tunggakan->tunggakan_pokok,
                'tunggakan_bunga'   => $tunggakan->tunggakan_bunga,
                'tunggakan_denda'   => $tunggakan->tunggakan_denda,
                'petugas_id'        => Auth::user()->id,
                'leader_id'         => $leader->id,
            ]);

            if ($request->janji_bayar) {
                $cekJanji = Janji::where('nokredit', $request->nokredit)->first();
                if ($cekJanji) {
                    $cekJanji->update([
                        'tanggal'    => $request->janji_bayar,
                        'komitmen'   => $request->ket_hasil,
                        'petugas_id' => Auth::user()->id,
                    ]);
                } else {
                    Janji::create([
                        'nokredit'      => $request->nokredit,
                        'tanggal'       => $request->janji_bayar,
                        'komitmen'      => $request->ket_hasil,
                        'petugas_id'    => Auth::user()->id,
                    ]);
                }
            }
        }

        return redirect()->back()->with('success', 'Telebilling berhasil dibuat');
    }
}
