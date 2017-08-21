<?php

declare(strict_types=1);

namespace PhpunitCoverageCheck\Format;

interface FormatInterface
{
    public function getName() : string;

    /**
     * @throws FormatException
     */
    public function getCoverage(string $content) : float;
}
