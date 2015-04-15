<?php
abstract class Controller {
    public function redirect($path) {
        header('Location: '.$path);
    }
    
    public function setMsg($desc, $type) {
        $_SESSION['message'] = array(
            'msg' => $desc,
            'type' => $type
        );
    }
    
    public function getMsg() {
        $msg = isset($_SESSION['message']) & $_SESSION['message'] ? $_SESSION['message'] : "";
        $_SESSION['message'] = NULL;
        return $msg;
    }
    
}
