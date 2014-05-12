<?php
class NKRestRequestFactory extends MultiInstance implements INKRestRequestFactory
{
  public function get_send_notification(INKNotification $notification,array $recipients_ids){
    return new SendNotificationNKRestRequest($notification,$recipients_ids);
  }
}
?>
