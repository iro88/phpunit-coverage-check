![Latest Stable Version](https://poser.pugx.org/iro88/phpunit-coverage-check/v/stable)
![Travis CI](https://travis-ci.org/iro88/phpunit-coverage-check.svg?branch=master)

# PHPUnit coverage check tool #

## Installation ##

```bash
composer require --dev iro88/phpunit-coverage-check
```

## Example usage ##

#### Check based on text output ####
```bash
# using stream
set -o pipefail && phpunit | phpunit-coverage-check --format=text 85.00

# ...with verbose mode to see phpunit output
set -o pipefail && phpunit | phpunit-coverage-check --format=text -v 85.00

# or file
phpunit-coverage-check --format=text 85.00 ./path/to/raport.txt
```

#### Check based on Clover XML file ####
```bash
phpunit-coverage-check --format=clover 85.00 ./path/to/clover.xml
```

#### Check based on Html report ####
```bash
phpunit-coverage-check --format=html 85.00 ./path/to/html/index.html
```

#### For more info ####

```bash
phpunit-coverage-check --help
```