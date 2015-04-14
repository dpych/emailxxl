<?php
class Model_SizeerCom extends Model_XML {
    protected $source = 'http://sklep.sizeer.com/comparators/NEW_CENEO.xml';    
    
    public function getDataDetails($id) {
        if($id) {
            return isset($this->_data[$id]) ? $this->_data[$id] : NULL ;
        }
    }
    
}