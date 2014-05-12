<?php
class SendNotification extends CliScript
{
  protected function get_args_validator(){
    return new RecordValidator(array(
      'body' => new StringValidator(),
      'title' => new StringValidator(),
      'query_string' => new StringValidator(),
      'send' => new OptionalValidator(new StringValidator()),
    ));
  }
  public function run(){
    $body = $this->options['body'];
    $title = $this->options['title'];
    $query_string = $this->options['query_string'];
    $params = array();
    if(''!==$query_string){
      parse_str($query_string,$params);
    }
    $person_validator = new PersonValidator();
    $persons_ids = array();
    try{
      while(!$this->eof()){
        $person_id = $this->get_line();
        if(""===$person_id){
          break;
        }
        $person_validator->must_match($person_id);
        $persons_ids[] = $person_id;
      }
    }catch(EOFException $e){
    }
    echo "msg:\n" . $body . "\nlink text:\n" . $title . "\nand params:" . json_encode($params) . "\n";
    foreach($persons_ids as $user_id){
      echo "to: " . $user_id . "\n";
    }
    if('yes' === Arrays::get($this->options,'send')){
      echo "Sending...\n";
      $response = $this->send($body,$title,$params,$persons_ids);
      var_dump($response);
    }else{
      echo "To actually send it, use --send yes\n";
    }
  }
  protected function send($body,$title,$uri_params,array $recipients_ids){
    $api_module = TheApplication::get_instance()->get_nk_rest_api_module();
    return $api_module->send_server_to_user_notification($body,$title,$uri_params,$recipients_ids);
  }
}
?>
