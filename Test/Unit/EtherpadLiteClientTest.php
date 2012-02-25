<?php

class EtherpadLiteClientTest extends PHPUnit_Framework_TestCase {
  protected function getHttpClient(){
    return new HttpClient_Mock();
  }
  protected function getClient($httpClient){
    return new EtherpadLiteClient($httpClient, 'theapikey', 'http://localhost:9001/api');
  }
  protected function formResponse($code, $message = '', $data = array()){
    return array(
      'code'    => (int) $code, 
      'message' => $message, 
      'data'    => $data
    );
  }

  public function testBasic(){
    $httpClient = $this->getHttpClient();
    $c = $this->getClient($httpClient);
    
    $httpClient->setResponse($this->formResponse(
      EtherpadLiteClient::CODE_OK
    ));

    $c->createGroup();
  }
}

