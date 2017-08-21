<?php

declare(strict_types=1);

namespace PhpunitCoverageCheck\Format;

use SimpleXMLElement;

/**
 * @codeCoverageIgnore
 */
final class Clover implements FormatInterface
{
    public function getName(): string
    {
        return 'clover';
    }

    public function getCoverage(string $content): float
    {
        $allLines = 0;
        $coveredLines = 0;

        $xml = new SimpleXMLElement($content);
        foreach ($xml->xpath('//metrics') as $metric) {
            $allLines += $metric['statements'];
            $coveredLines += $metric['coveredstatements'];
        }

        return round(($coveredLines / $allLines) * 100, 2, PHP_ROUND_HALF_DOWN);
    }
}
