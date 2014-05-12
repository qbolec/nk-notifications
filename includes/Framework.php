<?php
class Framework extends MockableSingleton implements IFramework{
  private $assertions = null;
  public function get_assertions(){
    if(null === $this->assertions){
      $this->assertions = Assertions::get_instance();
    }
    return $this->assertions;
  }
  public function get_time(){
    return time();
  }
}
?>
