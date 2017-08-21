<?php

declare(strict_types=1);

namespace PhpunitCoverageCheck\Format;

/**
 * @codeCoverageIgnore
 */
final class Text implements FormatInterface
{
    public function getName(): string
    {
        return 'text';
    }

    public function getCoverage(string $content): float
    {
        $matches = [];
        $lines = explode("\n", $content);
        foreach ($lines as $line) {
            if(preg_match('#Lines:\s+(?<percent>[\d\.]+)%#', $line, $matches)) {
                return (float) $matches['percent'];
            }
        }
        throw new FormatException('No found value');
    }
}
