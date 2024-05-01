<?php

namespace App\Http\Controllers;

use App\Models\Kantor;
use App\Models\Prospek;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProspekController extends Controller
{
    public function index()
    {
        $role = Auth::user()->role;
        $kantor = Kantor::findorFail(Auth::user()->kantor_id);

        $data = Prospek::with('petugas');

        if ($role == 'AO Kredit' || $role == 'Staff Remedial') {
            $data->where('petugas_id', Auth::user()->id);
        } elseif ($role == 'Kepala Seksi Kredit' || $role == 'Kepala Seksi Remedial') {
            $data->whereHas('petugas', function ($query) use ($kantor) {
                $query->where('kantor_id', $kantor->id);
            });
        }

        $keyword = request('search');
        if (!empty($keyword)) {
            $data->where(function ($query) use ($keyword) {
                $query->where('tanggal', 'like', '%' . $keyword . '%')
                    ->orWhere('calon_debitur', 'like', '%' . $keyword . '%')
                    ->orWhere('jenis', 'like', '%' . $keyword . '%');
            });

            $data->orWhereHas('petugas', function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%');
            });
        }

        $prospek = $data->orderBy('id', 'desc')
            ->paginate(10);

        $prospek->each(function ($item) {
            $item->longDate = Carbon::parse($item->tanggal)->locale('id')->isoFormat('dddd, D MMMM Y');

            if ($item->status == "0") {
                $item->status = "Proses";
                $item->statusColor = "warning";
            } else {
                $item->status = "Berhasil";
                $item->statusColor = "success";
            }

            $id = Auth::user()->id;
            $item->aksesDelete = $item->petugas_id == $id ? '' : 'disable-clik';
        });

        $jenis = [
            ['jenis' => 'Prospek'],
            ['jenis' => 'Survey'],
            ['jenis' => 'Lainnya'],
        ];

        return view('monitoring.prospek.index', [
            'prospek'   => $prospek,
            'jenis'     => $jenis,
        ]);
    }

    public function create()
    {
        $jenis = [
            ['jenis' => 'Prospek'],
            ['jenis' => 'Survey'],
            ['jenis' => 'Lainnya'],
        ];

        $status = [
            ['id' => '0', 'status' => 'Proses'],
            ['id' => '1', 'status' => 'Berhasil'],
        ];

        return view('monitoring.prospek.create', [
            'jenis'  => $jenis,
            'status' => $status,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis'         => 'required',
            'calon_debitur' => 'required',
            'nohp'          => 'required|unique:data_prospek,nohp',
            'keterangan'    => 'required',
            'status'        => 'required',
        ], [
            'jenis.required'         => 'Jenis prospek tidak boleh kosong',
            'calon_debitur.required' => 'Calon debitur tidak boleh kosong',
            'nohp.required'          => 'No. HP tidak boleh kosong',
            'nohp.unique'            => 'No. HP sudah terdaftar',
            'keterangan.required'    => 'Keterangan tidak boleh kosong',
            'status.required'        => 'Status tidak boleh kosong',
        ]);

        $request->merge([
            'petugas_id' => Auth::user()->id,
            'tanggal'    => Carbon::now(),
        ]);

        Prospek::create($request->all());

        return redirect()->route('prospek.show', Prospek::latest()->first()->id)->with('success', 'Data prospek berhasil ditambahkan');
    }

    public function show(Prospek $prospek)
    {
        $prospek->load('petugas');

        if (is_null($prospek->foto_pelaksanaan)) {
            $prospek->foto_pelaksanaan = Storage::url('uploads/prospek/' . 'default.png');
        } else {
            $prospek->foto_pelaksanaan = Storage::url('uploads/prospek/' . $prospek->foto_pelaksanaan);
        }

        $jenis = [
            ['jenis' => 'Prospek'],
            ['jenis' => 'Survey'],
            ['jenis' => 'Lainnya'],
        ];

        $status = [
            ['id' => '0', 'status' => 'Proses'],
            ['id' => '1', 'status' => 'Berhasil'],
        ];

        $id = Auth::user()->id;
        $prospek->aksesForm = $prospek->petugas_id == $id ? '' : 'disabled';

        return view('monitoring.prospek.show', [
            'prospek' => $prospek,
            'jenis'   => $jenis,
            'status'  => $status,
        ]);
    }

    public function update(Request $request, Prospek $prospek)
    {
        $request->validate([
            'jenis'         => 'required',
            'calon_debitur' => 'required',
            'nohp'          => 'required',
            'keterangan'    => 'required',
            'status'        => 'required',
        ], [
            'jenis.required'         => 'Jenis prospek tidak boleh kosong',
            'calon_debitur.required' => 'Calon debitur tidak boleh kosong',
            'nohp.required'          => 'No. HP tidak boleh kosong',
            'keterangan.required'    => 'Keterangan tidak boleh kosong',
            'status.required'        => 'Status tidak boleh kosong',

        ]);

        $prospek->update($request->all());
        return redirect()->back()->with('success', 'Data prospek berhasil diperbarui');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'id' => 'required|string',
            'foto_pelaksanaan' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $id = $request->id;
        $file = $request->file('foto_pelaksanaan');

        try {
            $client = new Client();
            $response = $client->post('https://simontok.bprbangunarta.com/api/prospek/upload', [
                'multipart' => [
                    [
                        'name'     => 'id',
                        'contents' => $id,
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

    public function destroy(Prospek $prospek)
    {
        $prospek->delete();

        return redirect()->back()->with('success', 'Data prospek berhasil dihapus');
    }
}
