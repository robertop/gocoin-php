<?php
/**
 * GoCoin Api
 * A PHP-based Gocoin client library with a focus on simplicity and ease of integration
 *  
 * @author Roman A <future.roman3@gmail.com> 
 * @version 1.0.0 
*/

require_once('api/merchant.php');
require_once('api/user.php');
require_once('api/apps.php');
require_once('api/invoices.php');
require_once('api/accounts.php');

class Api{   
            
    /**
     * Constructor for the API     
     * @param String $user_email  User's Email Address
     * @param String $api_key  User's Api Key.     
     */
    public function  __construct($client){ 
        $this->client = $client;               
        $this->user = new User($this);
        $this->merchant = new Merchant($this);
        $this->apps = new Apps($this);
        $this->invoices = new Invoices($this);
        $this->accounts = new Accounts($this);
    } 
    
    public function request($route, $options, $callback) {      
      if (!(($route != null) && is_string($route))) {
        throw new Exception('Api Request: Route was not defined');
      }
      if (!$this->client->getToken()) {
        throw new Exception('Api not ready: Token was not defined');
      }
      $headers = $options['header'] ? $options['headers']:  $this->client->default_headers;
      $headers['Authorization'] = "Bearer " + $this->client->token;
      $options = $this->client->options;      
      $config = array (
        'host' => $options['host'],
        'path' => "" + $options['path'] + "/" + $options['api_version'] + $route,
        'method' => options.method,
        'port' => $this->client->port($options['secure']),
        'headers' => $headers,
        'body' => $body
      );
      return $this->client->raw_request($config);
    }
}

?>