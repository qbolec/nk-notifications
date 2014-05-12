<?php
class TheApplication extends Singleton implements ITheApplication
{
  private $time_offset = null;
  public function get_time(){
    return Framework::get_instance()->get_time() + $this->get_facts_module()->get_config()->get_time_offset();
  }
  public function get_portal_signatures_module(){
    return PortalSignaturesModule::get_instance();
  }
  public function get_nk_rest_api_module(){
    return NKRestApiModule::get_instance();
  }
}
?>
