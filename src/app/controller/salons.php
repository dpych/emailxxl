<?php
/**
 * Description of shops
 *
 * @author Dawid Pych
 */
class Controller_Salons extends Controller {
    public function index() {
        $msg = $this->getMsg();
        $model_salons = new Model_Salons();
        $model_shops = new Model_Shops();
        $model_shops = $model_shops->getData();
        $pages = array();
        
        foreach($model_shops as $row) {
            $pages[$row['id']] = $row['name'];
        }
        
        $query = "select * from salons";
        if(isset($_GET['shop_id']) && (int)$_GET['shop_id']>0){
            $query .= " where shop_id=".  htmlspecialchars($_GET['shop_id']);
        }
       
        $shops = $model_salons->getData()->query($query);
        $salons = array();
        while($row = $shops->fetchArray(SQLITE3_ASSOC) ){
            $salons[] = $row;
        }

        echo View::factory('salons/index.php', array('salons'=>$salons, 'msg' => $msg, 'pages'=>$pages));
    }
    
    public function edit() {
        $shop = array();
        $msg = $this->getMsg();
        $shops = new Model_Shops();
        if(isset($_GET['id'])) {
            $id = $_GET['id'];
            $model_shops = new Model_Salons();
            $shop = $model_shops->getData()->querySingle('SELECT * FROM salons WHERE id='.$id, true);
        }
        echo View::factory('salons/edit.php', array('shops'=>$shops, 'shop'=>$shop, 'msg'=>$msg));
    }
    
    public function save() {
        $ret = false;
        $lastis = "";
        if(isset($_POST['miasto']) && (bool)$_POST['miasto'] && $_POST['adres'] ) {
            $model_shops = new Model_Salons();
            
            $pp = "pon-pt";
            
            $obj = new stdClass();
            $obj->miasto = $_POST['miasto'];
            $obj->adres = $_POST['adres'];
            $obj->lokalizacja = $_POST['lokalizacja'];
            $obj->telefon = $_POST['telefon'];
            $obj->$pp = $_POST['pon-pt'];
            $obj->sob = $_POST['sob'];
            $obj->niedz = $_POST['niedz'];
            $obj->published = $_POST['published'];
            $obj->shop_id = $_POST['shop_id'];
            
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
        $this->redirect('?c=salons&a=edit&id='.$lastid . ($_POST['shop_id'] ? '&shop_id=' . $_POST['shop_id'] : "" ));
    }
}
