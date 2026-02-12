<?php

namespace App\Http\Controllers;

use App\Http\Requests\PdfRenderRequest;
use App\Http\Resources\PdfJobResource;
use App\services\PdfJobService;
use Illuminate\Http\Resources\Json\JsonResource;

class PdfRenderController extends Controller
{
    public function render(PdfRenderRequest $request, PdfJobService $service): JsonResource
    {
        $validated = $request->validated();

        return new PdfJobResource($service->create($validated, $validated['mode']));
    }
}
