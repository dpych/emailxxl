<?php
list($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']) = explode(':' , base64_decode(substr($_SERVER['HTTP_AUTHORIZATION'], 6)));
ob_start();
session_start();
set_time_limit(180);
define('DS', '/');
define('APP', './app');
define('CORE', './framework');
define('VIEW', '/view');
define('SQLITE','./db/database.sqlite');
define('BASE_URL','http://localhost:8000/');

$extensions = array('.php');
$ext = implode(',',$extensions);
spl_autoload_register(null, false);
spl_autoload_extensions($ext);
 
function frameworkLoader($classname){
    $extensions = array('.php');
    if (class_exists($classname, false)){ return; }
    $class = explode('_', strtolower(strval($classname)));
    $deeps = count($class);
    $file = CORE;
    for ($i=0;$i<$deeps;$i++){
        $file .= DS . $class[$i];
    }
    foreach ($extensions as $ext){
        $fileClass = $file.$ext;
        if (file_exists($fileClass) && is_readable($fileClass) && !class_exists($classname, false)){
            require_once($fileClass);
            return true;
        }
    }
    return false;
}

function appLoader($classname){
    $extensions = array('.php');
    if (class_exists($classname, false)){ return; }
    $class = explode('_', strtolower(strval($classname)));
    $deeps = count($class);
    $file = APP;
    for ($i=0;$i<$deeps;$i++){
        $file .= DS . $class[$i];
    }
    foreach ($extensions as $ext){
        $fileClass = $file.$ext;
        if (file_exists($fileClass) && is_readable($fileClass) && !class_exists($classname, false)){
            require_once($fileClass);
            return true;
        }
    }
    return false;
}

spl_autoload_register('frameworkLoader');
spl_autoload_register('appLoader');

function main() {
    if(isset($_GET['c'])) {
        $c = 'Controller_' . $_GET['c'];
        $class = new $c();
    } else {
        $class = new Controller_Shops();
    }
    if(isset($_GET['a'])) {
        $a = $_GET['a'];
        $class->$a();
    } else {
        $class->index($_GET);
    }
}

main();
ob_end_flush();