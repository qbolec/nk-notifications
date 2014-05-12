<?php
class SendNotificationNKRestRequest extends NKRestRequest
{
  private $notification;
  private $recipients_ids;

  public function __construct(INKNotification $notification,array $recipients_ids){
    $this->notification = $notification;
    $this->recipients_ids = $recipients_ids;
  }
  private function get_object_to_send(){
    return array(
      'title' => $this->notification->get_title(),
      'body' => $this->notification->get_body(),
      'type' => $this->notification->get_type(),
      'recipients' => $this->recipients_ids,
      'urls' => $this->notification->get_urls(),
      'nkOptUrlParams' => JSON::force_assoc( $this->notification->get_uri_params() ),
    );
  }
  private function get_msg_to_send(){
    return JSON::encode($this->get_object_to_send());
  }
  public function send(){
    $jsoned_data = $this->get_msg_to_send();
    return $this->post_json(Config::get_instance()->get('nk/api/endpoints/send_notifications'),$jsoned_data);
  }
}
?>
