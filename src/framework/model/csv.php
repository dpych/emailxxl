<?php
abstract class Model_CSV extends Model {

    protected $_data = array();
    protected $_separator = ";";

    public function __construct() {
        $this->loadData();
    }

    public function getData() {
        return $this->_data;
    }
    
    private function loadData() {
        $file = fopen($this->source, "r");
        while( ($data = fgetcsv($file, 0, $this->_separator)) !== FALSE ) {
             $this->_data[] = $data;
        }
    }
}