<?php

class GroupTest extends PHPUnit_Framework_TestCase {
  protected $factory;

  protected $groupId;

  protected function getClient(){
    if (!isSet($factory)){
      if (!file_exists(BASE_DIR.'/config.test.ini')){
        $this->fail("[".BASE_DIR."/config.test.ini] must exist to run the full-stack tests");
      }
      $settings = (object) parse_ini_file(BASE_DIR.'/config.test.ini');
      $factory = new EtherpadLiteClient_Factory($settings);
    }
    return $factory->make();
  }

  protected function setUp(){
    $c = $this->getClient();
    $data = $c->createGroup();
    $this->groupId = $data->groupID;
  }

  protected function tearDown(){
    $c = $this->getClient();
    $c->deleteGroup($this->groupId);
  }

  public function testSmoke(){
    $c = $this->getClient();

    $c->createGroupPad($this->groupId, 'The Pad Name 1', 'The Pad Text');
    $c->createGroupPad($this->groupId, 'The Pad Name 2', 'The Pad Text');
    $c->createGroupPad($this->groupId, 'The Pad Name 3', 'The Pad Text');

    $data = $c->listPads($this->groupId);

    $this->assertTrue(isset($data->padIDs), "No padIDs specified in response");
    $this->assertEquals(3, sizeOf($data->padIDs), "3 pads should have been created");
  }

  public function testDuplicateCheck(){
    $c = $this->getClient();

    $c->createGroupPad($this->groupId, 'The Pad Name 1', 'The Pad Text');

    try {
      $c->createGroupPad($this->groupId, 'The Pad Name 1', 'The Pad Text');
      $this->fail("Duplicate pad name should have thrown exception");
    } catch (InvalidArgumentException $e) {
      $this->assertEquals(EtherpadLiteClient::CODE_INVALID_PARAMETERS, $c->getLastRawResult()->code);
    }
  }
}

