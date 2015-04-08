<?php
class Controller_Main extends Controller {
    public function index($get) {
        $email = new ProductsEmail();
        $email->run();
        $files = array();
        $files[$email->getFileName()] = date('Ymd') . '.html';

        Zip::archive($files, './download/' . date('Ymd'));
        
        $this->redirect('./download/' . date('Ymd') . '.zip');
    }
}