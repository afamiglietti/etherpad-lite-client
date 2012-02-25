<?php

class BasicTest extends PHPUnit_Framework_TestCase {
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

  public function testListPads(){
    $c = $this->getClient();

    $c->createGroupPad($this->groupId, 'The Pad Name', 'The Pad Text');
    $data = $c->listPads($this->groupId);

    var_dump($data);
  }
}

