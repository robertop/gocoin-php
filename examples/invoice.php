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
        'scope' => "user_read_write invoice_read_write",
        'headers' => $headers
    ));    
    
    $b_auth = $client->authorize_api();

    // data for invoice creation
    $my_data = array (
        "price_currency" => "BTC",
        "base_price" => 20000,
        "base_price_currency" => "USD",
        "confirmations_required" => 6,
        "notification_level" => "all"
    );

    $data_string = json_encode($my_data);


    if ($b_auth) {
        // retrieve user details
        $user = $client->api->user->self();

        // get an invoice by id
        // $get_my_invoice = $client->api->invoices->get("PUT_YOUR_INVOICE_ID_HERE");

        // search invoice - no params returns all avail
        //$fake_params = array();
        //$search_my_invoices = $client->api->invoices->search($fake_params);


        // stick merchant id into params for invoice creation
        $invoice_params = array(
            'id' => $user->merchant_id,
            'data' => $data_string
        );

        // create an invoice
        $my_invoice = $client->api->invoices->create($invoice_params);


    }



?>

<html>
<body>

    <?php if ($my_invoice) : ?>
        <ul>
            <li>Invoice Id : &nbsp;&nbsp;<?php echo $my_invoice->id?></li>
            <li>Status : &nbsp;&nbsp;<?php echo $my_invoice->status?></li>
            <li>Payment Address : &nbsp;&nbsp;<?php echo $my_invoice->payment_address?></li>
            <li>Price : &nbsp;&nbsp;<?php echo $my_invoice->price?></li>
            <li>Price Currency : &nbsp;&nbsp;<?php echo $my_invoice->price_currency?></li>
            <li>Base Price : &nbsp;&nbsp;<?php echo $my_invoice->base_price?></li>
            <li>Base Price Currency : &nbsp;&nbsp;<?php echo $my_invoice->base_price_currency?></li>
        </ul>
    <?php endif;?>

    <br><br><br>

    <?php if ($user) : ?>
    <ul>
        <li>User Id : &nbsp;&nbsp;<?php echo $user->id?></li>
        <li>User Email : &nbsp;&nbsp;<?php echo $user->email?></li>
        <li>Name : &nbsp;&nbsp;<?php echo $user->first_name?>&nbsp;<?php echo $user->last_name?></li>
        <li>Merchant Id :&nbsp;&nbsp;<?php echo $user->merchant_id?></li>
    </ul>
    <?php endif;?>
</body>
</html>
