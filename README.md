# Text_Tables_Generator

Initialize:
   @param Row size
   @param Column size
   @param word padding default: 1
```php
$table = new TextTable(2, 2, 2);
```

Table Configuration:
type: html/file (used for table displayed in browser/for table that will be writen to a file)
border: allows assings border to initialized rows and columns
padding: character used for padding specified string.
            eg: if padding is '+' all white spaces in string will be replaced with '+'
                +--------------+                         +--------------+
                |     r1,c1    | will be replaced with   |+++++r1,c1++++| default: ' '              
                +--------------+                         +--------------+             
line: for new line default: ```php '<br />' ```

```php
$table->config(array('type'     => 'html',
                     'border'   => 1,
                     'padding'  => '',
                     'line'     => "<p />",
            ));
```

Put:
  @param string: row,column
  @param string|int: data
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
