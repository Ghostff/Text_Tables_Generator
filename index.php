<?php

require 'TextTable.php';

$table = new TextTable(2, 2, 2);

$table->config(array('type'     => 'html',
                     'border'   => 1,
//                   'padding'  => '',
//                   'line'     => "<p />",
            ));
            
            
echo $table->put('1,1', 'row 1, col 2')->align('L')
           ->put('1,2', 'row 1, col 2')
           ->put('2,1', 'row 2, col 2')->align('L')
           ->put('2,2', 'row 2, col 2')
           ->render();
           
/*file_put_contents('text.log', $table->put('1,1', '12345678')
           ->put('1,3', 'whatdd')
           ->put('2,1', 'am okay you')
           ->put('2,3', 'am comming home today so get ready')

           ->render());*/