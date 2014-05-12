<?php
class PortalSignaturesModule extends MultiInstance implements IPortalSignaturesModule
{
  protected function get_signature_method(){
    return new OAuthSignatureMethod_HMAC_SHA1();
  }
  public function sign_request(OAuthRequest $request,OAuthConsumer $consumer){
    $signature_method = $this->get_signature_method();
    $request->sign_request($signature_method, $consumer, null);
  }
  public function get_consumer(){
    $oauth_config = Config::get_instance()->get('oauth');
    $key = $oauth_config['key'];
    $secret = $oauth_config['secret'];
    $consumer = new OAuthConsumer($key, $secret);
    return $consumer;
  }
}
?>
