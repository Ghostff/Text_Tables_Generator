# PHP Text Tables Generator

Initialize:  
   ```@param``` Row size  
  ```@param``` Column size  
   ```@param``` word padding default: 1
```php
$table = new TextTable(2, 2, 2);
```

Table Configuration:  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Keys:  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;```type```: html/file (used for table displayed in browser/for table that will be writen to a file)  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;```border```: Allows assings border to initialized rows and columns  
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

Put:   
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;```@param``` string: row,column   
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;```@param``` string|int: data
```php
echo $table->put('1,1', 'row 1, col 1')
           ->put('1,2', 'row 1, col 2')
           ->put('2,1', 'row 2, col 2')
           ->put('2,2', 'row 2, col 2')
           ->render();

```

Demo
```php
require 'TextTable.php';
$table = new TextTable(2, 2, 1);
$table->config(array('border' => 1));
echo $table->put('1,1', 'row 1, col 1')
           ->put('1,2', 'row 1, col 2')
           ->put('2,1', 'row 2, col 2')
           ->put('2,2', 'row 2, col 2')
           ->render();
```
Outputs
```php

+--------------+--------------+
| row 1, col 1 | row 1, col 2 |
+--------------+--------------+
| row 2, col 2 | row 2, col 2 |
+--------------+--------------+ 

```
