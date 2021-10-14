<?php

declare(strict_types=1);

namespace App\Extractor;

interface DataExtractorInterface
{
    public function extract(): array;
}