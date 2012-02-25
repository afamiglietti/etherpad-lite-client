<?php
abstract class HttpClient {
  abstract public function get($url);
  abstract public function post($url, $postdata);
}


