<?php
class HttpClient_Mock extends HttpClient {
  protected $lastUrl;
  protected $lastPostdata;

  protected $response;

  public function get($url){
    $this->lastUrl = $url;
    return $this->response;
  }

  public function post($url, $postdata){
    $this->lastUrl = $url;
    $this->lastPostdata = $postdata;
    return $this->response;
  }

  public function getLastUrl(){
    return $this->lastUrl;
  }

  public function getLastPostdata(){
    return $this->lastPostdata;
  }

  public function setResponse($response){
    $this->response = json_encode($response);
  }
}

