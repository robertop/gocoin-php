<?php
    require_once('../src/api.php');
    require_once('../src/auth.php');
    require_once('../src/client.php');

    session_start();     

    /*    
        Id      : your app client_id
        Secret  : your app secret id
        scope   : token scope
    */

    $headers = array(
        "'Content-Type' => 'application/json'",
        "'Content-Type' => 'application/text'"
    );

    $client = new Client( array(        
        'client_id' => "6f8d9bb9a577fa25e8187637c50d3c3df162599d7442e958b435d82b50c54c45",
        'client_secret' => "f44ac8d2dbd8ab0337a0f490e4ac2a97dd192bc35496a5616eac8a807185d30d",
        'scope' => "user_read_write invoice_read_write",
        'redirect_uri' => "http://gocoins.com/examples/login.php",
        'headers' => $headers
    ));    
    
    $client->initToken();
    $b_auth = $client->authorize_api();

    if ($b_auth) {
        $token = $client->getToken();
        echo "Access Token: ".$token;
    }
    
?>

<html>
<body>
    <?php if (!$b_auth) : ?>
        <a href="<?php echo $client->get_auth_url();?>">Login Go Coin</a>
    <?php endif;?>    
</body>
</html>
