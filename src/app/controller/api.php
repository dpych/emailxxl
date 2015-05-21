<?php
class Controller_Api extends Controller {
    public function index() {
        $json = new stdClass();
        $json->success = false;
        $json->data = array();
                
        if(isset($_GET['id']) && (int) $_GET['id'] > 0) {
            $salons = new Model_Salons();
            $salons = $salons->getConn()->query('select * from salons where published=1 and shop_id='.  htmlspecialchars($_GET['id'] .' order by miasto ASC'));
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
                $sklep->addChild($key, $value);
            }
        }
        header('Content-Type: text/xml; charset=utf-8');
        return $xml->asXML();
    }
    
    private function generateCSV($data) {
        
        $model_shops = new Model_Shops();
        $model_shops = $model_shops->getData();
        $pages = array();

        foreach($model_shops as $row) {
            $pages[$row['id']] = $row['name'];
        }
        
        for ($i=0; $i<count($data->data); $i++ ) {
            $data->data[$i]['shop_id'] = isset($pages[$data->data[$i]['shop_id']]) ? $pages[$data->data[$i]['shop_id']] : "";
        }
        
        $file = fopen("php://memory","w");
        $header = array();
        foreach( $data->data[0] as $key=>$value ) {
            $header[] = $key;
        }
        fputcsv($file, $header, ';');
        foreach( $data->data as $item ) {
            $tmp = array();
            foreach ( $item as $a ) {
                $tmp[] = mb_convert_encoding($a, 'UTF-16LE', 'UTF-8');
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
