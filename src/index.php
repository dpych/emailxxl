<?php 
class Products {

    public $file = 'products.csv';
    public $image_dir = 'images';
    protected $products;
    protected $images;

    public function __construct() {
        $this->products = $this->getData();
        var_dump($this->products);
    }

    public function getData() {
        $file = fopen($this->file, "r");
        return fgetcsv($file);
    }
    
    public function generateList() {
        
        $col = 0;
        $i = 0;
        $html = "<tr>\n";
        
        foreach($this->products as $item) {
            $i++;
            $html .= "<td><a href=\"{$item}\" target=\"_blank\" title=\"Produkt\"><img src=\"{$this->image[$i]}\" alt=\"product\" /></a></td>";
            if($col>=3) {
                $col = 0;
                $html = "</tr>\n<tr>\n";
            }
        }
        
        $html .= "</tr>\n";
        
        return $html;
    }
}

function main() {
    $app = new Products();  
}

main();