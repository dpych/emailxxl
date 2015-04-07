<?php
class View {
    public static function factory($path, $params = array()) {
        foreach($params as $key => $value) {
            $$key = $value;
        }
        ob_start();
        include_once $path;
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    }
}
