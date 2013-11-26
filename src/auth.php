<?php
/**
 * GoCoin Api  Auth class
 * include functions related with authentication
 *  
 * @author Roman A <future.roman3@gmail.com> 
 * @version 1.0.0 
*/

class Auth {
    private $required_password_params = array('grant_type', 'client_id', 'client_secret', 'username', 'password', 'scope');
    private $required_code_params = array('grant_type', 'client_id', 'client_secret', 'code', 'redirect_uri');
    
    public function __construct($client) {
      $this->client = $client;      
    }
    
    public function get_auth_url() {        
        $url = $this->client->get_dashboard_url()."/auth";
        $options = array(
            'response_type' => 'code',
            'client_id' => $this->client->options['client_id'],
            'redirect_uri' => $this->client->get_current_url(),
            'scope' => 'invoice_read_write',
            'state' => '6734'
        );
        $url = $this->client->create_get_url($url, $options);
        return $url;
    }
    
    public function authenticate($options, $callback=false) {                  
      $required = array();
        if ($options['grant_type'] == 'password') {
            $required = $this->required_password_params;
        } elseif ($options['grant_type'] == 'authorization_code') {
            $required = $this->required_code_params;
        } else {
            throw new Exception('Authenticate: grant_type was not defined properly');
        }      
  
      $headers = $options['headers'] != null ? $options['headers'] : $this->client->default_headers;
      $body = $this->build_body($options, $required);
      $config = array(
        'host' => $options['host'],
        'path' => $options['path']. "/". $options['api_version'] . "/oauth/token",
        'method' => "POST",
        'port' => $this->client->port($options['secure']),
        'headers' => $headers,
        'body' => $body
      );
      return $this->client->raw_request($config);
    }
    
    public function build_body($options, $required) {
        $result = array();
        foreach ($required as $k) {
            if (!$options[$k]) {
                throw new Exception("Authenticate requires '".$k."' option.");
            }
            $result[$k] = $options[$k];
        }
        return $result;
    }
}
?>