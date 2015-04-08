<?php
class Controller_Main extends Controller {
    public function index($get) {
        $email = new ProductsEmail();
        $email->run();
        var_dump(Zip::archive(array($email->getFileName()), 'test'));
    }
}