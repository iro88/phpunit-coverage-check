# PHPUnit coverage check tool #

## Installation ##

```
composer require --dev iro88/phpunit-coverage-check
composer update
```

## Usage ##

```
./bin/phpunit-coverage-check --help
```

### Check based on text output ###
```
phpunit | ./bin/phpunit-coverage-check --format=text 85.00
```
or
```
./bin/phpunit-coverage-check --format=text 85.00 ./path/to/raport.txt
```

### Check based on Clover XML file ###
```
./bin/phpunit-coverage-check --format=clover 85.00 ./path/to/clover.xml
```

### Check based on Html report ###
```
./bin/phpunit-coverage-check --format=clover 85.00 ./path/to/html/index.html
```
