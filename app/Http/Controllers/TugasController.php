<?php

namespace App\Http\Controllers;

use App\Models\Cif;
use App\Models\Kantor;
use App\Models\Kredit;
use App\Models\Tugas;
use App\Models\Tunggakan;
use App\Models\User;
use App\Models\Verifikasi;
use App\Models\VerifikasiAgunan;
use App\Models\Writeoff;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TugasController extends Controller
{
    public function index()
    {
        $role = Auth::user()->role;
        $data = Tugas::with('kredit', 'writeoff', 'petugas', 'leader');

        if ($role == 'Kepala Seksi Kredit' || $role == 'Kepala Seksi Remedial') {
            $data->where(function ($query) {
                $query->where('leader_id', Auth::user()->id)
                    ->orWhere('petugas_id', Auth::user()->id);
            })->where('tanggal', '>=', Carbon::now()->subDays(7));
        } elseif ($role == 'AO Kredit' || $role == 'Staff Remedial' || $role == 'Customer Care') {
            $data->where('petugas_id', Auth::user()->id)
                ->where('tanggal', date('Y-m-d'));
        } else {
            $data->where('leader_id', Auth::user()->id)
                ->where('tanggal', '>=', Carbon::now()->subDays(7));
        }

        $keyword = request('search');
        if (!empty($keyword)) {
            $data->where(function ($query) use ($keyword) {
                $query->whereHas('kredit', function ($query) use ($keyword) {
                    $query->where('nokredit', 'like', "%{$keyword}%")
                        ->orWhere('nama_debitur', 'like', "%{$keyword}%")
                        ->orWhere('tanggal', 'like', "%{$keyword}%")
                        ->orWhere('jenis', 'like', "%{$keyword}%");
                })
                    ->orWhereHas('writeoff', function ($query) use ($keyword) {
                        $query->where('nokredit', 'like', "%{$keyword}%")
                            ->orWhere('nama_debitur', 'like', "%{$keyword}%")
                            ->orWhere('tanggal', 'like', "%{$keyword}%")
                            ->orWhere('jenis', 'like', "%{$keyword}%");
                    })
                    ->orWhereHas('petugas', function ($query) use ($keyword) {
                        $query->where('name', 'like', "%{$keyword}%");
                    });
            });
        }

        $tugas = $data->orderBy('tanggal', 'desc')
            ->paginate(10);

        $tugas->each(function ($item) {
            if (is_null($item->kredit)) {
                $item->nama_debitur = $item->writeoff->nama_debitur;
            } else {
                $item->nama_debitur = $item->kredit->nama_debitur;
            }

            $id = Auth::user()->id;
            $item->longDate = Carbon::parse($item->tanggal)->locale('id')->isoFormat('dddd, D MMMM Y');

            if (is_null($item->pelaksanaan)) {
                $item->tableColor = 'table-warning';
            } else {
                $item->tableColor = '';
            }

            $item->btnColor = $item->catatan_leader == '' ? 'bg-warning' : 'bg-success';
            $item->btnAccess = $item->leader_id == $id ? '' : 'disabled';
            $item->aksesDelete = $item->tanggal == date('Y-m-d') ? '' : 'disable-clik';
        });

        return view('monitoring.tugas.index', [
            'tugas' => $tugas,
        ]);
    }

    public function create($nokredit)
    {
        // Parameter
        $role = Auth::user()->role;
        $kantor = Kantor::find(Auth::user()->kantor_id);

        // Data Kredit
        $decrypt = decrypt($nokredit);
        $kredit  = Kredit::with('tunggakan', 'petugas')->where('nokredit', $decrypt)->first();

        // Data Tugas
        $tugas = Tugas::with('petugas')->where('nokredit', $decrypt)->orderBy('tanggal', 'desc')->get();
        $tugas->each(function ($item) {
            $item->tanggal = Carbon::parse($item->tanggal)->locale('id')->isoFormat('dddd, D MMMM Y');
            $item->foto_pelaksanaan = $item->foto_pelaksanaan ?? 'default.png';
        });

        // Data Petugas
        if ($role == 'Kepala Seksi Kredit') {
            $petugas = User::where('kantor_id', $kantor->id)
                ->where('role', 'AO Kredit')
                ->where('is_active', 1)
                ->orderBy('name', 'asc')
                ->get();
        } elseif ($role == 'kasi-remedial') {
            $petugas = User::where('kantor_id', $kantor->id)
                ->where('role', 'staff-remedial')
                ->where('is_active', 1)
                ->orderBy('name', 'asc')
                ->get();
        } else {
            $petugas = User::whereIn('role', ['Kepala Seksi Kredit', 'kasi-remedial', 'kasi-cc'])
                ->where('is_active', 1)
                ->orderBy('name', 'asc')
                ->get();
        }

        // Data Jenis
        $jenis = [
            ['jenis' => 'Penagihan'],
            ['jenis' => 'Prospek'],
            ['jenis' => 'Verifikasi'],
        ];

        return view('monitoring.tugas.create', [
            'kredit'    => $kredit,
            'tugas'     => $tugas,
            'petugas'   => $petugas,
            'jenis'     => $jenis,
        ]);
    }

    public function show($notugas)
    {
        $tugas = Tugas::with('kredit', 'writeoff', 'petugas', 'leader')->where('notugas', $notugas)->first();

        if (is_null($tugas->kredit)) {
            $tugas->nokredit = $tugas->writeoff->nokredit;
            $tugas->nama_debitur = $tugas->writeoff->nama_debitur;
        } else {
            $tugas->nokredit = $tugas->kredit->nokredit;
            $tugas->nama_debitur = $tugas->kredit->nama_debitur;
        }

        $tugas->tanggal = Carbon::parse($tugas->tanggal)->locale('id')->isoFormat('dddd, D MMMM Y');
        $tugas->foto_pelaksanaan = $tugas->foto_pelaksanaan ?? 'default.png';
        if (is_null($tugas->foto_pelaksanaan)) {
            $tugas->foto_pelaksanaan = Storage::url('uploads/tugas/' . 'default.png');
        } else {
            $tugas->foto_pelaksanaan = Storage::url('uploads/tugas/' . $tugas->foto_pelaksanaan);
        }

        $id = Auth::user()->id;
        $tugas->aksesUpload = $tugas->petugas_id == $id ? '' : 'disabled';
        $tugas->aksesLaporan = $tugas->petugas_id == $id ? '' : 'readonly';
        $tugas->aksesCatatan = $tugas->leader_id == $id ? '' : 'readonly';

        if (Auth::user()->role == 'Kepala Seksi Customer Care' || Auth::user()->role == 'Customer Care') {
            $pelaksanaan = [
                ['pelaksanaan' => 'Telebilling', 'detail' => 'Telebilling'],
            ];

            $hasil = [
                ['hasil' => 'Janji Bayar'],
                ['hasil' => 'Telepon Tidak Aktif'],
                ['hasil' => 'Telepon Tidak Aktif (FU AO)'],
                ['hasil' => 'Telepon Tidak Diangkat'],
                ['hasil' => 'Lainnya'],
            ];
        } else {
            $pelaksanaan = [
                ['pelaksanaan' => 'Penagihan', 'detail' => 'Penagihan Kredit'],
                ['pelaksanaan' => 'Prospek', 'detail' => 'Prospek Kredit'],
            ];

            $hasil = [
                ['hasil' => 'Bayar Full'],
                ['hasil' => 'Topup Kredit'],
                ['hasil' => 'Lainnya'],
            ];
        }

        return view('monitoring.tugas.show', [
            'tugas'       => $tugas,
            'pelaksanaan' => $pelaksanaan,
            'hasil'       => $hasil,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nokredit'    => 'required',
            'petugas_id'  => 'required',
            'jenis'       => 'required',
        ], [
            'nokredit.required'   => 'Nomer Kredit wajib diisi',
            'petugas_id.required' => 'Petugas wajib diisi',
            'jenis.required'      => 'Jenis Tugas wajib diisi',
        ]);

        $tugas = Tugas::where('nokredit', $request->nokredit)->where('tanggal', date('Y-m-d'))->whereNotIn('jenis', ['Telebilling'])->first();

        if ($tugas) {
            return redirect()->back()->with('error', 'Tugas untuk debitur tersebut sudah dibuat');
        } else {
            $notugas = strtoupper(substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyz'), 0, 9));

            $tunggakan = Tunggakan::where('nokredit', $request->nokredit)->first();
            if (is_null($tunggakan)) {
                $tunggakan = Writeoff::where('nokredit', $request->nokredit)->first();
            }

            Tugas::create([
                'notugas'           => $notugas,
                'nokredit'          => $request->nokredit,
                'tanggal'           => date('Y-m-d'),
                'jenis'             => $request->jenis,
                'tunggakan_pokok'   => $tunggakan->tunggakan_pokok,
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

    public function update(Request $request, $notugas)
    {
        try {
            $client = new Client();
            $response = $client->request('PUT', 'https://simontok.test/api/tugas/' . $notugas, [
                'form_params' => [
                    'pelaksanaan'       => $request->pelaksanaan,
                    'ket_pelaksanaan'   => $request->ket_pelaksanaan,
                    'hasil'             => $request->hasil,
                    'ket_hasil'         => $request->ket_hasil,
                    'catatan_leader'    => $request->catatan_leader,
                ],
                'headers' => [
                    'Accept' => 'application/json',
                ],
            ]);

            if ($request->ket_hasil) {
                $tugas = Tugas::where('notugas', $notugas)->first();
                $tugas->update([
                    'status' => 'Selesai',
                ]);
            }

            $data = json_decode($response->getBody()->getContents());

            return redirect()->back()->with('success', 'Tugas berhasil diperbarui');
        } catch (\Exception $e) {
            // return redirect()->back()->with('error', 'Gagal memperbarui tugas: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Tugas tidak boleh kosong');
        }
    }

    public function upload(Request $request)
    {
        $request->validate([
            'notugas' => 'required|string',
            'foto_pelaksanaan' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $notugas = $request->notugas;
        $file = $request->file('foto_pelaksanaan');

        try {
            $client = new Client();
            $response = $client->post('https://simontok.test/api/tugas/upload', [
                'multipart' => [
                    [
                        'name'     => 'notugas',
                        'contents' => $notugas,
                    ],
                    [
                        'name'     => 'foto_pelaksanaan',
                        'contents' => fopen($file->getPathname(), 'r'),
                        'filename' => $file->getClientOriginalName(),
                    ],
                ],
            ]);

            $responseData = json_decode($response->getBody()->getContents(), true);
            return redirect()->back()->with('success', 'Foto berhasil diunggah');

            return response()->json($responseData);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengunggah foto: ' . $e->getMessage());
        }
    }

    public function destroy($notugas)
    {
        $tugas = Tugas::where('notugas', $notugas)->first();
        $tugas->delete();

        if ($tugas->jenis == 'Verifikasi') {
            Verifikasi::where('notugas', $notugas)->delete();
            VerifikasiAgunan::where('notugas', $notugas)->delete();
        }

        return redirect()->back()->with('success', 'Tugas berhasil dihapus');
    }

    public function print()
    {
        $role = Auth::user()->role;
        $data = Tugas::with('kredit', 'writeoff', 'petugas', 'leader');

        if ($role == "Kepala Seksi Customer Care" || $role == "Customer Care") {
            $data->where('jenis', 'Telebilling');
        } else {
            $data->where('leader_id', Auth::user()->id);
        }

        $tugas = $data->where('tanggal', date('Y-m-d'))->orderBy('tanggal', 'desc')->get();

        if ($tugas->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada data tugas hari ini');
        }

        $tugas->each(function ($item) {
            $item->pokok = 'Rp ' . number_format($item->tunggakan_pokok ?? 0, 0, ',', '.');
            $item->bunga = 'Rp ' . number_format($item->tunggakan_bunga ?? 0, 0, ',', '.');
            $item->denda = 'Rp ' . number_format($item->tunggakan_denda ?? 0, 0, ',', '.');

            $total_tunggakan = $item->tunggakan_pokok + $item->tunggakan_bunga + $item->tunggakan_denda;
            $item->total_tunggakan = 'Rp ' . number_format($total_tunggakan, 0, ',', '.');

            if (!is_null($item->kredit)) {
                $item->nokredit = $item->kredit->nokredit;
                $item->nama_debitur = $item->kredit->nama_debitur;
                $item->alamat = $item->kredit->alamat;
                $item->notabungan = $item->kredit->notabungan;
                $item->plafon = 'Rp ' . number_format($item->kredit->plafon ?? 0, 0, ',', '.');
                $item->tgl_jatuh_tempo = Carbon::parse($item->kredit->tgl_jatuh_tempo)->locale('id')->isoFormat('dddd, D MMMM Y');
                $cif = Cif::where('nocif', $item->kredit->nocif)->first();
                if ($cif) {
                    $item->nohp = $cif->nohp;
                }
            } elseif (!is_null($item->writeoff)) {
                $item->nokredit = $item->writeoff->nokredit;
                $item->nama_debitur = $item->writeoff->nama_debitur;
                $item->alamat = $item->writeoff->alamat;
                $item->notabungan = null;
                $item->plafon = 'Rp ' . number_format($item->writeoff->plafon ?? 0, 0, ',', '.');
                $item->tgl_jatuh_tempo = Carbon::parse($item->writeoff->tgl_jatuh_tempo)->locale('id')->isoFormat('dddd, D MMMM Y');
                $cif = Cif::where('nocif', $item->writeoff->nocif)->first();
                if ($cif) {
                    $item->nohp = $cif->nohp;
                }
            }
        });

        $tanggal = Carbon::now()->locale('id')->isoFormat('D MMMM Y');
        $kantor = Kantor::find(Auth::user()->kantor_id);

        if ($role == "Kepala Seksi Customer Care" || $role == "Customer Care") {
            return view('monitoring.tugas.print-cc', [
                'tugas'     => $tugas,
                'tanggal'   => $tanggal,
                'kantor'    => $kantor,
            ]);
        }

        return view('monitoring.tugas.print', [
            'tugas'     => $tugas,
            'tanggal'   => $tanggal,
            'kantor'    => $kantor,
        ]);
    }
}
