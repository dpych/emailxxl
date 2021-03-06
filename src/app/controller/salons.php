<?php
/**
 * Controller for salons page
 *
 * @author Dawid Pych
 */
class Controller_Salons extends Controller {
    
    public function __construct() {
        $this->useAuth();
    }

    /**
     * Default action for list view of salons
     * 
     * @uses Example rout should look like ?c=salons or ?c=salons&a=index 
     */
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
        
        $query .= " order by miasto ASC, shop_id ASC";
       
        $shops = $model_salons->getData()->query($query);
        $salons = array();
        while($row = $shops->fetchArray(SQLITE3_ASSOC) ){
            $salons[] = $row;
        }

        echo View::factory('salons/index.php', array('salons'=>$salons, 'msg' => $msg, 'pages'=>$pages));
    }
    
    /**
     * Default action for edit or add view of salon
     * 
     * @uses Example rout should look like ?c=salons&a=edit for create new or 
     * ?c=salons&a=edit&id=1 for edit existing item
     */
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
    
    /**
     * Method from save changes or insert new position to database
     * It should uses only from post
     * When finish import. Redirect to ::index
     */
    public function save() {
        $ret = false;
        $lastis = "";
        if(isset($_POST['miasto']) && (bool)$_POST['miasto'] && $_POST['adres'] ) {
            $model_shops = new Model_Salons();
            
            $pp = "pon-pt";
            
            $params = new stdClass();
            $params->lat = $_POST['lat'];
            $params->log = $_POST['log'];
            $params->url = $_POST['url'];
            
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
            $obj->params = htmlspecialchars(json_encode($params));
            
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
    
    /**
     * Import method from Excel file. 
     * It should uses only from post and need have send $_FILES['excel'] file
     * When finish import. Redirect to ::index
     */
    public function import() {
        if(isset($_FILES['excel'])){
            $import = $_FILES;
            $model = new Model_Salons();
            if($model->importEXCEL($import)) {
                 $this->setMsg('Import przebiegł prawidłowo', 'success');
            } else {
                 $this->setMsg('Aktualizacja bazy się nie powiodła', 'danger');
            }
        } else {
            $this->setMsg('Nie załączyłeś pliku excel', 'danger');
        }
        $this->redirect('?c=salons');
    }
}
