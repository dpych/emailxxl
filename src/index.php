<?php 
abstract class Model {
    protected $source;
    protected $_data;
    
    abstract public function getData();
}

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

class Model_SizeerCom extends Model_XML {
    protected $source = 'http://sklep.sizeer.com/comparators/NEW_CENEO.xml';    
}

class Model_Products extends Model_CSV {
    protected $source = 'products.csv';
}


class HTML_View {
    static public function generateList($products) {
        
        $col = 0;
        $i = 0;
        $html = "<table width=\"600px\" cellspadding=\"0\" cellspasing=\"0\">\n<tbody>\n<tr>\n";
        
        foreach($products as $item) {
            $i++;
            $col++;
            $html .= "<td width=\"33%\">"
                    . "<a href=\"{$item->url}\" target=\"_blank\" title=\"Produkt\">"
                    . "<img src=\"{$item->image}\" alt=\"product\" width=\"100%\" />"
                    . "<span style=\"font-weight:bold\">{$item->attributes->attribute[0]->value}</span><br />"
                    . "{$item->name}"
                    . "</a>"
                    . "</td>";
            if($col>=3) {
                $col = 0;
                $html .= "</tr>\n<tr>\n";
            }
        }
        
        $html .= "</tr>\n</tbody>\n</table>";
        
        return $html;
    }
}

function main() {
    $xml = new Model_SizeerCom();
    $csv = new Model_Products();
    
    $products = array();
    foreach($csv->getData() as $item ) {
        $products[] = $xml->getDataDetails((int) $item[0]);
    }
    echo HTML_View::generateList($products);
    
}

main();