<?php
interface INKNotificationFactory
{
  public function get_server_to_user($body,$title,array $uri_params);
}
?>
