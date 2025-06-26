<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id_customer' => $this->id_customer,
            'nama' => $this->nama,
            'no_telp' => $this->no_telp,
            'alamat' => $this->alamat,
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
            'form_services' => $this->whenLoaded('formServices', function () {
                return $this->formServices->map(function ($formService) {
                    return [
                        'no_form' => $formService->no_form,
                        'status' => $formService->status,
                        'created_at' => $formService->created_at?->format('Y-m-d H:i:s'),
                    ];
                });
            }),
            'total_services' => $this->whenLoaded('formServices', function () {
                return $this->formServices->count();
            }),
        ];
    }
}
