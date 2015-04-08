<?php
class Controller_Main extends Controller {
    
    public function index() {
        echo View::factory('index.php');
    }
    
    public function download() {
        $email = new ProductsEmail();
        $email->run();
        $files = array();
        $files[$email->getFileName()] = date('Ymd') . '.html';

        Zip::archive($files, './download/' . date('Ymd'));
        Files::delete('./download/' . date('Ymd') . '.html');
        
        $this->redirect('./download/' . date('Ymd') . '.zip');
    }
    
    public function upload() {
        
    }
}