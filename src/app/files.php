<?php
class Files {
    public static $MODE = 0777;
    public static $RECURSIVE = TRUE;
    
    public static function mkdir($path) {
        return mkdir($path, self::$MODE, self::$RECURSIVE);
    }
    
    public static function copy($from, $to) {
        return copy($from, $to);
    }
    
    public static function delete($path) {
        if(is_file($path)) {
            return unlink($path);
        } else {
            #TODO: dopisać usuwanie katalogu
        }
    }
}