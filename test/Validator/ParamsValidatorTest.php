<?php

declare(strict_types=1);

namespace PhpunitCoverageCheck\Service;

use PHPUnit\Framework\TestCase;
use PhpunitCoverageCheck\Validator\ParamsValidator;

final class ParamsValidatorTest extends TestCase
{
    /**
     * @test
     */
    public function validateFile_returns_true_when_file_is_null()
    {
        $validator = new ParamsValidator();

        $this->assertTrue($validator->validateFile(null));
    }

    /**
     * @test
     */
    public function validateFile_returns_true_when_file_exists()
    {
        $validator = new ParamsValidator();

        $this->assertTrue($validator->validateFile(__DIR__ . '/ParamsValidatorTest.php'));
    }

    /**
     * @test
     */
    public function validateFile_returns_false_when_file_not_exists()
    {
        $validator = new ParamsValidator();

        $this->assertFalse($validator->validateFile('/asdf.fdsa'));
    }

    /**
     * @test
     */
    public function validateFormat_returns_true_when_is_supported()
    {
        $supportedFormats = ['clover', 'html', 'text'];
        $validator = new ParamsValidator();

        $this->assertTrue($validator->validateFormat('html', $supportedFormats));
    }

    /**
     * @test
     */
    public function validateFormat_returns_false_when_is_supported()
    {
        $supportedFormats = ['clover', 'html', 'text'];
        $validator = new ParamsValidator();

        $this->assertFalse($validator->validateFormat('not_supported_format', $supportedFormats));
    }

    /**
     * @test
     * @dataProvider validPercent()
     */
    public function validatePercent_returns_true_when_percent_is_number_between_0_100($percent)
    {
        $validator = new ParamsValidator();

        $this->assertTrue($validator->validatePercent($percent));
    }

    public function validPercent(): array
    {
        return [
            'lowest value'  => ['0'],
            'float value'   => ['1.00'],
            'more decimals' => ['50.23456'],
            'highest value' => ['100'],
        ];
    }

    /**
     * @test
     * @dataProvider invalidPercent()
     */
    public function validatePercent_returns_false_when_percent_is_not_number_between_0_100($percent)
    {
        $validator = new ParamsValidator();

        $this->assertFalse($validator->validatePercent($percent));
    }

    public function invalidPercent(): array
    {
        return [
            'negative value'    => ['-1'],
            'over scope value'  => ['100.01'],
            'not numeric value' => ['abcd'],
            'empty value'       => [''],
        ];
    }
}
