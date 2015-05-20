<?php
/**
 * Description of shops
 *
 * @author Dawid Pych
 */
class Controller_Shops extends Controller {
    public function index() {
        $model_shops = new Model_Shops();
        $shops = $model_shops->getData();
        echo View::factory('shops/index.php', array('shops'=>$shops));
    }
    
}
