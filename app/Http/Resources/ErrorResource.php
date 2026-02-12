<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ErrorResource extends JsonResource
{
    public function __construct(
        public array $data = [],
        public string $message = 'Error',
        public int $status = 400,
        public string $errorCode = '',
        public string $dataKey = 'data',
    ) {}

    public function withResponse($request, $response)
    {
        /**
         * Not all prerequisites were met.
         */
        $response->setStatusCode($this->status);
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            $this->dataKey => $this->data,
            'message' => $this->message,
            'status' => $this->status,
            'error_code' => $this->errorCode,
        ];
    }
}
