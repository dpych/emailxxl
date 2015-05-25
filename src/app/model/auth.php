<?php
class Model_Auth extends Model {
    
    protected $users = array(
        'admin'=>'Adamek123'
    );


    public function getData() {
        return $this->users;
    }
}
