<?php
class Model_Shops extends Model_Sqlite {

    protected  $_table = 'shops';
    protected  $_schemat = "CREATE TABLE IF NOT EXISTS `shops` (
                `id`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
                `name`	TEXT NOT NULL,
                `published`	INTEGER NOT NULL DEFAULT 1
            );";

    public function getData() {
        $data = array();
        $sql = "SELECT * FROM {$this->_table}";
        $ret = $this->_data->query($sql);
        while($row = $ret->fetchArray(SQLITE3_ASSOC) ){
            $data[] = $row;
         }
         return $data;
    }
    
    public function update($obj) {
        $sql = "UPDATE {$this->_table} SET name=\"{$obj->name}\" WHERE id={$obj->id}";
        return $this->_data->exec($sql);
    }
    
    public function insert($obj) {
        $sql = "INSERT INTO {$this->_table} (name) VALUES (\"{$obj->name}\")";
        return $this->_data->exec($sql);
    }
}