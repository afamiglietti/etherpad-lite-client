<?php
require_once __DIR__.'/../../etherpad-lite-client.php';

class AuthorTest extends \PHPUnit_Framework_TestCase {

  protected function newClient(){
    // API Key is the default for a new install
    return new EtherpadLiteClient("dcf118bfc58cc69cdf3ae870071f97149924f5f5a9a4a552fd2921b40830aaae");
  }

  public function testAuthor(){
    $client = $this->newClient();

    $a = $client->createAuthor('Bob');
    $this->assertTrue(is_string($a->authorID));

    $n = $client->getAuthorName($a->authorID);
    $this->assertEquals("Bob", $n);
  }

}
