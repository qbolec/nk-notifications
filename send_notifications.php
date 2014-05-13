<?php
error_reporting(E_ALL);
ini_set('display_errors','stderr');

if(!function_exists('curl_init')) {
  die("curl extension not available\n");
}

require 'OAuth.php';
require 'NKNotificationsSender.php';


$options = getopt(null,array(
  'uri_params:',
  'body:',
  'link_title:',
));
$uri_params = array();
parse_str($options['uri_params'],$uri_params);
$body = $options['body'];
$link_title = $options['link_title'];

$sender = new NKNotificationsSender();
$recipients_ids = array();
while(!feof(STDIN)){
  $person_id = trim(fgets(STDIN));
  if(!$person_id){
    break;
  }
  $recipients_ids[] = $person_id;
  if(count($recipients_ids) == 100){ //you can send the same notification to at most 100 users with single call
    var_dump($sender->send($body,$link_title,$uri_params,$recipients_ids));
    $recipients_ids = array();
  }
}
if(!empty($recipients_ids)){
  var_dump($sender->send($body,$link_title,$uri_params,$recipients_ids));
}
