<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class PdfJobStatus extends Enum
{
    const Pending = 0;
    const Processing = 1;
    const Completed = 2;
    const Failed = 2;
}
