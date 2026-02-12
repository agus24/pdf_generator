<?php

namespace App\Jobs;

use App\Enums\PdfJobStatus;
use App\Http\Resources\PdfJobResource;
use App\Models\PdfJob;
use App\services\PdfJobService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class GeneratePdfJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public function __construct(private string $jobId) {}

    public function handle(): void
    {
        $job = PdfJob::find($this->jobId);

        if (!$job) {
            return;
        }

        $job->update(['status' => PdfJobStatus::Processing]);

        $service = new PdfJobService;
        $job = $service->processPdf($job);
        $this->sendCallback($job);
    }

    private function sendCallback(PdfJob $job): void
    {
        if (!$job->callback_url) {
            return;
        }

        $payload = new PdfJobResource($job);
        $payload = $payload->toJson();
        Http::post($job->callback_url, $payload);
    }
}
