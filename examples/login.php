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

    /*$headers = array(
        "'Content-Type' => 'application/json'",
        "'Content-Type' => 'application/text'"
    );*/
    
    
/*Id:    ecdf74dd26a356c6c20a7b629ccf140c7dcfcb031b80a776de04d616051bd8ab
Secret:    79c2cc4373d998496bbf8e3f0f5be457cbe4a0050c5deef7d617ac5211ef343e */


    $client = new Client( array(        
        'client_id' => "ecdf74dd26a356c6c20a7b629ccf140c7dcfcb031b80a776de04d616051bd8ab",
        'client_secret' => "79c2cc4373d998496bbf8e3f0f5be457cbe4a0050c5deef7d617ac5211ef343e",
        'scope' => "user_read_write invoice_read_write",
        'redirect_uri' => "http://gocoins.com/examples/login.php",
        'headers' => $headers
    ));    
    
    $client->initToken();
    $b_auth = $client->authorize_api();

    if ($b_auth) {
        $token = $client->getToken();
        echo "Access Token: ".$token;
    }  else {
        echo $client->getError();
    }
    
?>

<html>
<body>
    <?php if (!$b_auth) : ?>
        <a href="<?php echo $client->get_auth_url();?>">Login Go Coin</a>
    <?php endif;?>    
</body>
</html>
