<?php 
class Model_XML {
    public $source = 'http://sklep.sizeer.com/comparators/NEW_CENEO.xml';
    protected $_data = array();
    protected $_reader = NULL;


    public function __construct() {}
    
    public function getData() {
        $this->_reader = new XMLReader();
        $this->_reader->open($this->source);
        
        while($this->_reader->read()) {
            if($this->_reader->nodeType == XMLReader::ELEMENT && $this->_reader->name == 'offer')
            {
                $doc = new DOMDocument('1.0', 'UTF-8');
                $element = simplexml_import_dom($doc->importNode($this->_reader->expand(),true));
                $this->_data[trim($element->id)] = $element;
            }
        }
        return $this->_data;
    }

    public function getDataDetails($id) {
        if($id) {
            return isset($this->_data[$id]) ? $this->_data[$id] : NULL ;
        }
    }
}

class Model_Products {

    public $file = 'products.csv';
    public $image_dir = 'images';
    protected $products;
    protected $image;

    public function __construct() {
        $this->products = $this->getData();
        $this->image = array();
        var_dump($this->products);
    }

    public function getData() {
        $file = fopen($this->file, "r");
        $rows = array();
        while( ($data = fgetcsv($file, 0, ';')) !== FALSE ) {
            $rows[] = $data;
        }
        return $rows;
    }
    
    public function generateList() {
        
        $col = 0;
        $i = 0;
        $html = "<table>\n<tbody>\n<tr>\n";
        
        foreach($this->products as $item) {
            $i++;
            $image_url = isset($this->image[$i]) ? $this->image[$i] : "";
            $html .= "<td>"
                    . "<a href=\"{$item[0]}\" target=\"_blank\" title=\"Produkt\">"
                    . "<img src=\"{$image_url}\" alt=\"product\" />"
                    . "</a>"
                    . "</td>";
            if($col>=3) {
                $col = 0;
                $html = "</tr>\n<tr>\n";
            }
        }
        
        $html .= "</tr>\n</tbody>\n</table>";
        
        return $html;
    }
}

function main() {
    $app = new Model_Products();  
    echo $app->generateList();
}

main();