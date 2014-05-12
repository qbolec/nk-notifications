<?php
class PersonValidator extends PCREValidator
{
  public function __construct(){
    parent::__construct('/^(person|fake)\\.[[:xdigit:]]+$/');
  }
}
?>
