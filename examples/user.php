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
        'client_secret' => "f834df3ae2a18256ed2a20d719b2f88b57756ffb5d1df50ab53aa35efecda28e",
        'scope' => "user_read_write",
        'headers' => $headers
    ));    
    
    $b_auth = $client->authorize_api();

    if ($b_auth) {
        $user = $client->api->user->self();

        // get the exchange rate from the gocoin web service
        $get_the_xrate = $client->get_xrate();
    }

?>

<html>
<body>


    <?php if ($user) : ?>
        <b>User details:</b>
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

    <?php if ($get_the_xrate) : ?>

        <span><b>Timestamp:</b> <?php echo $get_the_xrate->timestamp; ?></span>
        <br>
        <span><b>xrate Price:</b> <?php echo $get_the_xrate->prices->BTC->USD; ?></span>

    <?php endif;?>

</body>
</html>
