<?php

declare(strict_types=1);

namespace PhpunitCoverageCheck\Validator;

class ParamsValidator
{
    public function validateFile(string $filePath = null): bool
    {
        if ($filePath) {
            return file_exists($filePath);
        }
        return true;
    }

    public function validateFormat(string $format, array $formats): bool
    {
        return in_array($format, $formats);
    }

    public function validatePercent(string $percent): bool
    {
        if (is_numeric($percent)) {
            return $percent >= 0 && $percent <= 100;
        }
        return false;
    }
}
