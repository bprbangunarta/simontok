<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TugasResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'notugas'           => $this->notugas,
            'pelaksanaan'       => $this->pelaksanaan,
            'ket_pelaksanaan'   => $this->ket_pelaksanaan,
            'hasil'             => $this->hasil,
            'ket_hasil'         => $this->ket_hasil,
            'catatan_leader'    => $this->catatan_leader,
            'foto_pelaksanaan'  => $this->foto_pelaksanaan,
        ];
    }
}
