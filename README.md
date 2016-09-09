# PHP Text Tables Generator

[![Build Status](https://travis-ci.org/Ghostff/Text_Tables_Generator.svg?branch=travis)](https://travis-ci.org/Ghostff/Text_Tables_Generator)

----------

#Installation   
You can download the  Latest [release version ](https://github.com/Ghostff/Text_Tables_Generator/releases/) as a standalone, alternatively you can use [Composer](https://getcomposer.org/) for optional dependencies such as PHPUnit.
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

--------
**Initialize**:  
   ```@param``` Row size  
  ```@param``` Column size  
   ```@param``` word padding default: 1
```php
$table = new TextTable(2, 2, 2);
```

**Table Configuration**:  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Keys:  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;```type```: html/file (used for table displayed in browser or for table(text) that will be writen to a file)  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;```border```: Assigns right border to initialized rows and colum(including empty columns)
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;```padding```: Character used for padding specified string.  
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Eg: If padding is ```'+'``` all white spaces in string will be replaced with ```'+'```   
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;So ```| r1,c1 | ``` will be replaced with  ```|+r1,c1+|``` default: ```' '```              
           
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;```line```: For new line default: ```<br />```

```php
$table->config(array('type'     => 'html',
                     'border'   => 1,
                     'padding'  => '',
                     'line'     => "<p />",
            ));
```

**Put**:   
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;```@param``` string: row,column   
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;```@param``` string|int: data
```php
echo $table->put('$row,$column', '$data')->render();
```
**align**:  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;```@param``` string: L(left) | R(right) default:(middle)

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
 
