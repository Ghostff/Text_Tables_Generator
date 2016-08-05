<?php


class TextTable
{
	private $col = array();
	
	private $row = array();
	
	private $colC = null;
	
	private $rowC = null;
	
	private $pad = null;
	
	private $_cat = '+';
	
	private $_apd = '|';
	
	private $_sep = '-';
	
	private $row_col = null;
	
	private $data = array();
	
	private $looped = null;
	
	private $line_type = null;
	
	private $pad_type = null;
	
	private $widths = array();
	
	private $count = 1;
	
	public function __construct($row, $col, $padding = 1)
	{
		$this->rowC = $row;
		$this->colC = $col;
		$this->pad = $padding;
	}
	
	public function config($config = array())
	{
		if (array_key_exists('type', $config)) {
			if (in_array($config['type'], array('html', 'HTML'))) {
				$this->line_type = '<br />';
				$this->pad_type = '&nbsp;';
			}
			elseif (in_array($config['type'], array('log', 'file'))) {
				$this->line_type = PHP_EOL;
				$this->pad_type = ' ';
			}
		}
		if (array_key_exists('line', $config)) {
			$this->line_type = $config['line'];	
		}
		
		if (array_key_exists('padding', $config)) {
			$this->pad_type = $config['padding'];	
		}
	}
	
	private function getMax($last, $new)
	{
		if ($new > $last) {
			$last = $new;	
		}
		return $last;
	}
	
	private function makeHead($limit)
	{
		return str_repeat($this->_sep, $limit);
	}
	
	private function makeBody($string, $length)
	{
		return str_pad($string, $length, '~', STR_PAD_BOTH);
	}
	
	private function buildPrototype($row, $col)
	{
		$built = $top = null;
		for ($c = 1; $c <= $this->rowC; $c++) {
			for ($i = 1; $i <= $this->colC; $i++) {
				if (isset($this->data[$c . ',' . $i])) {
					$data = $this->data[$c . ',' . $i];
					$length = strlen($data);
					if ($this->pad > 0 ) {
						$length += $this->pad * 2;	
					}
					$top .= $this->_cat . $this->makeHead($length);
					$built .= $this->_apd . $this->makeBody($data, $length);
					
					var_dump($i . ' ' . $this->colC);
					if ($i == $this->colC) {
						$built = $top . $this->_cat . '<br/>' . $built . $this->_apd ;
						$top = null;
						
					}
				}
			}
		}
		return $built;
	}
	
	private function make($built)
	{
		$made = null;
		for ($c = 1; $c <= $this->rowC; $c++) {
			for ($i = 1; $i <= $this->colC; $i++) {
				$made .= $this->_apd . '[' . $c . 'x' . $i . ']';
			}
		}
		
		//var_dump($made);
	}
	
	private function loop()
	{
		$this->looped = $this->buildPrototype($this->row, $this->col);
	}
	
	public function render()
	{
		$this->loop();
		
		$data = $this->looped;
		if ($this->line_type) {
			$data = str_replace('<br/>', $this->line_type, $data);
		}
		if ($this->pad_type) {
			$data = preg_replace('#(?<!/)~#', $this->pad_type, $data);
		}
		return '<code>' . $data . '</code>';
	}
	
	public function put($row_col, $data)
	{
		list($row, $col) = explode(',', $row_col);
		(int) $row = trim($row);
		(int) $col = trim($col);
		if ($row > $this->rowC) {
			die('The Row you are trying modify does not exists <br />
				Total Table Rows: (' . $this->rowC . ')<br />
				Selected Row: (' . $row . ')'
			);
		}
		elseif ($col > $this->colC) {
			die('The Column you are trying modify does not exists <br />
				Total Table Columns: (' . $this->colC . ')<br />
				Selected Column: (' . $col . ')'
			);
		}
		else {
			$this->row[$this->count] = $row;
			$this->col[$this->count] = $col;
			$this->data[$row_col] = $data;
			$this->count++;
			return $this;
		}
	}
}