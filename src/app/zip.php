<?php

class Zip {
    public static function archive($files, $filename) {
        $zip = new ZipArchive();
        $zip->open($filename . '.zip', ZipArchive::CREATE);
        
        foreach($files as $file => $value) {
        //    var_dump($file);
            $zip->addFile($file, $value);
        }
        
        return $zip->close();
    }
}