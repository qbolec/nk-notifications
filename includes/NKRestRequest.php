<?php
abstract class NKRestRequest implements INKRestRequest
{
  private function get_portal_signatures(){
    return TheApplication::get_instance()->get_portal_signatures_module();
  }
  private function get_consumer(){
    return $this->get_portal_signatures()->get_consumer();
  }
  protected function post_json($endpoint_url, $jsoned_data){
    $params = array();
    $consumer = $this->get_consumer();

    $extended_params = OAuthRequest::extend_parameters($params, $jsoned_data, $consumer);
    $request = new OAuthRequest(IRequest::METHOD_POST, $endpoint_url, $extended_params);

    $this->get_portal_signatures()->sign_request($request, $consumer);

    //na razie brzydko i nieobiektowo bo mi sie myśleć nie chce
    //@todo: wydzielić/znaleźć jakąś klasę do cURLa
    //@todo: wydzielić jakąś klasę do budowania requestów

    // make HTTP request
    $handle = curl_init($endpoint_url . '?' . http_build_query($params));
    curl_setopt($handle, CURLOPT_POST, true);
    curl_setopt($handle, CURLOPT_HTTPHEADER, array(
      $s=$request->to_header('nk.pl'), 
      'Content-Type: application/json'
    ));
    curl_setopt($handle, CURLOPT_POSTFIELDS, $jsoned_data);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    return curl_exec($handle); 
  }
}
?>
