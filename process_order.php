<?php

include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
    // Redirect or handle unauthorized access
    header('location:user_login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order'])) {
    $name = $_POST['name'];
    $number = $_POST['number'];
    $email = $_POST['email'];
    $address = 'flat no. ' . $_POST['flat'] . ', ' . $_POST['city'];
    $total_products = $_POST['total_products'];
    $total_price = $_POST['total_price'];

    // Check if the cart is not empty
    $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
    $check_cart->execute([$user_id]);

    if ($check_cart->rowCount() > 0) {
        // Insert order into the database
        $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, name, number, email, address, total_products, total_price) VALUES(?,?,?,?,?,?,?)");
        $insert_order->execute([$user_id, $name, $number, $email, $address, $total_products, $total_price]);

        // Delete items from the cart
        $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
        $delete_cart->execute([$user_id]);

        // Respond with success message or redirect
        $response = [
            'status' => 'success',
            'message' => 'Order placed successfully!',
        ];

        // You can choose to echo this response if you are using AJAX, or redirect the user
        // header('location: success_page.php');
        echo json_encode($response);
    } else {
        // Respond with an error message
        $response = [
            'status' => 'error',
            'message' => 'Your cart is empty!',
        ];

        // You can choose to echo this response if you are using AJAX, or redirect the user
        // header('location: error_page.php');
        echo json_encode($response);
    }
} else {
    // If the request is not a POST request or 'order' is not set, redirect or handle accordingly
    header('location: checkout.php');
    exit();
}

?>
