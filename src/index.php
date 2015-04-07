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

class Model_SizeerCom extends Model_XML {
    protected $source = 'http://sklep.sizeer.com/comparators/NEW_CENEO.xml';    
}

class Model_Products extends Model {

    public $source = 'products.csv';
    public $image_dir = 'images';
    protected $image;

    public function __construct() {
        $this->products = $this->getData();
        $this->image = array();
    }

    public function getData() {
        $file = fopen($this->source, "r");
        $rows = array();
        while( ($data = fgetcsv($file, 0, ';')) !== FALSE ) {
            $rows[] = $data;
        }
        return $rows;
    }
}

class HTML_View {
    public function generateList($products) {
        
        $col = 0;
        $i = 0;
        $html = "<table>\n<tbody>\n<tr>\n";
        
        foreach($products as $item) {
            $i++;
            $col++;
            $image_url = isset($item->image) ? $this->image : "";
            $html .= "<td>"
                    . "<a href=\"{$item[0]}\" target=\"_blank\" title=\"Produkt\">"
                    . "<img src=\"{$image_url}\" alt=\"product\" />"
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
    
}

main();