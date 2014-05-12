<?php
class NKNotificationFactory extends MultiInstance implements INKNotificationFactory
{
  public function get_server_to_user($body,$title,array $uri_params){
    return new NKNotification($body,$title,$uri_params);
  }
}
?>
