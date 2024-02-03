<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = isset($_POST['token']) ? $_POST['token'] : '';

    if (!empty($token)) {
        $args = http_build_query(array(
            'token' => $token,
            'amount' => 1000, // Adjust this amount as needed
        ));

        $url = "https://khalti.com/api/v2/payment/verify/";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $args);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $headers = ['Authorization: Key your_actual_secret_key'];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        // Process the response
        if ($status_code == 200) {
            // Payment verification successful
            echo "Payment verification successful. Response: " . $response;
        } else {
            // Payment verification failed
            echo "Payment verification failed. HTTP Status Code: " . $status_code . ", Response: " . $response;
        }
    } else {
        echo "Token is empty or not provided.";
    }
} else {
    echo "Invalid request method.";
}
?>
