# PHP Text Tables Generator  [Documentation](http://ghostff.com/library/php/Text_Tables_Generator)
Generates a plain text table, which can be copied or writen into any text file, And in some cases rendered to a browser output

[![Build Status](https://travis-ci.org/Ghostff/Text_Tables_Generator.svg?branch=travis)](https://travis-ci.org/Ghostff/Text_Tables_Generator) [![Latest Stable Version](https://img.shields.io/badge/release-v1.0.0-brightgreen.svg)](https://github.com/Ghostff/Text_Tables_Generator/releases) ![License](https://img.shields.io/packagist/l/gomoob/php-pushwoosh.svg) [![Latest Stable Version](https://img.shields.io/badge/packagist-v5.5.4-blue.svg)](https://packagist.org/packages/ghostff/text-tables-generator) [![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%205.3-8892BF.svg)](https://php.net/)
----------

#Installation   
You can download the  Latest [release version ](https://github.com/Ghostff/Text_Tables_Generator/releases/) as a standalone, alternatively you can use [Composer](https://getcomposer.org/) 
```json
$ composer require ghostff/text-tables-generator
```    
Or add:
```json
{
    "require": {
        "ghostff/text-tables-generator": "^1.0"
    }
}
```
to your ``composer.json``


Demo
```php

$table = new TextTable(2, 2, 2);
$table->config(array('border' => true));
echo $table->put('1,1', 'row 1, col 2')->align('L')
           ->put('1,2', 'row 1, col 2')
           ->put('2,1', 'row 2, col 2')->align('L')
           ->put('2,2', 'row 2, col 2')
           ->render();
```
Outputs
```php
+----------------+----------------+
|row 1, col 2    |  row 1, col 2  |
+----------------+----------------+
|row 2, col 2    |  row 2, col 2  |
+----------------+----------------+ 

```