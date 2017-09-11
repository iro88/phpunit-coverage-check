<?php

declare(strict_types=1);

namespace PhpunitCoverageCheck\Format;

use PHPUnit\Framework\TestCase;

final class CloverTest extends TestCase
{
    /**
     * @test
     */
    public function return_percent_value_from_valid_report()
    {
        $format = new Clover();
        $content = file_get_contents(__DIR__ . '/sample/clover.xml');

        $this->assertEquals(77.78, $format->getCoverage($content));
    }

    /**
     * @test
     */
    public function throw_exception_when_invalid_report()
    {
        $format = new Clover();
        $content = file_get_contents(__DIR__ . '/sample/invalid-file');

        $this->expectException(FormatException::class);

        $format->getCoverage($content);
    }
}
