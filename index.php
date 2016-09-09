<?php

require 'src/TextTable.php';


            
$table = new TextTable(2, 2, 2);
echo $table->put('1,1', 'Foo')
           ->put('1,2', 'Bar')
           ->put('2,1', 'FooBar')->align('R')
           ->put('2,2', 'BarFoo')->align('L')
           ->render();
           
/*file_put_contents('text.log', $table->put('1,1', '12345678')
           ->put('1,3', 'whatdd')
           ->put('2,1', 'am okay you')
           ->put('2,3', 'am comming home today so get ready')

           ->render());*/