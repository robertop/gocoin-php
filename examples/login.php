<?php
    require_once('src/api.php');
    require_once('src/auth.php');
    require_once('src/client.php');
    
    /*Id:    5fdcc0633398132f1ce92dd8b4179a9336d7279e53d043b3d64ca1e15cc92629
    Secret:    c9f628dde215770f00dfdcb64afe920964df832ce062555df3e8aa4051445d35*/
    
    $client = new Client( array(        
        'client_id' => "5fdcc0633398132f1ce92dd8b4179a9336d7279e53d043b3d64ca1e15cc92629",
        'client_secret' => "cdbd87aa50d2023496e8aa6a2f515c0b35e5e0daa10990fda2691a6d26b4b8f7",        
    ));    
    
    $user = $client->get_user();        

    if ($user) {
        $token = $client->getToken();        
    } 
    
?>

<html>
<body>
    <?php if (!$user) : ?>
        <a href="<?php echo $client->get_auth_url();?>">Login Go Coin</a>
    <?php endif;?>    
</body>
</html>
