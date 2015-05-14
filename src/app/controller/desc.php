<?php
include_once './vendors/excel/PHPExcel.php';
include_once './vendors/excel/PHPExcel/Autoloader.php';

class Controller_Desc extends Controller {
    
    public function index() {
        $msg = $this->getMsg();
        echo View::factory('desc/index.php', array('msg'=>$msg));
    }
    
    public function upload() {
        if($_FILES['products']["name"]) {
            
            if(!isset($_FILES['products'])) {
                $_FILES = array(
                    'products' => array('tmp_name'=>false)
                );
                $fileType = array(1=>false);
            } else {
                $fileType = explode('.', $_FILES['products']['name']);
            }

            if($fileType[1] == 'xlsx') {
            
                $excel = PHPExcel_IOFactory::load($_FILES['products']['tmp_name']);
                $tmp   = new PHPExcel();

                if(!is_dir('./download'))
                    mkdir('./download', 0777, TRUE);

                $file = fopen('./download/products_desc.xml','w');
                $dane = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n"
                        ."<!DOCTYPE pasaz:Envelope SYSTEM \"loadOffers.dtd\">\n"
                        ."    <pasaz:envelope xmlns:pasaz=\"http://schemas.xmlsoap.org/soap/envelope/\">\n"
                        ."    <pasaz:Body>\n"
                        ."        <loadOffers xmlns=\"urn:ExportB2B\">\n"
                        ."            <offers>\n";
                fwrite($file, $dane);

                foreach( $excel->getWorksheetIterator() as $key => $worksheet ) {

                    if($key == 0) {
                        echo $key . '<br />';
                        $tmp_worksheep = $tmp->setActiveSheetIndex(0);
                        $rows = $worksheet->getHighestRow();
                        $columns = PHPExcel_Cell::columnIndexFromString($worksheet->getHighestColumn());
                        for($row=1; $row <= $rows; ++$row) {
                            for($col=0; $col<$columns; ++$col) {
                                $cell = $worksheet->getCellByColumnAndRow($col,$row);
                                $val = $cell->getValue();

                                $val = str_replace(array("\n\r","\r","\n"), "", $val);

                                $tmp_worksheep->setCellValueByColumnAndRow($col, $row, $val);
                                $tmp_cell = $worksheet->getCellByColumnAndRow($col,$row);
                                $val = $tmp_cell->getValue();

                                switch ($col) {
                                    case 0:
                                        $id = $val;
                                        break;
                                    case 1:
                                        $name = $val;
                                        break;
                                    case 2:
                                        $description = $val;
                                        break;
                                }   
                            }
                            $this->printproducts($id, $name, $description, $file);
                        }
                    }    
                }

                fwrite($file, "</offers></loadOffers></pasaz:Body></pasaz:envelope>");
                fclose($file);
                $this->setMsg('Plik wysłany. Można importować w sklepie', 'success');
            } else {
                $this->setMsg('Zły typ pliku', 'danger');
            }
        } else {
            $this->setMsg('Nie załączono pliku <strong>Exel</strong>', 'danger');
        }
        
        $this->redirect('?c=desc');
    }
    
    
    private function printproducts($id,$name,$description,$fps){
        $dane = "<offer>
            <id>".trim($id)."</id>
            <name><![CDATA[".trim($name)."]]></name>
            <price></price>
            <price2></price2>
            <url></url>
            <categoryId></categoryId>
            <image></image>
            <attributes></attributes>
            <availability></availability>
            <description><![CDATA[".trim($description)."]]></description>
            <sizes></sizes>
        </offer>
        ";

        fwrite($fps, $dane);
        return $dane;
    }
    
}