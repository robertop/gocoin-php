<?php 

/**
 * GoCoin Api
 * Client class
 * Main interface to use GoCoin Api
 *  
 * @author Roman A <future.roman3@gmail.com> 
 * @version 1.0.0 
*/

require_once('api.php');
require_once('auth.php');

class Client {            
    private $default_options = array (
                  'client_id' => null,
                  'client_secret' =>null,
                  'host' => 'llamacoin-api.herokuapp.com',
                  'dashboard_host' => 'dashboard.llamacoin.com',
                  'port' => null,
                  'path' => '/api',
                  'api_version' => 'v1',
                  'secure' => true,
                  'method' => 'GET',
                  'headers' => null,
                  'request_id' => null
            );
    public $default_headers = array('Content-Type' => 'application/json');    
    public $options = array();
    public $headers = array();    
    private $token;
    
    
    public function  __construct($options){ 
        if ($options == null) {
            $options = array();
        }
        $this->set_options($options);          
        $this->headers = $options['headers'] != null ? $options['headers'] : $this->default_headers;
        if ($this->options['request_id'] != null) {
            $this->headers['X-Request-Id'] = $this->options['request_id'];
        }
        $this->auth = new Auth($this);
        $this->api = new Api($this);
        $this->user = $this->api->user;
        $this->merchant = $this->api->merchant;
        $this->apps = $this->api->apps;
        $this->invoices = $this->api->invoices;
        $this->accounts = $this->api->accounts;
    }              
   
    public function set_options($options) {
        $this->options = $this->default_options;        
        foreach ($options as $key => $value) {            
            $this->options[$key] = $options[$key];            
        }        
    }
    
    public function get_user() {        
        if ($this->token !== null) {
            return $this->token;
        }        
        $this->token = $this->get_user_from_request();
        return $this->token;
    }
    
    public function get_user_from_request() {  
           
        if (isset($_GET['code'])) {            
            $auth_code = $_GET['code'];
            $options['grant_type'] = "authorization_code";
            $options['code'] = $auth_code;
            $options['client_id'] = $this->options['client_id'];
            $options['client_secret'] = $this->options['client_secret'];
            $options['redirect_uri'] = $this->get_current_url();            
            $options = array_merge($options, $this->options);
            $token = $this->auth->authenticate($options, null);                        
            $this->setToken($token);
        } else {
            return false;
        }
        return true;
    }
    
    public function setToken($token) {
      $this->token = token;
    }
    
    public function getToken() {
      return $this->token;
    }
    
    public function get_api_url($options) {
        $url = $this->request_client($options['secure'])."://".$this->options['host'].$options['path']."/".$options['api_version'];
        return $url;
    }
    
    public function get_dashboard_url() {
        $url = $this->request_client($this->options['secure'])."://".$this->options['dashboard_host'];
        return $url;
    } 
    
    public function get_auth_url() {        
        /*$url = $this->get_dashboard_url($this->options)."/auth";
        $options = array(
            'response_type' => 'code',
            'client_id' => $this->options['client_id'],
            'redirect_uri' => $this->get_current_url(),
            'scope' => 'user_read',
        );
        $url = $this->create_get_url($url, $options);*/
        return $this->auth->get_auth_url();
    }         
    
    public function authenticate($options, $callback) {      
      $auth_result = $this->auth->authenticate($options, $callback);      
      return $auth_result;
    }
    
    public function request_client($secure) {
      if ($secure == null) {
        $secure = true;
      }
      if ($secure) {
        return 'https';
      } else {
        return 'http';
      }
    }
    
    public function port($secure) {
      if ($secure == null) {
        $secure = true;
      }
      if ($this->options->port != null) {
        return $this->options->port;
      } else if ($secure) {
        return 443;
      } else {
        return 80;
      }
    }
    
    public function strip_secure_from_raw($obj) {
      $strippable = array('client_secret', 'password');
      if ($obj->body != null) {
        $obj->body = json_decode($obj->body);
        foreach( $strippable as $k ) {
          if ($obj->body[$k] != null) {
            return $obj->body[$k] = "<" + $k + ">";
          }
        }
      }
      if ($obj->headers['Authorization'] != null) {
        $obj->headers['Authorization'] = '<bearer>';
      }
      return $obj;
    } 
    
    public function raw_request($config) {        
      $url = $this->request_client($options['secure'])."://".$config['host'] . $config['path'];
      $headers = $this->default_headers;
          
      return $this->do_request($url, $config['body'], $config['headers'], $config['method']);
    }
    
     // Helper Functions   
    
     /**
     * createGetUrl
     * Create complete url for GET method with auth parameters     
     * @param String $url The base URL for api
     * @param Array $params The parameters to pass to the URL
     */    
    public function create_get_url($url,$params){
 
       if(!empty($params) && $params){
            foreach($params as $param_name=>$param_value){
                $arr_params[] = "$param_name=".$param_value;
            }
            $str_params = implode('&',$arr_params);                        
            $url = trim($url) . '?' . $str_params;
        }        
        return $url;
    }
    
   
    /**
     * do_request
     * Performs a cUrl request with a url . The useragent of the request is hardcoded
     * as the Google Chrome Browser agent
     * @param String $url The base url to query
     * @param Array $params The parameters to pass to the request
     * @param $headers curl header
     * @param $method  curl type
     */
     
    private function do_request($url, $params=false, $headers, $method="POST"){    
        if (!$ch) {
          $ch = curl_init();
        }

        $opts = array(
            CURLOPT_CONNECTTIMEOUT => 30,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_TIMEOUT        => 60,            
        );
        if ($method == "POST") {
            $opts[CURLOPT_POST] = 1;
            $opts[CURLOPT_POSTFIELDS] = $params;
        }
        
       /* if ( isset($_SERVER['HTTP_USER_AGENT']) ) {
            $opts[CURLOPT_USERAGENT] = $_SERVER['HTTP_USER_AGENT'];
        } else {
            // Handle the useragent like we are Google Chrome
            $opts[CURLOPT_USERAGENT] = 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US) AppleWebKit/525.13 (KHTML, like Gecko) Chrome/0.X.Y.Z Safari/525.13.';
        }*/
        $opts[CURLOPT_URL] = $url;
        $opts[CURLOPT_SSL_VERIFYPEER] = false;
        
        if (isset($opts[CURLOPT_HTTPHEADER])) {
            $opts[CURLOPT_HTTPHEADER] = array_merge($this->default_headers, $opts[CURLOPT_HTTPHEADER]);
        } else {
            $opts[CURLOPT_HTTPHEADER] = $this->default_headers;
        } 
               
        curl_setopt_array($ch, $opts);
        
        $result = curl_exec($ch);
        $info=curl_getinfo($ch);        
       
        if ($result === false) {
          $e = new Exception('CurlError'.$result);
          curl_close($ch);
          throw $e;
        }
        curl_close($ch);
        var_dump($result);  
        return $result;
    }
    
    /**
    * Returns the Current URL, drop params what is included in default params
    *  return string: Current Url
    */
    public function get_current_url() {
        if (isset($_SERVER['HTTPS']) &&
            ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) ||
            isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
            $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
          $protocol = 'https://';
        }
        else {
          $protocol = 'http://';
        }
        $currentUrl = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $parts = parse_url($currentUrl);

        $query = '';
        if (!empty($parts['query'])) {
          // drop known params          
          $params = explode('&', $parts['query']);
          $retained_params = array();
          foreach ($params as $param) {
            if ($this->shouldDropParam($param)) {
              $retained_params[] = $param;
            }
          }

          if (!empty($retained_params)) {
            $query = '?'.implode($retained_params, '&');
          }
        }
        
        // use port if non default
        $port =
          isset($parts['port']) &&
          (($protocol === 'http://' && $parts['port'] !== 80) ||
           ($protocol === 'https://' && $parts['port'] !== 443))
          ? ':' . $parts['port'] : '';

        // rebuild
        return $protocol . $parts['host'] . $port . $parts['path'] . $query;
    }
    
    public function shouldDropParam($param) {        
        $drop_params = array('code');
        foreach ( $drop_params as $drop_param ) {
            if (strpos($param, $drop_param) === 0) {
                return false;
            }
        }
        return true;
    }
}

?>