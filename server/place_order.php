<?php

session_start();

include('connection.php');

if(isset($_POST['place_order'])){

    // 1. get user info and store it in database
    $name = $_POST['name'];
    $email = $_POST['email'];
    $city = $_POST['city'];
    $address = $_POST['address'];
    $state = $_POST['state'];
    $zip = $_POST['zip'];
    $order_cost = $_SESSION['total'];
    $order_status = "on hold";
    $user_id = $_SESSION['user_id'];
    $order_date = date('Y-m-d H:i:s');

    $stmt = $conn->prepare("INSERT INTO orders (order_cost, order_status, user_id, email, city, state, address, zip, order_date)
    VALUES (?,?,?,?,?,?,?,?,?)");

    $stmt->bind_param('dsissssis', $order_cost, $order_status, $user_id, $email, $city, $state, $address, $zip, $order_date);

    $stmt->execute();

    // 2. issue new order and store order info in database
    $order_id = $stmt->insert_id;

    

    // 3. get products from cart (from session)
    // $_SESSION['cart'];  [ 4=>[], 5=>[] ]
    foreach($_SESSION['cart'] as $key => $value){
        $product = $_SESSION['cart'] [$key];
        $product_id = $product['product_id'];
        $product_name = $product['product_name'];
        $product_image = $product['product_image'];
        $price = $product['price'];
        $quantity = $product['quantity'];
        
    // 4. store each single item in order_items database
        $stmt1 = $conn->prepare("INSERT INTO order_items (order_id, product_id, product_name, quantity, price, user_id, order_date) VALUES (?,?,?,?,?,?,?)");

        $stmt1->bind_param('iisiids', $order_id, $product_id, $product_name, $quantity, $user_id, $price, $order_date);

        $stmt1->execute();


    }



    // 5. remove everything form cart --> dealy until payment is done 
    //unset($_SESSION['cart']);

    // 6. inform user whether everything is fine or there is a problem
    header('location:../payment.php?order_status=order placed successfully');

}



?>