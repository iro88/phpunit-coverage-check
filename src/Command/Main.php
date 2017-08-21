<?php

declare(strict_types=1);

namespace PhpunitCoverageCheck\Command;

use PhpunitCoverageCheck\Service\CoverageCheck;
use PhpunitCoverageCheck\Validator\ParamsValidator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @codeCoverageIgnore
 */
class Main extends Command
{
    const NAME = 'phpunit-coverage-check';
    const DESCRIPTION = '';

    const ARG_FILE = 'file';
    const ARG_PERCENT = 'percent';
    const OPT_FORMAT = 'format';
    const OPT_FORMAT_SHORT = 'f';

    private $validator;
    private $service;

    public function __construct(ParamsValidator $validator, CoverageCheck $service)
    {
        $this->validator = $validator;
        $this->service = $service;

        parent::__construct();
    }

    protected function configure()
    {
        $this->setName(self::NAME)
            ->setHelp(self::DESCRIPTION)
            ->addOption(
                self::OPT_FORMAT,
                self::OPT_FORMAT_SHORT,
                InputOption::VALUE_REQUIRED,
                "Supported formats: '" . implode("','", $this->getSupportedFormats()) . "'"
            )
            ->addArgument(
                self::ARG_PERCENT,
                InputArgument::REQUIRED,
                'Percent threshold'
            )
            ->addArgument(
                self::ARG_FILE,
                InputArgument::OPTIONAL,
                'Path to file with coverage report source (not required if you passing content by stream)'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->validate($input);

        $percentActual = $this->service->getCoverage(
            $this->getContent($input),
            $input->getOption(self::OPT_FORMAT)
        );

        $percentThreshold = $input->getArgument(self::ARG_PERCENT);
        if ($percentActual >= $percentThreshold) {
            $output->writeln("Code coverage is {$percentActual}% - OK!");
            return 0;
        }
        $output->writeln("Code coverage is {$percentActual}%, which is below the accepted {$percentThreshold}%");
        return 1;
    }

    private function validate(InputInterface $input)
    {
        $filePath = $input->getArgument(self::ARG_FILE);
        if (!$this->validator->validateFile($filePath)) {
            throw new RuntimeException("File not found '{$filePath}'");
        }

        $percent = $input->getArgument(self::ARG_PERCENT);
        if(!$this->validator->validatePercent($percent)) {
            throw new RuntimeException("Percent value '{$percent}' is not number in range from 0 to 100");
        }

        $format = $input->getOption(self::OPT_FORMAT);
        if (!$this->validator->validateFormat($format, $this->getSupportedFormats())) {
            throw new RuntimeException("Unsupported format '{$format}'");
        }
    }

    private function getSupportedFormats() : array
    {
        return array_keys($this->service->getFormats());
    }

    private function getContent(InputInterface $input): string
    {
        $filePath = $input->getArgument(self::ARG_FILE);
        if ($filePath) {
            return file_get_contents($filePath);
        }
        return file_get_contents("php://stdin");
    }
}
