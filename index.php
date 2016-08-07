<?php

require 'TextTable.php';

$table = new TextTable(2, 3, 1);

$table->config(array(
//                     'type'        => 'html',
                     'border'    => 1,
//                     'padding'    => '',
//                     'line'        => "<p />",
            ));
            
            
echo $table->put('1,1', '12345678')
           ->put('1,3', 'whatdd')
           ->put('2,1', 'am okay you')
           ->put('2,3', 'am comming home today so get ready')

           ->render();
           
/*file_put_contents('text.log', $table->put('1,1', '12345678')
           ->put('1,3', 'whatdd')
           ->put('2,1', 'am okay you')
           ->put('2,3', 'am comming home today so get ready')

           ->render());*/