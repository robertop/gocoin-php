<?php
    require_once('../src/api.php');
    require_once('../src/auth.php');
    require_once('../src/client.php');
    session_start();
                                                                                              
    /*    
        Id:    your app client_id
        Secret:    your app secret id
        scope: read scope
    */

    $client = new Client( array(        
        'client_id' => "ecdf74dd26a356c6c20a7b629ccf140c7dcfcb031b80a776de04d616051bd8ab",
        'client_secret' => "79c2cc4373d998496bbf8e3f0f5be457cbe4a0050c5deef7d617ac5211ef343e",        
    ));    
    
    $b_auth = $client->authroize_api();        

    if ($b_auth) {
        $user = $client->api->user->self();
        print_r($result);
    }
    
?>

<html>
<body>
    <?php if ($user) : ?>
    <ul>
        <li>User Id : &nbsp;&nbsp;<?php echo $user->id?></li>
        <li>User Email : &nbsp;&nbsp;<?php echo $user->email?></li>
        <li>First Name : &nbsp;&nbsp;<?php echo $user->first_name?></li>
        <li>Last Name :&nbsp;&nbsp;<?php echo $user->last_name?></li>
        <li>Created Date :&nbsp;&nbsp;<?php echo $user->create_at?></li>
        <li>Updated Date :&nbsp;&nbsp;<?php echo $user->updated_at?></li>
        <li>Image Url :&nbsp;&nbsp;<?php echo $user->image_url?></li>
        <li>Merchant Id :&nbsp;&nbsp;<?php echo $user->merchant_id?></li>                
    </ul>
    <?php endif;?>
</body>
</html>
