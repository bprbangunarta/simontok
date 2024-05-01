<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateTugasRequest;
use App\Http\Resources\TugasResource;
use App\Models\Tugas;
use Illuminate\Http\Request;

class TugasController extends Controller
{
    public function update(UpdateTugasRequest $request, $notugas)
    {
        $tugas = Tugas::where('notugas', $notugas)->first();
        $tugas->pelaksanaan     = $request->pelaksanaan;
        $tugas->ket_pelaksanaan = $request->ket_pelaksanaan;
        $tugas->hasil           = $request->hasil;
        $tugas->ket_hasil       = $request->ket_hasil;
        $tugas->catatan_leader  = $request->catatan_leader;
        $tugas->save();

        return new TugasResource($tugas);
    }

    public function upload(Request $request)
    {
        $request->validate([
            'notugas' => 'required|string',
            'foto_pelaksanaan' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
        ], [
            'notugas.required'          => 'No Tugas tidak boleh kosong',
            'foto_pelaksanaan.required' => 'Foto tidak boleh kosong',
            'foto_pelaksanaan.image'    => 'Foto harus berupa gambar',
            'foto_pelaksanaan.mimes'    => 'Foto harus berformat jpeg, png, jpg, gif, atau svg',
            'foto_pelaksanaan.max'      => 'Ukuran foto maksimal 5MB',
        ]);

        $notugas = $request->notugas;
        $file = $request->file('foto_pelaksanaan');

        $fileName = $notugas . '.' . $file->getClientOriginalExtension();

        $file->storeAs('uploads/tugas', $fileName);

        $tugas = Tugas::where('notugas', $notugas)->first();

        if (!$tugas) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $tugas->foto_pelaksanaan = $fileName;
        $tugas->save();

        return new TugasResource($tugas);
    }
}
