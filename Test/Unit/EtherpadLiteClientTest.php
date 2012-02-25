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

  public function testCreateGroup(){
    $httpClient = $this->getHttpClient();
    $c = $this->getClient($httpClient);
    
    $httpClient->setResponse($this->formResponse(
      EtherpadLiteClient::CODE_OK
    ));

    $c->createGroup();

    $this->assertEquals('POST', $httpClient->getLastMethod());
    $this->assertContains('createGroup', $httpClient->getLastUrl());
  }

  public function testCreateGroupIfNotExistsFor(){
    $httpClient = $this->getHttpClient();
    $c = $this->getClient($httpClient);
    
    $httpClient->setResponse($this->formResponse(
      EtherpadLiteClient::CODE_OK
    ));

    $groupMapper = 'theGroupMapper';
    $c->createGroupIfNotExistsFor($groupMapper);

    $this->assertEquals('POST', $httpClient->getLastMethod());
    $this->assertContains('createGroupIfNotExistsFor', $httpClient->getLastUrl());
    $this->assertContains($groupMapper, $httpClient->getLastPostdata());
  }

  public function testDeleteGroup(){
    $httpClient = $this->getHttpClient();
    $c = $this->getClient($httpClient);
    
    $httpClient->setResponse($this->formResponse(
      EtherpadLiteClient::CODE_OK
    ));

    $groupId = '12345';
    $c->deleteGroup($groupId);

    $this->assertEquals('POST', $httpClient->getLastMethod());
    $this->assertContains('deleteGroup', $httpClient->getLastUrl());
    $this->assertContains($groupId, $httpClient->getLastPostdata());
  }

  public function testListPads(){
    $httpClient = $this->getHttpClient();
    $c = $this->getClient($httpClient);
    
    $httpClient->setResponse($this->formResponse(
      EtherpadLiteClient::CODE_OK
    ));

    $groupId = '12345';
    $c->listPads($groupId);

    $this->assertEquals('GET', $httpClient->getLastMethod());
    $this->assertContains('listPads', $httpClient->getLastUrl());
    $this->assertContains($groupId, $httpClient->getLastUrl());
  }

  public function testCreateGroupPad(){
    $httpClient = $this->getHttpClient();
    $c = $this->getClient($httpClient);
    
    $httpClient->setResponse($this->formResponse(
      EtherpadLiteClient::CODE_OK
    ));

    $groupId = '12345';
    $padName = 'thePadName';
    $text    = 'The pad text';
    $c->createGroupPad($groupId, $padName, $text);

    $this->assertEquals('POST', $httpClient->getLastMethod());
    $this->assertContains('createGroupPad', $httpClient->getLastUrl());
    $this->assertContains($groupId, $httpClient->getLastPostdata());
    $this->assertContains($padName, $httpClient->getLastPostdata());
    $this->assertContains(urlencode($text), $httpClient->getLastPostdata());
  }
}

