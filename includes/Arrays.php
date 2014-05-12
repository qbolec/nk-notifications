<?php
//ta klasa jest statyczna, bo jest bezstanowa i nie ma dependencji
//nie ma też żadnego większego sensu ją mockować
class Arrays{
  public static function get(array $arr,$key,$default_value=null){
    return array_key_exists($key,$arr)?$arr[$key]:$default_value;
  }
  public static function grab(array $arr,$key){
    if(!array_key_exists($key,$arr)){
      throw new IsMissingException($key);
    }
    return $arr[$key];
  }
  /**
   * @param $a map
   * @param $b map
   * @return map with keys = keys(a) u keys(b), and conflicting values are taken from $b
   */
  public static function merge(array $a,array $b){
    return $b + $a;
  }
  /**
   * @param $a array (with numeric keys)
   * @param $b array (with numeric keys)
   * @return array with numeric keys in which a is concatenated with b
   */
  public static function concat(array $a,array $b){
    return array_merge($a,$b);
  }
}
?>
