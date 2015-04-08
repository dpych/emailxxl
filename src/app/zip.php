<?php

class Zip {
    public static function archive($files, $filename) {
        $zip = new ZipArchive();
        $zip->open($filename . '.zip', ZipArchive::CREATE);
        
        foreach($files as $file) {
            $zip->addFile($file);
        }
        
        return $zip->close();
    }
}
