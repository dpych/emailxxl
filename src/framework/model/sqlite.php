<?php
abstract class Model_Sqlite extends Model {
    protected $source = SQLITE;
    protected $_data;
    protected $_table;
    protected $_schemat;
    
    public function __construct() {
        $this->_data = new SQLite3($this->source);
        if ( (bool) $this->_schemat ) {
            $this->createTable();
        }
        return $this;
    }

    abstract public function getData();
    
    private function createTable() {
        $this->_data->exec($this->_schemat);
    }
}
