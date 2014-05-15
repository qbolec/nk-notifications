<?php
error_reporting(E_ALL);
ini_set('display_errors','stderr');

if(!function_exists('curl_init')) {
  die("curl extension not available\n");
}

require 'OAuth.php';
require 'NKNotificationsSender.php';

function require_option($name){
  $options = getopt(null,array(
    'uri_params:',
    'body:',
    'link_title:',
    'key:',
    'secret:',
  ));
  if(!array_key_exists($name,$options)){
    die("you must provide --$name argument\n");
  }
  return $options[$name];
}
$uri_params = array();
parse_str(require_option('uri_params'),$uri_params);
$body = require_option('body');
$link_title = require_option('link_title');
$key = require_option('key');
$secret = require_option('secret');

$sender = new NKNotificationsSender($key,$secret);
$recipients_ids = array();
$batch_no = 0;
while(!feof(STDIN)){
  $person_id = trim(fgets(STDIN));
  if($person_id){
    $recipients_ids[] = $person_id;
  }
  if(!$person_id || count($recipients_ids) == NKNotificationsSender::MAX_RECIPIENTS_PER_REQUEST){
    echo "Sending batch #" . $batch_no++ . "...\n"; 
    try{
      $sender->send($body,$link_title,$uri_params,$recipients_ids);
      echo "OK..\n";
    }catch(NKException $e){
      echo "ERR:" . $e->getMessage() . "\n";
    }
    $recipients_ids = array();
  }
  if(!$person_id){
    break;
  }
}
