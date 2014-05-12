<?php
class Config extends AbstractConfig{
  private $tree = null;
  protected function get_tree(){
    if($this->tree !== null){
      return $this->tree;
    }

    $this->tree = array(
      'nk' => array( 
        'app_id'=> PUT YOUR APP ID HERE,
        'api'=>array(
          'max_recipients_per_notification' => 50,
          'endpoints' => array(
            'send_notifications' => 'http://opensocial.nk-net.pl/v09/social/rest/messages/@me/@self/@outbox',
          ),
        ),
      ),
      'oauth'=>array(
        'key' => PUT YOUR APP KEY HERE,
        'secret' => PUT YOUR APP SECRET HERE,
      ),
    );
    return $this->tree;
  }
}
?>
