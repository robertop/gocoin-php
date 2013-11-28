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

    /// sample headers
    $headers = array(
        "'Content-Type' => 'application/json'",
        "'Content-Type' => 'application/text'"
    );

    $client = new Client( array(        
        'client_id' => "6f8d9bb9a577fa25e8187637c50d3c3df162599d7442e958b435d82b50c54c45",
        'client_secret' => "f44ac8d2dbd8ab0337a0f490e4ac2a97dd192bc35496a5616eac8a807185d30d",
        'scope' => "user_read_write",
        'headers' => $headers
    ));    
    
    $b_auth = $client->authorize_api();

    if ($b_auth) {
        $user = $client->api->user->self();
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
        <li>Created Date :&nbsp;&nbsp;<?php echo $user->created_at?></li>
        <li>Updated Date :&nbsp;&nbsp;<?php echo $user->updated_at?></li>
        <li>Image Url :&nbsp;&nbsp;<?php echo $user->image_url?></li>
        <li>Merchant Id :&nbsp;&nbsp;<?php echo $user->merchant_id?></li>                
    </ul>
    <?php endif;?>
</body>
</html>
