<?php

declare(strict_types=1);

namespace PhpunitCoverageCheck\Format;

use DOMDocument;
use DOMXPath;

/**
 * @codeCoverageIgnore
 */
final class Html implements FormatInterface
{
    public function getName(): string
    {
        return 'html';
    }

    public function getCoverage(string $content): float
    {
        $dom = new DomDocument();
        @$dom->loadHTML($content); // cause '<!DOCTYPE html>'
        $xpath = '/html/body/div/table/tbody/tr[1]/td[3]/div';

        $elements = (new DomXPath($dom))->query($xpath);
        if ($elements->length === 1) {
            return (float) $elements->item(0)->textContent;
        }
        throw new FormatException(
            "Oops, coverage not found.\nProbably you give wrong file, html format needs 'index.html'."
        );
    }
}
