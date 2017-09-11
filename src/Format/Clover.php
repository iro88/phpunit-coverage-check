<?php

declare(strict_types=1);

namespace PhpunitCoverageCheck\Format;

use Exception;
use SimpleXMLElement;

final class Clover implements FormatInterface
{
    /**
     * @codeCoverageIgnore
     */
    public function getName(): string
    {
        return 'clover';
    }

    public function getCoverage(string $content): float
    {
        $allLines = 0;
        $coveredLines = 0;

        try {
            $xml = new SimpleXMLElement($content);
            foreach ($xml->xpath('//metrics') as $metric) {
                $allLines += $metric['statements'];
                $coveredLines += $metric['coveredstatements'];
            }
        } catch (Exception $e) {
            throw new FormatException($e->getMessage());
        }

        return round(($coveredLines / $allLines) * 100, 2, PHP_ROUND_HALF_DOWN);
    }
}
