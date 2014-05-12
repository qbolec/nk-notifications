<?php
interface ITheApplication extends IGetInstance
{
  public function get_time();
  public function get_portal_signatures_module();
  public function get_nk_rest_api_module();
}
?>
