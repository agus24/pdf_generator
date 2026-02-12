<?php

namespace App\Models;

use App\Enums\PdfJobStatus;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class PdfJob extends Model
{
    use HasUuids;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'status',
        'html_content',
        'pdf_url',
        'callback_url',
        'error_message',
    ];

    protected $casts = [
        'status' => PdfJobStatus::class,
    ];
}
