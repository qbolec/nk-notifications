<?php
class NKException extends Exception{}
class NKNotificationsSender{
  private $endpoint_url = 'http://opensocial.nk-net.pl/v09/social/rest/messages/@me/@self/@outbox';
  private $consumer;
  const MAX_RECIPIENTS_PER_REQUEST = 100;//The NK's API allows at most this many recipients in a single request

  /**
   * @param $key string Your app's key used with NK's API
   * @param $secret string The secret for that key.
   */
  public function __construct($key,$secret){
    $this->consumer = new OAuthConsumer($key,$secret);
  }

  /**
   * @param $body string The body of the message (must be a simple text, without HTML tags or entities)
   * @param $link_title string The clickable text used for the button attached to the message. This should be a simple text as well.
   * @param $uri_params array A map<string,string> from keys to values. This can be arbitrary parametrs that you want to be passed via URL params to your app after clicking the button.
   * @param $icon_uri string An URI to an image attached to the message. Use null if no image is provided.
   * @param $recipients_ids array The list of person.id-s of recipients
   */
  public function send($body,$link_title,array $uri_params,$icon_uri,array $recipients_ids){
    foreach(array_chunk($recipients_ids,self::MAX_RECIPIENTS_PER_REQUEST) as $recipients_ids_chunk){
      $data = array(
        'title' => $link_title,
        'body' => $body,
        'type' => 'notification',
        'recipients' => $recipients_ids_chunk,
      );
      if(!empty($icon_uri)){
        $data['urls'] = array(array('type' => 'icon', 'value' => $icon_uri));
      }
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
    }
  }

};
