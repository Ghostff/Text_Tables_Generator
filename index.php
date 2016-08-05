<?php

require 'TextTable.php';

$table = new TextTable(2, 3, 2);

$table->config(array('type' => 'html',
//					 'padding' => '+'
			));
			
			
echo $table->put('1,3', 'hey')
		   ->put('1,2', 'what')
		   ->put('1,1', 'sup')
		   ->put('2,1', 'you')

	       ->render();