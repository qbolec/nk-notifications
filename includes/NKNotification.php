<?php
class NKNotification implements INKNotification
{
  private $body;
  private $title;
  private $uri_params;

  public function __construct($body,$title,array $uri_params){
    $string_validator = new StringValidator();
    $string_validator->must_match($body);
    $string_validator->must_match($title);
    $string_to_string_validator = new MapValidator($string_validator,$string_validator);
    $string_to_string_validator->must_match($uri_params);

    $this->body = $body;
    $this->title = $title;
    $this->uri_params = $uri_params;
  }
  public function get_body(){
    return $this->body;
  }
  public function get_title(){
    return $this->title;
  }
  public function get_uri_params(){
    return $this->uri_params;
  }
  public function get_urls(){
    return array();//not supported anyway
  }
  public function get_type(){
    return 'notification';
  }
}
?>
