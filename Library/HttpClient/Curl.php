<?php

class HttpClient_Curl extends HttpClient {
  public function get($url){
    $c = curl_init($url);
    curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($c, CURLOPT_TIMEOUT, 20);
    $result = curl_exec($c);
    curl_close($c);
    return $result;
  }

  public function post($url, $postdata){
    $c = curl_init($url);
    curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($c, CURLOPT_TIMEOUT, 20);
    curl_setopt($c, CURLOPT_POST, true);
    curl_setopt($c, CURLOPT_POSTFIELDS, $postdata);

    $result = curl_exec($c);
    curl_close($c);
    return $result;
  }
}
