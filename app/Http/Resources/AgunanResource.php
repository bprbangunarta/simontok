<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AgunanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'noreg'         => $this->noreg,
            'agunan'        => $this->agunan,
            'kondisi'       => $this->kondisi,
            'penguasaan'    => $this->penguasaan,
        ];
    }
}
