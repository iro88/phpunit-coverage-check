<?php

declare(strict_types=1);

namespace PhpunitCoverageCheck\Service;

use PhpunitCoverageCheck\Format\FormatInterface;

class CoverageCheck
{
    /** @var  FormatInterface[] */
    protected $formats;

    public function addFormat(FormatInterface $format): self
    {
        $this->formats[$format->getName()] = $format;

        return $this;
    }

    public function getFormats() : array
    {
        return $this->formats;
    }

    public function getCoverage(string $content, string $format): float
    {
        return $this->formats[$format]->getCoverage($content);
    }
}
