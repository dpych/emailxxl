<?php
class Controller_Main extends Controller {
    
    public function __construct() {
        $this->useAuth();
    }
    
    public function index() {
        $msg = $this->getMsg();
        echo View::factory('index.php', array('msg'=>$msg));
    }
    
    public function download() {
        $email = new ProductsEmail();
        $email->run();
        $files = array();
        $files[$email->getFileName()] = date('Ymd') . '.html';
        for($i=1; $i<=7; $i++) {
            $files['./images/mailing_0' . $i . '.jpg'] = 'mailing_0' . $i . '.jpg';
        }
        
        Zip::archive($files, './download/' . date('Ymd'));
        Files::delete('./download/' . date('Ymd') . '.html');
        
        $this->redirect('./download/' . date('Ymd') . '.zip');
    }
    
    public function upload() {
        if($_FILES['csv']) {
            $target_dir = "./datain/";
            $target_file =  $target_dir . "products.csv";
            $type = pathinfo($_FILES['csv']['name'],PATHINFO_EXTENSION);
            if( $type=='csv' && move_uploaded_file($_FILES['csv']['tmp_name'], $target_file)) {
                 $this->redirect('?c=main&a=download');
            } else {
                $this->setMsg('Zły format pliku.', 'danger');
                $this->redirect('?c=main');
            }
        }
    }
}