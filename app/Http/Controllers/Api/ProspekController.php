<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProspekRequest;
use App\Http\Requests\UpdateProspekRequest;
use App\Http\Resources\ProspekResource;
use App\Models\Prospek;
use Illuminate\Http\Request;

class ProspekController extends Controller
{
    // store
    public function store(StoreProspekRequest $request)
    {
        $prospek = Prospek::create($request->validated());

        if ($request->hasFile('foto_pelaksanaan')) {
            $foto_pelaksanaan = $request->file('foto_pelaksanaan')->store('prospek');
            $prospek->update(['foto_pelaksanaan' => $foto_pelaksanaan]);
        }

        return new ProspekResource($prospek);
    }

    public function update(UpdateProspekRequest $request, Prospek $prospek)
    {
        $prospek->update($request->validated());

        return new ProspekResource($prospek);
    }

    public function upload(Request $request)
    {
        $request->validate([
            'id'                => 'required',
            'foto_pelaksanaan'  => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
        ], [
            'id.required'               => 'ID tidak boleh kosong',
            'foto_pelaksanaan.required' => 'Foto tidak boleh kosong',
            'foto_pelaksanaan.image'    => 'Foto harus berupa gambar',
            'foto_pelaksanaan.mimes'    => 'Foto harus berformat jpeg, png, jpg, gif, atau svg',
            'foto_pelaksanaan.max'      => 'Ukuran foto maksimal 5MB',
        ]);

        $id = $request->id;
        $fileName   = $id . '.' . $request->foto_pelaksanaan->getClientOriginalExtension();
        $request->foto_pelaksanaan->move(public_path('images/prospek'), $fileName);

        $prospek = Prospek::where('id', $id)->first();
        $prospek->foto_pelaksanaan = $fileName;
        $prospek->save();

        return new ProspekResource($prospek);
    }
}
