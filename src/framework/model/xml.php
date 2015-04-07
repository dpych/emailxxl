<?php
abstract class Model_XML extends Model {
    protected $_data = array();
    protected $_reader = NULL;
    protected $_offset = 'offer';
    
    public function __construct() {
        $this->loadData();
    }
    
    public function getData() {
        return $this->_data;
    }

    public function getDataDetails($id) {
        if($id) {
            return isset($this->_data[$id]) ? $this->_data[$id] : NULL ;
        }
    }
    
    private function loadData() {
        $this->_reader = new XMLReader();
        $this->_reader->open($this->source);
        
        while($this->_reader->read()) {
            if($this->_reader->nodeType == XMLReader::ELEMENT && $this->_reader->name == $this->_offset)
            {
                $doc = new DOMDocument('1.0', 'UTF-8');
                $element = simplexml_import_dom($doc->importNode($this->_reader->expand(),true));
                $this->_data[trim($element->id)] = $element;
            }
        }
    }
}