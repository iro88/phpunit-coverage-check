<?php

declare(strict_types=1);

namespace PhpunitCoverageCheck\Service;

class ContentProvider
{
    public function getContent(string $filePath = null, bool $verbose = false): string
    {
        if ($filePath) {
            return file_get_contents($filePath);
        }
        return $this->getContentFromStream($verbose);
    }

    protected function getContentFromStream(bool $verbose = false): string
    {
        if($verbose) {
            $content = '';
            while (false !== ($line = fgets(STDIN))) {
                echo $line;
                $content .= $line;
            }
            return $content;
        }
        return stream_get_contents(STDIN);
    }
}
