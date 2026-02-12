<?php

namespace App\services;

use App\Enums\PdfJobStatus;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Jobs\GeneratePdfJob;
use App\Models\PdfJob;
use Exception;
use Illuminate\Support\Facades\Storage;

class PdfJobService
{
    public function create(array $data, string $mode): PdfJob
    {
        $job = PdfJob::create([
            'status' => PdfJobStatus::Pending,
            'html_content' => $data['html'],
            'callback_url' => $data['callback_url'] ?? null,
        ]);

        if ($mode == 'sync') {
            return $this->processPdf($job);
        }

        GeneratePdfJob::dispatch($job->id);

        return $job;
    }

    public function processPdf(PdfJob $job): PdfJob
    {
        try {
            $pdf = Pdf::loadHTML($job->html_content)->output();
            $s3Paths = "pdfs/{$job->id}.pdf";
            Storage::disk('s3')->put($s3Paths, $pdf);

            $pdfUrl = Storage::disk('s3')->url($s3Paths);

            $job->update([
                'status' => PdfJobStatus::Completed,
                'pdf_url' => $pdfUrl,
            ]);

            $job->refresh();
        } catch (Exception $e) {
            $job->update([
                'status' => PdfJobStatus::Failed,
                'error_message' => $e->getMessage(),
            ]);
        } finally {
            return $job;
        }
    }
}
