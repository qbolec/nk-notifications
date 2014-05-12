<?php
interface INKRestRequestFactory
{
  /**
   * @param recipient_ids array<user_id>
   */
  public function get_send_notification(INKNotification $notification,array $recipients_ids);
}
?>
