<?php
class Assertions extends MultiInstance implements IAssertions
{
  public function halt_if($condition){
    if($condition){
      $this->halt();
    }
  }
  protected function halt(){
    throw new LogicException();
  }
  public function halt_unless($condition){
    $this->halt_if(!$condition);
  }
}
?>
