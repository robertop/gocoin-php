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
        'client_id' => "PLACE_YOUR_CLIENT_ID_HERE",
        'client_secret' => "PLACE_YOUR_CLIENT_SECRET_HERE",
        'scope' => "user_read_write",
        'headers' => $headers
    ));    
    
    $b_auth = $client->authorize_api();

    if ($b_auth) {
        $user = $client->api->user->self();
        if (!$user) {
            echo $client->getError();
        }
        // get the exchange rate from the gocoin web service
        $get_the_xrate = $client->get_xrate();
        if (!$get_the_xrate) {
            echo $client->getError();
        }
    } else {
        echo $client->getError();
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

    <?php if ($get_the_xrate) : ?>

        <span><b>Timestamp:</b> <?php echo $get_the_xrate->timestamp; ?></span>
        <br>
        <span><b>xrate Price:</b> <?php echo $get_the_xrate->prices->BTC->USD; ?></span>

    <?php endif;?>

</body>
</html>
