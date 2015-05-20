<?php
/**
 * Description of shops
 *
 * @author Dawid Pych
 */
class Controller_Shops extends Controller {
    public function index() {
        $msg = $this->getMsg();
        $model_shops = new Model_Shops();
        $shops = $model_shops->getData();
        echo View::factory('shops/index.php', array('shops'=>$shops, 'msg' => $msg));
    }
    
    public function edit() {
        $shop = array();
        $msg = $this->getMsg();
        if(isset($_GET['id'])) {
            $id = $_GET['id'];
            $model_shops = new Model_Shops();
            $shop = $model_shops->getConn()->querySingle('SELECT * FROM shops WHERE id='.$id, true);
        }
        echo View::factory('shops/edit.php', array('shop'=>$shop, 'msg'=>$msg));
    }
    
    public function save() {
        var_dump($_POST);
        $ret = false;
        $lastis = "";
        if(isset($_POST['sklep']) && (bool)$_POST['sklep']) {
            $model_shops = new Model_Shops();
            
            $obj = new stdClass();
            $obj->name = $_POST['sklep'];
            
            if((int)$_POST['id']>0) {     
                $obj->id = $_POST['id'];
                $ret = $model_shops->update($obj);
            } else {
                $ret = $model_shops->insert($obj);
            }
        }
        if($ret) {
            $this->setMsg('Zapis zakończył się sukcesem', 'success');
            if(!(bool)$_POST['id']) {
                $lastid = $model_shops->getConn()->lastInsertRowId();
            } else {
                $lastid = $_POST['id'];
            }
        } else {
            $this->setMsg('Aktualizacja bazy się nie powiodła', 'danger');
        }
        var_dump($ret);
        $this->redirect('?c=shops&a=edit&id='.$lastid);
    }
}
