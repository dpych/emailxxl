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


class View {
    public static function factory($path, $params = array()) {
        foreach($params as $key => $value) {
            $$key = $value;
        }
        ob_start();
        include_once $path;
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    }
}

class ProductsEmail {
    
    private $products;
    
    public function __construct() {
        $this->generateProductView();
        $this->generateEmail();
    }
    
    private function generateProductView() {
        $xml = new Model_SizeerCom();
        $csv = new Model_Products();

        $products = array();
        foreach($csv->getData() as $item ) {
            $products[] = $xml->getDataDetails((int) $item[0]);
        }
        $this->products = View::factory('./view/products.php', array('products' => $products));
    }
    
    private function generateEmail() {
        echo View::factory('./view/template.php', array('products' => $this->products));
    }
}

function main() {
    new ProductsEmail();
}

main();