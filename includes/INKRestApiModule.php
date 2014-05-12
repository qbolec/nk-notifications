<?php
interface INKRestApiModule
{
  public function get_request_factory();
  public function get_notification_factory();
  public function send_server_to_user_notification($body,$title,array $uri_params,array $recipients_ids);
}
?>
