<?php
class Autoload{
  public static function load($class_name){
    require_once 'includes/' . $class_name . '.php';
  }
}
spl_autoload_register('Autoload::load');
?>
