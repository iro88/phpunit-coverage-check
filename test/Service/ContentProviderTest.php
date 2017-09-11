<?php

declare(strict_types=1);

namespace PhpunitCoverageCheck\Service;

use PHPUnit\Framework\TestCase;

// native PHP functions mocks
{
    // simulate for expect
    function file_get_contents() {
        return 'file_get_contents() was run';
    }

    // simulate for expect
    function stream_get_contents() {
        return 'stream_get_contents() was run';
    }

    // simulate fgets() behaviour
    $fgetsLine = 0;
    function fgets() {
        global $fgetsLine;
        $lines = ["test", false];

        return $lines[$fgetsLine++];
    }
}

final class ContentProviderTest extends TestCase
{
    /**
     * @test
     */
    public function get_content_from_file_when_file_given()
    {
        $contentProvider = new ContentProvider();

        $this->assertEquals(
            'file_get_contents() was run',
            $contentProvider->getContent('path/to/file')
        );
    }

    /**
     * @test
     */
    public function get_content_from_stream_when_file_not_given()
    {
        $contentProvider = new ContentProvider();

        $this->assertEquals(
            'stream_get_contents() was run',
            $contentProvider->getContent()
        );
    }

    /**
     * @test
     */
    public function output_string_when_verbose()
    {
        $contentProvider = new ContentProvider();

        $this->expectOutputString('test');

        $contentProvider->getContent(null, true);
    }
}