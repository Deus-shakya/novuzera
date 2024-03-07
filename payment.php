<?php
// Include database connection
include 'components/connect.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve token and order ID from the POST request
    $token = isset($_POST["token"]) ? $_POST["token"] : '';
    $order_id = isset($_POST["order_id"]) ? $_POST["order_id"] : '';
    $payment_status = isset($_POST["payment_status"]) ? $_POST["payment_status"] : '';

    // Check if token and order ID are not empty
    if (!empty($token) && !empty($order_id)) {
        try {
            // Use prepared statement to prevent SQL injection
            $updateQuery = "UPDATE orders SET token = :token WHERE id = :order_id";
            $stmt = $conn->prepare($updateQuery);

            // Bind parameters
            $stmt->bindParam(':token', $token);
            $stmt->bindParam(':order_id', $order_id);

            // Execute the statement
            $stmt->execute();

            // Check if the update was successful
            if ($stmt->rowCount() > 0) {
                // Redirect to home page
                header("Location: home.php");
                exit;
            } else {
                echo "Error updating record";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "Token or order ID is empty";
    }
}
?>