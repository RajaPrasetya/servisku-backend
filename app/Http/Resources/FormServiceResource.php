<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FormServiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'no_form' => $this->no_form,
            'status' => $this->status,
            'status_label' => $this->getStatusLabel(),
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
            'customer' => $this->whenLoaded('customer', function () {
                return [
                    'id_customer' => $this->customer->id_customer,
                    'nama' => $this->customer->nama,
                    'no_telp' => $this->customer->no_telp,
                    'alamat' => $this->customer->alamat,
                ];
            }),
            'user' => $this->whenLoaded('user', function () {
                return [
                    'id_user' => $this->user->id_user,
                    'name' => $this->user->name,
                    'email' => $this->user->email,
                    'phone' => $this->user->phone,
                    'role' => $this->user->role,
                ];
            }),
            'detail_service' => $this->whenLoaded('detailService', function () {
                return [
                    'id' => $this->detailService->id,
                    'tgl_masuk' => $this->detailService->tgl_masuk,
                    'tgl_selesai' => $this->detailService->tgl_selesai,
                    'estimasi' => $this->detailService->estimasi,
                    'biaya' => $this->detailService->biaya,
                ];
            }),
        ];
    }

    /**
     * Get status label in Indonesian
     */
    private function getStatusLabel(): string
    {
        return match($this->status) {
            'diterima' => 'Diterima',
            'proses' => 'Dalam Proses',
            'selesai' => 'Selesai',
            default => ucfirst($this->status),
        };
    }
}
