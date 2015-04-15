<?php
include_once './vendors/excel/PHPExcel.php';
include_once './vendors/excel/PHPExcel/Autoloader.php';

class Controller_Desc extends Controller {
    
    public function index() {
        echo View::factory('desc/index.php');
    }
    
    public function upload() {
        if($_FILES['products']) {
            $excel = PHPExcel_IOFactory::load($_FILES['products']['tmp_name']);
            $tmp   = new PHPExcel();
            
            $file = fopen('products_desc.xml','w');
            $dane = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
                    <!DOCTYPE pasaz:Envelope SYSTEM \"loadOffers.dtd\">
                    <pasaz:envelope xmlns:pasaz=\"http://schemas.xmlsoap.org/soap/envelope/\">
                    <pasaz:Body><loadOffers xmlns=\"urn:ExportB2B\"><offers>
                    ";
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
        }
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