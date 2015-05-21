<?php
/**
 * Description of salons
 *
 * @author Dawid Pych
 */
class Model_Salons extends Model_Sqlite {
    protected  $_table = 'salons';
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
    
    public function getData() {
        return $this->_data;
    }
    
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
var_dump($sql);
        return $this->_data->exec($sql);
    }
    
    public function insert($obj) {
        $pp = "pon-pt";
        $sql = "INSERT INTO {$this->_table} (miasto,lokalizacja,adres,telefon,`pon-pt`,sob,niedz,published,shop_id,params) "
        . "VALUES (\"{$obj->miasto}\",\"{$obj->lokalizacja}\",\"{$obj->adres}\",\"{$obj->telefon}\",\"{$obj->$pp}\",\"{$obj->sob}\",\"{$obj->niedz}\",\"{$obj->published}\",\"{$obj->shop_id}\",\"{$obj->params}\")";
        return $this->_data->exec($sql);
    }
    
    public function remove($obj) {
        return $this->_data->exec("DELETE FROM {$this->_table} WHERE id=\"{$obj->id}\"");
    }
}
