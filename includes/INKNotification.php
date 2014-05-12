<?php
interface INKNotification
{
  public function get_body();
  public function get_title();
  public function get_uri_params();
  public function get_urls();
  public function get_type();
}
?>
