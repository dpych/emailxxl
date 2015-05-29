<?php
class Model_Auth extends Model {
    
    protected $users = array(
        'admin'=>'Adamek123',
        'piotr'=> 'PiotrusPan'
    );

    protected $main = array(
        'piotr'=>'?c=main'
    );
    
    public function getRedirects() {
        return $this->main;
    }
    
    public function getData() {
        return $this->users;
    }
}
