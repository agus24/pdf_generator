<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BaseResource extends JsonResource
{
    public function __construct(
        public array $data = [],
        public ?string $message = null
    ) {}

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $output = [];
        if (array_key_exists('data', $this->data)) {
            $output = $this->data;
        } else {
            $output['data'] = $this->data;
        }

        if ($this->message) {
            $output['message'] = $this->message;
        }

        return $output;
    }
}
