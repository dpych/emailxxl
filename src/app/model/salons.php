<?php
/**
 * Model for salons list.
 *
 * @author Dawid Pych
 */
class Model_Salons extends Model_Sqlite {
    
    /**
     * Name table for salons
     * @var string 
     */
    protected  $_table = 'salons';
    
    /**
     * Default schema for salons table if not exist
     * @var string 
     */
    protected  $_schemat = "CREATE TABLE IF NOT EXISTS `salons` (
                `id`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
                `shop_id`	INTEGER NOT NULL,
                `miasto`	varchar(255) NOT NULL,
                `lokalizacja`	varchar(255),
                `adres`         varchar(255) NOT NULL,
                `telefon`	varchar(255),
                `pon-pt`	varchar(24),
                `sob`   	varchar(24),
                `niedz`   	varchar(24),
                `published`	INTEGER NOT NULL DEFAULT 1,
                `params`        text
            );";
    
    /**
     * Return sqlite conect object
     * 
     * @return SQLITE
     */
    
    public function getData() {
        return $this->_data;
    }
    
    /**
     * Update record for salones table
     * 
     * @param object $obj
     * @return bool
     */
    
    public function update($obj) {
        $pp = "pon-pt";
        $sql = "UPDATE {$this->_table} SET "
        . "shop_id=\"{$obj->shop_id}\", "
        . "miasto=\"{$obj->miasto}\", "
        . "lokalizacja=\"{$obj->lokalizacja}\", "
        . "adres=\"{$obj->adres}\", "
        . "telefon=\"{$obj->telefon}\", "
        . "`pon-pt`=\"{$obj->$pp}\", "
        . "sob=\"{$obj->sob}\", "
        . "niedz=\"{$obj->niedz}\", "
        . "published={$obj->published}, "
        . "params=\"{$obj->params}\""
        . "WHERE id={$obj->id}";
        return $this->_data->exec($sql);
    }
    
    /**
     * Insert new row to salons table
     * 
     * @param object $obj
     * @return bool
     */
    
    public function insert($obj) {
        $pp = "pon-pt";
        $sql = "INSERT INTO {$this->_table} (miasto,lokalizacja,adres,telefon,`pon-pt`,sob,niedz,published,shop_id,params) "
        . "VALUES (\"{$obj->miasto}\",\"{$obj->lokalizacja}\",\"{$obj->adres}\",\"{$obj->telefon}\",\"{$obj->$pp}\",\"{$obj->sob}\",\"{$obj->niedz}\",\"{$obj->published}\",\"{$obj->shop_id}\",\"{$obj->params}\")";
        var_dump($sql);
        return $this->_data->exec($sql);
    }
    
    /**
     * Remove item from salons table
     * 
     * @param object $obj
     * @return bool
     */
    
    public function remove($obj) {
        return $this->_data->exec("DELETE FROM {$this->_table} WHERE id=\"{$obj->id}\"");
    }
    
    /**
     * Method for import data from Excel file
     * 
     * @param array $import insert global $_FILE where is $_FILE['excel']
     */
    
    public function importEXCEL(array $import) {
        include_once './vendors/excel/PHPExcel.php';
        include_once './vendors/excel/PHPExcel/Autoloader.php';
        
        $ponpt = 'pon-pt';
        $excel = PHPExcel_IOFactory::load($import['excel']['tmp_name']);
        $shops = new Model_Shops();

        $worksheet = $excel->setActiveSheetIndex(0);
        
        $shopColumn = $this->findShopColumn($worksheet);
        $mapsColumns = $this->mapColumnIds($worksheet);

        if($shopColumn) {
            for($row=2; $row<=$worksheet->getHighestRow(); $row++) {

                if($shopColumn['name']=='id') {
                    $c = $shops->getConn()->querySingle('SELECT * FROM shops WHERE id=' . $worksheet->getCellByColumnAndRow($shopColumn['id'], $row) , true);
                } else {
                    $c = $shops->getConn()->querySingle('SELECT * FROM shops WHERE name LIKE "' . $worksheet->getCellByColumnAndRow($shopColumn['id'], $row) .'%"', true);
                }
                
                var_dump($mapsColumns['pon-pt']);
                
                $obj = new stdClass();
                $obj->miasto        = trim($worksheet->getCellByColumnAndRow($mapsColumns['miasto'], $row));
                $obj->lokalizacja   = $mapsColumns['lokalizacja'] ? trim($worksheet->getCellByColumnAndRow($mapsColumns['lokalizacja'], $row)) : "";
                $obj->adres         = trim($worksheet->getCellByColumnAndRow($mapsColumns['adres'], $row));
                $obj->telefon       = trim($worksheet->getCellByColumnAndRow($mapsColumns['telefon'], $row));
                $obj->$ponpt        = trim($worksheet->getCellByColumnAndRow($mapsColumns['ponpt'], $row));
                $obj->sob           = trim($worksheet->getCellByColumnAndRow($mapsColumns['sobota'], $row));
                $obj->niedz         = trim($worksheet->getCellByColumnAndRow($mapsColumns['niedziela'], $row));
                $obj->published     = 1;
                
                $params = new stdClass();
                $params->lat = $mapsColumns['lat'] ? trim($worksheet->getCellByColumnAndRow($mapsColumns['lat'], $row)) : "";
                $params->log = $mapsColumns['log'] ? trim($worksheet->getCellByColumnAndRow($mapsColumns['log'], $row)) : "";
                $params->url = $mapsColumns['url'] ? trim($worksheet->getCellByColumnAndRow($mapsColumns['url'], $row)) : "";

                $obj->params = htmlspecialchars(json_encode($params));
                $obj->shop_id       = (int) $c['id'];
                
                $sql = "SELECT * FROM {$this->_table} WHERE "
                    . "shop_id={$c['id']} AND "
                    . "miasto LIKE \"" . $obj->miasto . "\" AND "
                    . "adres LIKE \"" . $obj->adres . "\" ";
                $s = $this->_data->querySingle($sql, true);
                
                if( count($s)==0 ) {
                    var_dump($obj);
                    $ret = $this->insert($obj);
                } else {
                    $obj->id = (int) $s['id'];
                    $ret = $this->update($obj);
                }
            }
        }
        return $ret;
    }

    /**
     * Maps columns from Excel file for correct update
     * 
     * @param object$worksheet
     * @return array | null
     */
    private function mapColumnIds($worksheet) {
        $columns = null;

        for($i=1; $i<=1025; $i++) {
            $cell = $worksheet->getCellByColumnAndRow($i, 1);  
            $label = (string) strtolower((string) trim($cell));
            
            if($label) {
                $columns[$label] = $i;  
            }
        }
        return $columns;
    }

    /**
     * Return column id for shop id | name column
     * 
     * @param object $worksheet
     * @return int
     */
    
    private function findShopColumn($worksheet) {
        $id = null;

        for($i=1; $i<=1025; $i++) {
            $cell = $worksheet->getCellByColumnAndRow($i, 1);

            if( strtolower($cell) == 'id' ) {
                $id = array('id'=>$i, 'name'=>$cell);
            } else {
                if((
                        strtolower($cell) == 'id' || 
                        strtolower($cell) == 'sklep' || 
                        strtolower($cell) == 'strona' || 
                        strtolower($cell) == 'salon') && is_null($id)) {
                    $id = array('id'=>$i, 'name'=>$cell);
                } 
            }
        }
        return $id;
    }
    
}
