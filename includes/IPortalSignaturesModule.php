<?php
interface IPortalSignaturesModule
{
  /*
   * @returns OAuthConsumer
   */
  public function get_consumer();
  public function sign_request(OAuthRequest $request, OAuthConsumer $consumer);
}
?>
