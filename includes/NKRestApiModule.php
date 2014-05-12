<?php
class NKRestApiModule extends MultiInstance implements INKRestApiModule
{
  private function get_max_recipients_per_notification(){
    return Config::get_instance()->get('nk/api/max_recipients_per_notification');
  }
  public function get_request_factory(){
    return NKRestRequestFactory::get_instance();
  }
  public function get_notification_factory(){
    return NKNotificationFactory::get_instance();
  }
  public function send_server_to_user_notification($body,$title,array $uri_params,array $recipients_ids){
    $notification = $this->get_notification_factory()->get_server_to_user($body,$title,$uri_params);
    $responses = array();
    $max_recipients_per_notification = $this->get_max_recipients_per_notification();
    for($offset=0;$offset<count($recipients_ids);$offset+=$max_recipients_per_notification){
      $recipients_ids_part = array_slice($recipients_ids,$offset,$max_recipients_per_notification);
      $request = $this->get_request_factory()->get_send_notification($notification,$recipients_ids_part); 
      $response = $request->send();
      $responses[]=$response;
    }
    return $responses;
  }

}
?>
