<?php
class Model_SizeerCom extends Model_XML {
    protected $source = 'http://sklep.sizeer.com/comparators/NEW_CENEO.xml';    
    
    public function __construct() {
        $this->loadData();
    }
    
    public function getDataDetails($id) {
        if($id) {
            return isset($this->_data[$id]) ? $this->_data[$id] : NULL ;
        }
    }
    
    private function getProductNo($attrs) {
        foreach($attrs as $attr) {
            if($attr->name == 'ProductNo') {
                return $attr->value;
            }
        }
        return NULL;
    }
    
    private function loadData() {
        $this->_reader = new XMLReader();
        $this->_reader->open($this->source);
        
        while($this->_reader->read()) {
            if($this->_reader->nodeType == XMLReader::ELEMENT && $this->_reader->name == $this->_offset)
            {
                $doc = new DOMDocument('1.0', 'UTF-8');
                $element = simplexml_import_dom($doc->importNode($this->_reader->expand(),true));
                $id = $this->getProductNo($element->attributes->attribute);
                $this->_data[trim($id)] = $element;
            }
        }
    }
}