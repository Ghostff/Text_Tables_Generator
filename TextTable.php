<?php


class TextTable
{
    /**
    * holds the number of columns that will be generated
    * default: 0
    * 
    * 
    */
    private $col = null;
    
    /**
    * holds the number of rows that will be generated
    * default: 0
    * 
    * 
    */
    private $row = null;
        
    /**
    * int of string padding value value
    * default: 1
    * 
    * holds the padding lenght for each column.
    * if padding is = 2, it allows double empty space between
    * identified string.
    *
    * Example if
    *    Padding: 2
    *    giving string: 'Foobar'
    *
    * the output of this should be '__Foobar__' where '_' is the space
    */
    private $pad = null;
    
    /**
    * int(0|1) or bool of border
    * default: false
    * 
    * Due to '|' is prepended to string in each column
    * which mean if no string or if the column is empty
    * there will be no '|', thus leaving instances like:
    *
    * +---+
    *     | for any empty column
    * +---+
    *
    * this is why we came up with bordered property, which toggles
    * between border or no-border.
    * when set to true or 1 it adds the missing '|'. making something like:
    *
    * +---+
    * |   | even tho its empty
    * +---+
    * 
    */
    private $borderd = null;
    
    /**
    * string of new line character
    * default: <br />
    *
    * holds new line character specification 
    *
    * allow you to use a different line break
    * like <p/> which gives more spacing between new line
    * 
    */
    private $line_type = '<br />';
    
    /**
    * string of padding replacement
    * default: space(' ')
    * 
    * Due to html not ignoring multiple empty spacings meanwhile
    * files does (for those who are intrested in writing the generated
    * table into a file) we decided to use the characted '~' to pad the strings
    * thus if padding is 2 and string is 'Foo', we will end up having '~~Foo~~'
    *
    * Note any string with '~' must be excaped.
    * because strings like 'F~oo' will be treated as 'F(x)oo'
    * where (x) is the padding type.
    *
    * getting back in track this property replaces you padding with any
    * specification
    * so if 
    * pad_type: '!' or '*'
    * string is: 'Foo'
    * pad:         2
    * Result: '!!Foo!!' or '**Foo**'
    *
    */
    private $pad_type = '&nbsp;';
    
    /**
    * joiner
    * default: +
    */
    private $_cat = '+';
    /**
    * joiner
    * default: +
    */
    private $_apd = '|';
    /**
    * padder
    * default: +
    */
    private $_sep = '-';
    
    private $data = array();
    
    private $last = array();
    
    private $count = array();
    
    private $pad_flag = array();
    
    private $to_file = false;
    
    public function __construct($row, $col, $padding = 1)
    {
        $this->row = $row;
        $this->col = $col;
        $this->pad = $padding;
    }
    
    /**
    * get the max of numbers
    *
    * return int
    *
    * @param int of fisrt number
    * @param int of second number
    */
    private function getMax($last, $new)
    {
        if ($new > $last) {
            $last = $new;    
        }
        return $last;
    }
    
    /**
    * makes top or bottom border
    * repeats selected _sep property to the number
    * of specified limit
    *
    * eg if limit: 5
    * output +'xxxxx'+ where 'x' is the _sep property and
    * '+' is the _cat property
    *
    * return string
    *
    * @param string of border width
    */
    private function makeHead($limit)
    {
        $limit += $this->pad * 2;
        return str_repeat($this->_sep, $limit);
    }
    
    /**
    * replace column string array key with data array and also adds
    * text padding is pad property is not 0.
    *
    * So if string (1,2), it replaces it with padded(if set) data
    * property value where key is (1,2)
    *
    * return string
    *
    * @param string|null os string to pad(prepends '|')
    * @param int padding length
    * @param used key
    */
    private function makeBody($string = '', $length, $used)
    {
        $length += $this->pad * 2;
        unset($this->count[$used]);
        
        if (isset($this->pad_flag[$used])) {
            $flag = $this->pad_flag[$used];
            if ($flag == 'L') {
                $flag = 'STR_PAD_RIGHT';
            }
            elseif ($flag == 'R') {
                $flag = 'STR_PAD_LEFT';
            }
            else {
                $flag = 'STR_PAD_BOTH';
            }
        }
        else {
            $flag = 'STR_PAD_BOTH';
        }

        if ($string) {
            return $this->_apd
                   . str_pad($string, $length, '~', constant($flag));
        }
        return '~' . str_pad($string, $length, '~', constant($flag));
    }
    
    /**
    *
    * determines the column with the longest width and forces
    * all the columns that fall under or above it to use that width

    * return string
    *
    * @param string of current column data
    */
    private function getSize($data)
    {
        $current = preg_replace('/\d+[,]/', "%", $data);
        $current = str_replace(array('(', ')'), '', $current);
        if (array_key_exists($current, $this->last)){
            return $this->last[$current];
        }
    }
    
    /**
    * makes table blueprint
    *
    * return string of blue print
    */
    private function make()
    {
        $inj = null;
        $data_map = array();
        
        for ($c = 1; $c <= $this->row; $c++) {
            
            $last = null;
            $data = null;
            
            for ($i = 1; $i <= $this->col; $i++) {
                
                $last .= $this->_cat  . '%' . $i;
                $inj .= $this->_cat  . '%' . $i;
                $key = '(' . $c . ',' . $i . ')';
                $data .= $key;
                $this->count[$key] = '';
                
                if ( !isset($this->data[$key]) || trim($this->data[$key]) == false) {
                    $data_map[$key] = $this->borderd;
                }
                else {
                    $data_map[$key] = $this->data[$key];
                }
            }
            
            $inj .= $this->_cat . '<br/>';
            $inj .= $data . $this->_apd . '<br/>';
        }
        $this->data = $data_map;
        $inj .= $last . $this->_cat;
        return $inj;
    }
    
    /**
    * build table blueprint
    * eg: converts +%1+ to +----+
    * where '%' is the pad repeater(according to string length)
    *
    * return string built blueprint
    */
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
                    $looped['%' . $i] = $this->getMax($looped['%' . $i], $size);
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
        
        //replaces +%1+<br/> with  +----+<br/>
        $init = str_replace(array_keys($looped), array_map(
            array($this, 'makeHead'),
            array_values($looped)), $init
        );
        
        //replaces (1,1) with |data            
        $init = str_replace(
            array_keys($this->data),
            array_map(
                array($this, 'makeBody'),
                array_values($this->data),
                array_map(
                    array($this, 'getSize'),
                    array_keys($this->data)
                ),
                array_keys($this->data)
            ), 
            $init
        );
        
       //replaces xxxx with with the max of lenght.      
        $init = str_replace(
            array_keys($this->count),
            array_map(
                array($this, 'makeBody'),
                array_values($this->count),
                array_map(
                    array($this, 'getSize'),
                    array_keys($this->count)
                ),
                array_keys($this->count)
            ), 
            $init
        );
        
        return $init;
    
    }
    
    /**
    * redefine predefined properties
    * return null
    *
    * @param array of property replacements
    */
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
        
        if (array_key_exists('padding', $config) && trim($config['padding']) != false) {
            $this->pad_type = $config['padding'];    
        }
        
        if (array_key_exists('border', $config) && $config['border'] == true) {
            $this->borderd = ' ';
        }
    }
    
    /**
    * renders table to a specific format(html or file)
    * file: 
    *    replaces <br /> with PHP_EOL and &nbsp; with space(' ')
    *
    * return file: raw string
    *         html: code tagged string
    */
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
            return $data;
        }
        
        return '<code>' . $data . '</code>';
    }
    
    /**
    * sets the string position of current data
    *
    * return object
    *
    * @param postion
    */
    public function align($position)
    {
        $key = array_keys($this->data);
        $key = end($key);
        
        $this->pad_flag[$key] = $position;
        return $this;
    }
    
    /**
    * assigns a varibale to a particular column and row
    *
    * return object
    *
    * @param string row and column ('1,2' puts data in row one column 2)
    * @parama mixed of date to store in selected row and column
    */
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