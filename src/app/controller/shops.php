<?php
/**
 * Description of shops
 *
 * @author Dawid Pych
 */
class Controller_Shops extends Controller {
    public function index() {
        echo View::factory('shops/index.php');
    }
}
