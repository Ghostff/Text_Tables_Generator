<?php


class TextTable
{
	private $col = null;
	
	private $row = null;
	
	private $pad = null;
	
	private $borderd = null;
	
	private $line_type = '<br />';
	
	private $pad_type = '&nbsp;';
	
	private $_cat = '+';
	
	private $_apd = '|';
	
	private $_sep = '-';
	
	private $data = array();
	
	private $last = array();
	
	private $count = array();
	
	private $to_file = false;
	
	public function __construct($row, $col, $padding = 1)
	{
		$this->row = $row;
		$this->col = $col;
		$this->pad = $padding;
	}
	
	public function config($config = array())
	{
		if (array_key_exists('type', $config)) {
			if ($config['type'] == 'file') {
				$this->to_file = true;
				$this->line_type = PHP_EOL;
				$this->pad_type = ' ';
			}
		}
		if (array_key_exists('line', $config)) {
			$this->line_type = $config['line'];	
		}
		
		if (array_key_exists('padding', $config)
			&& trim($config['padding']) != false) {
			
			$this->pad_type = $config['padding'];	
		}
		if (array_key_exists('border', $config)
			&& $config['border'] > 0) {
				$this->borderd = ' ';
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
		$limit += $this->pad * 2;
		return str_repeat($this->_sep, $limit);
	}
	
	private function makeBody($string = '', $length, $used)
	{
		$length += $this->pad * 2;
		unset($this->count[$used]);
		if ($string) {
			return $this->_apd
				   . str_pad($string, $length, '~', STR_PAD_BOTH);
		}
		return '~' . str_pad($string, $length, '~', STR_PAD_BOTH);
	}
	
	private function getSize($data)
	{
		$current = preg_replace('/\d+[,]/', "%", $data);
		$current = str_replace(array('(', ')'), '', $current);
		if (array_key_exists($current, $this->last)){
			return $this->last[$current];
		}
	}

	
	private function buildPrototype()
	{
		$init = $this->make();
		$i = 1;
		$looped = array();
		foreach ($this->data as $keys => $count) {
			(int) $key = rtrim(ltrim(strstr($keys, ','), ','), ')');
			
			if ($key == $i) {
				$size = strlen($count);
				
				if (array_key_exists('%' . $i, $looped)) {
					$looped['%' . $i] = $this->getMax($looped['%' . $i],
											$size
										);
				}
				else {
					$looped['%' . $i] = strlen($count);	
				}
			}
			if ($i == $this->col) {
				$i = 0;	
			}
			$i++;
		}
		$this->last = $looped;
		$init = str_replace(array_keys($looped), array_map(
									array($this, 'makeHead'),
									array_values($looped)), $init
							);
							
		$init = str_replace(
					array_keys($this->data),
					array_map(array($this, 'makeBody'),
							array_values($this->data),
							array_map(array($this, 'getSize'),
								array_keys($this->data)),
								array_keys($this->data)), $init
					);
				
		$init = str_replace(
					array_keys($this->count),
					array_map(array($this, 'makeBody'),
						array_values($this->count),
							array_map(array($this, 'getSize'),
							array_keys($this->count)),
							array_keys($this->count)), $init
					);
		return $init;
	
	}
	
	private function make()
	{
		$inj = $data = null;
		$data_map = array();
		
		for ($c = 1; $c <= $this->row; $c++) {
			$last = $data = null;
			for ($i = 1; $i <= $this->col; $i++) {
				$last .= $this->_cat  . '%' . $i;
				$inj .= $this->_cat  . '%' . $i;
				$data .= '(' . $c . ',' . $i . ')';
				$this->count['(' . $c . ',' . $i . ')'] = '';
				if ( ! isset($this->data['(' . $c . ',' . $i . ')'])) {
					$data_map['(' . $c . ',' . $i . ')'] = 
						$this->borderd;
				}
				else {
					$data_map['(' . $c . ',' . $i . ')'] =
						$this->data['(' . $c . ',' . $i . ')'];
				}
			}
			$inj .= $this->_cat . '<br/>';
			$inj .= $data . $this->_apd . '<br/>';
		}
		$this->data = $data_map;
		$inj .= $last . $this->_cat;
		return $inj;
	}

	public function render()
	{	
		$data = $this->buildPrototype();
		
		if ($this->line_type) {
			$data = str_replace('<br/>', $this->line_type, $data);
		}
		if ($this->pad_type) {
			$data = preg_replace('#(?<!/)~#', $this->pad_type, $data);
			$data = str_replace('/~', $this->pad_type . '~', $data);
		}
		if ($this->to_file) {
			return $data . $this->pad_type;
		}
		return '<code>' . $data . $this->pad_type . '</code>';
	}
	
	public function put($row_col, $data)
	{
		list($row, $col) = explode(',', $row_col);
		(int) $row = trim($row);
		(int) $col = trim($col);
		if ($row > $this->row) {
			die('Selected Row('.$row.') was not initialized');
		}
		elseif ($col > $this->col) {
			die('Selected Column('.$col.') was not initialized');
		}
		else {
			$this->data['(' . $row_col . ')'] = $data;
			$this->count++;
			return $this;
		}
	}
}