<?php
abstract class Model_Sqlite extends Model {
    protected $source = SQLITE;
    protected $_data;
    protected $_table;
    protected $_schemat;
    
    public function __construct() {
        $this->_data = new SQLite3($this->source);
        return $this;
    }

    abstract public function getData() {
        echo 'dziala';
    }
}
