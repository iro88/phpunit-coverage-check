<?php

declare(strict_types=1);

namespace PhpunitCoverageCheck\Service;

use PHPUnit\Framework\TestCase;
use PhpunitCoverageCheck\Format\FormatInterface;

final class CoverageCheckTest extends TestCase
{
    /**
     * @test
     */
    public function addFormat_complete_collection_of_formats()
    {
        $service = new CoverageCheck();
        $format = $this->createMock(FormatInterface::class);
        $format->method('getName')->willReturn('format_name');

        $service->addFormat($format);

        $this->assertContains($format, $service->getFormats());
    }

    /**
     * @test
     */
    public function getCoverage_invoke_method_of_specified_format()
    {
        $service = new CoverageCheck();
        $format = $this->createMock(FormatInterface::class);
        $format->method('getName')->willReturn('format_name');

        $format2 = $this->createMock(FormatInterface::class);
        $format2->method('getName')->willReturn('other_format_name');

        $service->addFormat($format);
        $service->addFormat($format2);

        $format
            ->expects($this->atLeastOnce())
            ->method('getCoverage');
        $format2
            ->expects($this->never())
            ->method('getCoverage');

        $service->getCoverage('', 'format_name');
    }
}