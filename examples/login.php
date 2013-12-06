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
        'client_id' => "PLACE_YOUR_CLIENT_ID_HERE",
        'client_secret' => "PLACE_YOUR_CLIENT_SECRET_HERE",
        'scope' => "user_read_write invoice_read_write",
        'redirect_uri' => "PLACE_YOUR_CALLBACK_URL_SECRET_HERE",
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
