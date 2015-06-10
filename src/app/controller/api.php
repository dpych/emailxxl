<?php
class Controller_Api extends Controller {
    public function index() {
        $json = new stdClass();
        $json->success = false;
        $json->data = array();

        if((isset($_GET['id']) && (int) $_GET['id'] > 0) || (isset($_GET['shop_id']) && (int) $_GET['shop_id'] > 0)) {
            $id = $_GET['shop_id'] ? $_GET['shop_id'] : $_GET['id'];
            $data = array();
            $salons = new Model_Salons();
            $salons = $salons->getConn()->query('select * from salons where published=1 and shop_id='. (int) htmlspecialchars($id) .' order by miasto ASC');
            $data = array();
            while($row = $salons->fetchArray(SQLITE3_ASSOC)) {
                $data[] = $row;
            }
            $json->success = true;
            $json->count = count($data);
            $json->data = $data;
        } else {
            $salons = new Model_Salons();
            $salons = $salons->getConn()->query('select * from salons where published=1 order by miasto ASC, shop_id ASC');
            $data = array();
            while($row = $salons->fetchArray(SQLITE3_ASSOC)) {
                $data[] = $row;
            }
            $json->success = true;
            $json->count = count($data);
            $json->data = $data;
        }
        $this->render($json);
    }
    
    private function generateJSON($data) {
        
        $model_shops = new Model_Shops();
        $model_shops = $model_shops->getData();
        $pages = array();

        foreach($model_shops as $row) {
            $pages[$row['id']] = $row['name'];
        }
        
        for ($i=0; $i<count($data->data); $i++ ) {
            $data->data[$i]['shop_id'] = isset($pages[$data->data[$i]['shop_id']]) ? $pages[$data->data[$i]['shop_id']] : "";
            $data->data[$i]['params'] = json_decode(htmlspecialchars_decode($data->data[$i]['params']));
        }
        header('Content-Type: application/json; charset=utf-8');
        return json_encode($data);
    }
    
    private function generateHTML($data) {
        $model_shops = new Model_Shops();
        $model_shops = $model_shops->getData();
        $pages = array();

        foreach($model_shops as $row) {
            $pages[$row['id']] = $row['name'];
        }

        return View::factory('api/html.php', array('salons'=>$data, 'pages'=>$pages));
    }
    
    private function generateXML($data) {
        $model_shops = new Model_Shops();
        $model_shops = $model_shops->getData();
        $pages = array();

        foreach($model_shops as $row) {
            $pages[$row['id']] = $row['name'];
        }
        
        $xml = new SimpleXMLElement("<?xml version=\"1.0\" encoding=\"utf-8\" ?><sklepy></sklepy>");
        foreach ( $data->data as $element) {
            $sklep = $xml->addChild('sklep');
            foreach($element as $key=>$value) {
                if($key=='shop_id') { 
                    $value = isset($pages[$value]) ? $pages[$value] : "";
                }
                if($key=='params') {
                    $params = json_decode(htmlspecialchars_decode($value));
                    $param = $sklep->addChild($key);
                    if( $params != NULL ) {
                        foreach( $params as $k=>$v ) {
                            $param->addChild($k, $v);
                        }
                    }
                } else {
                    $sklep->addChild($key, $value);
                }
                
            }
        }
        header('Content-Type: text/xml; charset=utf-8');
        return $xml->asXML();
    }
    
    private function generateCSV($data) {
        
        $model_shops = new Model_Shops();
        $model_shops = $model_shops->getData();
        $pages = array();
        $params = array('lat','log','url');

        foreach($model_shops as $row) {
            $pages[$row['id']] = $row['name'];
        }
        
        for ($i=0; $i<count($data->data); $i++ ) {
            $data->data[$i]['shop_id'] = isset($pages[$data->data[$i]['shop_id']]) ? $pages[$data->data[$i]['shop_id']] : "";
            $data->data[$i]['params'] = json_decode(htmlspecialchars_decode($data->data[$i]['params']));
        }
        
        $file = fopen("php://memory","w");
        $header = array();
        foreach( $data->data[0] as $key=>$value ) {
            if($key!='params') {
                $header[] = $key;
            }
        }
        foreach( $params as $key) {
            $header[] = $key;
        }
        
        fputcsv($file, $header, ';');
        foreach( $data->data as $item ) {
            $tmp = array();
            foreach ( $item as $a=>$v ) {
                if($a!="params") {
                    //$tmp[] = mb_convert_encoding($v, 'CP1250', 'UTF-8');
                    $tmp[] =  iconv('UTF-8', 'CP1250', $v);
                } else {
                    if($v) {
                        foreach($params as $p) {
                            $tmp[] = $v->$p;
                        }
                    }
                }
            }
            fputcsv($file, $tmp, ';');
        }
        fseek($file, 0);
        header('Content-Type: application/csv;');
        header('Content-Disposition: attachment; filename="sklepy_'.date('Ymd_hmi').'.csv";');
        fpassthru($file);
    }
    
    private function generateXLSX($data) {
        
        $model_shops = new Model_Shops();
        $model_shops = $model_shops->getData();
        $pages = array();

        foreach($model_shops as $row) {
            $pages[$row['id']] = $row['name'];
        }
        
        for ($i=0; $i<count($data->data); $i++ ) {
            $data->data[$i]['shop_id'] = isset($pages[$data->data[$i]['shop_id']]) ? $pages[$data->data[$i]['shop_id']] : "";
        }
        
        include_once './vendors/excel/PHPExcel.php';
        include_once './vendors/excel/PHPExcel/Autoloader.php';
        
        $e = new PHPExcel();
        $e->setActiveSheetIndex(0);
        $row = 2;
        $col=0;
        foreach($data->data[0] as $k=>$v ) { 
            $e->getActiveSheet()->setCellValueExplicitByColumnAndRow($col, 1, $k);
            $col++;
        }
        
        foreach($data->data as $item ) {
            $col = 0;
            foreach($item as $v) {
                $e->getActiveSheet()->setCellValueExplicitByColumnAndRow($col, $row, $v);
                $col++;
            }
            $row++;
        }
        $e->getActiveSheet()->setTitle('Sklepy');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="sklepy_'.date('Ymd_hmi').'.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($e, 'Excel2007');
        $objWriter->save('php://output');
    }

    private function render($data) {
        if(!isset($_GET['format']) || $_GET['format']=='json' ) {
            echo $this->generateJSON($data);
        } elseif($_GET['format']=='html' ) {
            echo $this->generateHTML($data);
        } elseif ($_GET['format']=='xml') {
            echo $this->generateXML($data);
        } elseif ($_GET['format']=='csv') {
            echo $this->generateCSV($data);
        } elseif ($_GET['format']=='xlsx' || $_GET['format']=='excel') {
            echo $this->generateXLSX($data);
        }
    }
}
