<?php
define('BASE_DIR', realpath(dirname(__FILE__).'/..'));
require BASE_DIR.'/Library/HttpClient.php';
require BASE_DIR.'/Library/HttpClient/Curl.php';
require BASE_DIR.'/Library/HttpClient/Stream.php';
require BASE_DIR.'/Library/EtherpadLite/Client.php';

if (!file_exists(BASE_DIR.'/config.ini')){
  throw new Exception("[".BASE_DIR."/config.ini] must exist");
}
return (object) parse_ini_file(BASE_DIR.'/config.ini', true);

