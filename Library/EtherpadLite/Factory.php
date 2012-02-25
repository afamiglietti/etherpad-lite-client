<?php
class EtherpadLiteClient_Factory {
  protected $settings;  

  public function __construct(StdClass $settings){
    $this->settings = $settings;
  }

  public function make(){
    $httpClientClass = "HttpClient_".$this->settings->httpClient;

    if (!class_exists($httpClientClass)){
      throw new InvalidArgumentException("[{$this->settings->httpClient}] is not a valid HTTP client");
    }
    $httpClient = new $httpClientClass();

    return new EtherpadLiteClient($httpClient, $this->settings->apiKey, $this->settings->baseUrl);
  }
}

