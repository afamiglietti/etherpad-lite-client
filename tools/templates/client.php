// The following code is automatically generated by ./tools/generate.php
// please edit the files in ./tools/templates/ instead of editing this
// file directly.

class EtherpadLiteClient {

  const API_VERSION             = '<?=$version?>';

  const CODE_OK                 = 0;
  const CODE_INVALID_PARAMETERS = 1;
  const CODE_INTERNAL_ERROR     = 2;
  const CODE_INVALID_FUNCTION   = 3;
  const CODE_INVALID_API_KEY    = 4;

  protected $apiKey = "";
  protected $baseUrl = "http://localhost:9001/api";
  
  public function __construct($apiKey, $baseUrl = null){
    if (strlen($apiKey) < 1){
      throw new InvalidArgumentException("[{$apiKey}] is not a valid API key");
    }
    $this->apiKey  = $apiKey;

    if (isset($baseUrl)){
      $this->baseUrl = $baseUrl;
    }
    if (!filter_var($this->baseUrl, FILTER_VALIDATE_URL)){
      throw new InvalidArgumentException("[{$this->baseUrl}] is not a valid URL");
    }
  }

  protected function get($function, array $arguments = array()){
    return $this->call($function, $arguments, 'GET');
  }

  protected function post($function, array $arguments = array()){
    return $this->call($function, $arguments, 'POST');
  }

  protected function call($function, array $arguments = array(), $method = 'GET'){
    $arguments['apikey'] = $this->apiKey;
    $arguments = http_build_query($arguments, '', '&');
    $url = $this->baseUrl."/".self::API_VERSION."/".$function;
    if ($method !== 'POST'){
      $url .=  "?".$arguments;
    }
    // use curl of it's available
    if (function_exists('curl_init')){
      $c = curl_init($url);
      curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($c, CURLOPT_TIMEOUT, 20);
      if ($method === 'POST'){
        curl_setopt($c, CURLOPT_POST, true);
        curl_setopt($c, CURLOPT_POSTFIELDS, $arguments);
      }
      $result = curl_exec($c);
      curl_close($c);
    // fallback to plain php
    } else {
      $params = array('http' => array('method' => $method, 'ignore_errors' => true, 'header' => 'Content-Type:application/x-www-form-urlencoded'));
      if ($method === 'POST'){
        $params['http']['content'] = $arguments;
      }
      $context = stream_context_create($params);
      $fp = fopen($url, 'rb', false, $context);
      $result = $fp ? stream_get_contents($fp) : null;
    }
    
    if(!$result){
      throw new UnexpectedValueException("Empty or No Response from the server");
    }
    
    $result = json_decode($result);
    if ($result === null){
      throw new UnexpectedValueException("JSON response could not be decoded");
    }
    return $this->handleResult($result);
  }

  protected function handleResult($result){
    if (!isset($result->code)){
      throw new RuntimeException("API response has no code");
    }
    if (!isset($result->message)){
      throw new RuntimeException("API response has no message");
    }
    if (!isset($result->data)){
      $result->data = null;
    }

    switch ($result->code){
      case self::CODE_OK:
        return $result->data;
      case self::CODE_INVALID_PARAMETERS:
      case self::CODE_INVALID_API_KEY:
        throw new InvalidArgumentException($result->message);
      case self::CODE_INTERNAL_ERROR:
        throw new RuntimeException($result->message);
      case self::CODE_INVALID_FUNCTION:
        throw new BadFunctionCallException($result->message);
      default:
        throw new RuntimeException("An unexpected error occurred whilst handling the response");
    }
  }

  <?php
  foreach($methods as $method){
    render(__DIR__.'/method.php', $method);
  }
  ?>

}

