<?php
class NKException extends Exception{}
class NKNotificationsSender{
  private $endpoint_url = 'http://opensocial.nk-net.pl/v09/social/rest/messages/@me/@self/@outbox';
  private $app_id = 273;
  private $key = 'dupa biskupa';
  private $secret = '8a6eafc1-9971-4559-b7aa-bb1b558068c5';
  private $consumer;

  public function __construct(){
    $this->consumer = new OAuthConsumer($this->key, $this->secret);
  }

  public function send($body,$link_title,array $uri_params,array $recipients_ids){
    $data = array(
      'title' => $link_title,
      'body' => $body,
      'type' => 'notification',
      'recipients' => $recipients_ids,
    );
    if(!empty($uri_params)){
      $data['nkOptUrlParams'] = $uri_params;
    }
    $jsoned_data = json_encode($data);
    $body_hash = base64_encode(sha1($jsoned_data, true));

    $request = OAuthRequest::from_consumer_and_token($this->consumer, null, 'POST', $this->endpoint_url, array('oauth_body_hash' => $body_hash));
    $request->sign_request(new OAuthSignatureMethod_HMAC_SHA1(), $this->consumer, null);

    $handle = curl_init($request->to_url());
    curl_setopt($handle, CURLOPT_POST, true);
    curl_setopt($handle, CURLOPT_POSTFIELDS, $jsoned_data);
    curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($handle); 
    if($response === false) {
      throw new NKException('network error making HTTP request');
    }
    $code = curl_getinfo($handle, CURLINFO_HTTP_CODE);
    if($code !== 200) {
      throw new NKException("HTTP error $code, body: $response");
    }
    return $response;
  }

};
