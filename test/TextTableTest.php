<?php

require 'vendor/autoload.php';

class TextTableTest extends PHPUnit_Framework_TestCase 
{
	protected function getMethod($name) {
		
		$class = new ReflectionClass('TextTable');
		$method = $class->getMethod($name);
		$method->setAccessible(true);
		return $method;
	}
	
	public function __call($name, $arg)
	{
		$ref = $this->getMethod($name);
		return $ref->invokeArgs(new TextTable(2, 3, 4), $arg);
	}
	
	public function test_getMax_Return_Max_Of_Two_Numbers()
	{
		$expected = 4;
		$this->assertEquals($expected, $this->getMax(3, 4));
		
		$this->assertEquals($expected, $this->getMax(4, 2));
	}
	
	public function test_makeHead_Return_Top_Border()
	{
		$expected = '-------------';
		$this->assertEquals($expected, $this->makeHead(5));
	}
	
	public function test_makeBody_Return_Column_Content_Blueprint()
	{
		//table blueprint
		$expected = '+%1+%2+%3+<br/>
					(1,1)(1,2)(1,3)|<br/>
					+%1+%2+%3+<br/>
					(2,1)(2,2)(2,3)|<br/>
					+%1+%2+%3+';
					
		$expected = preg_replace('/\s+/', '', $expected);
		
		$this->assertEquals($expected, $this->make());
	}
	
	public function test_buildPrototype_Return_Table_foundation_From_Blueprint()
	{
		//table foundation
		$expected = '+--------+--------+--------+<br/>
					 ~~~~~~~~~~~~~~~~~~~~~~~~~~~|<br/>
					 +--------+--------+--------+<br/>
					 ~~~~~~~~~~~~~~~~~~~~~~~~~~~|<br/>
					 +--------+--------+--------+';
					
		$expected = preg_replace('/\s+/', '', $expected);
		
		$this->assertEquals($expected, $this->buildPrototype());
	}
	
	public function test_render_Return_Built_Table_From_Foundation_Blueprint()
	{
		//table foundation
		$expected = '<code>+--------+--------+--------+<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|<br />+--------+--------+--------+<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|<br />+--------+--------+--------+</code>';
				
		
		$this->assertEquals($expected, $this->render());
	}
}