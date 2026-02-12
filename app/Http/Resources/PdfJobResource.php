<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PdfJobResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'pdf_url' => $this->pdf_url,
            'status' => $this->status->value,
            'status_description' => $this->status->description,
            'error_message' => $this->error_message,
        ];
    }
}
