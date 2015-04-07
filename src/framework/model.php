<?php
abstract class Model {
    protected $source;
    protected $_data;
    
    abstract public function getData();
}