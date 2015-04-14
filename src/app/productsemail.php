<?php
class ProductsEmail {
    
    private $products;
    protected $_filename = NULL;
    protected $_download = './download/';


    public function run() {
        $this->generateProductView();
        $this->generateEmail();
    }
    
    private function generateProductView() {
        $xml = new Model_SizeerCom();
        $csv = new Model_Products();

        $all = array(
            'meskie' => array(),
            'damskie' => array(),
            'dzieciece' => array()
        );
        
        $shell = array(
            'meskie' => array(),
            'damskie' => array(),
            'dzieciece' => array()
        );
        foreach($csv->getData() as $item ) {
            if(!isset($item[1]))
                $cat = 0;
            else 
                $cat = (int) $item[1];
            
            $tmp = $xml->getDataDetails($item[0]);
            $sex = trim($this->category($tmp->categoryId));
            
            
            switch ($cat) {
                case 0 :
                    $all[$sex][] = $tmp;
                    break;
                case 1 :
                    $shell[$sex][] = $tmp;
                    break;
            }
        }
        $this->products = View::factory('products.php', array('elements' => array(0 => $all, 1=> $shell)));
    }
    
    private function category($categoryId) {
        $tmp = explode(' / ', $categoryId);
        switch($tmp[1]) {
            case 'Męskie':
               $sex = 'meskie';
               break;
            case 'Damskie':
                $sex = 'damskie';
                break;
            case 'Dziecięce':
                $sex = 'dzieciece';
                break;
            default:
                $sex = NULL;
        }
        return $sex;
    }
    
    private function generateEmail() {
        if(!is_dir($this->_download))
            mkdir ($this->_download, 0777, TRUE);
        
        $this->_filename = $this->_download . date('Ymd') . '.html';
        
        $html = View::factory('template.php', array('products' => $this->products));
        
        file_put_contents($this->_filename, $html);
        
        return $html;
    }
    
    public function getFileName() {
        return $this->_filename;
    }
}