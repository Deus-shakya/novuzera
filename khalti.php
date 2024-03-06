<?php
// Start session if not already started
session_start();

// Include database connection
include 'components/connect.php';

$id = '';
$total_price = '';

if (isset($_GET['id']) && isset($_GET['total_price'])) {
    $id = $_GET['id'];
    $total_price = $_GET['total_price'];
} else {
    echo 'error';
    exit; // Exit script if parameters are not set
}
?>

<html>
<head>
    <script src="https://khalti.s3.ap-south-1.amazonaws.com/KPG/dist/2020.12.17.0.0.0/khalti-checkout.iffe.js"></script>
</head>
<body>
    <!-- Place this where you need payment button -->
    <button id="payment-button">Pay with Khalti</button>
    <!-- Place this where you need payment button -->
    <!-- Paste this code anywhere in you body tag -->
    <script>
        var config = {
            // replace the publicKey with yours
            "publicKey": "test_public_key_5bad4cf7a61e497cac44f749f1aef178",
            "productIdentity": <?php echo $id ?>,
            "productName": "Tees",
            "productUrl": "http://khalti.com",
            "paymentPreference": [
                "KHALTI",
                "EBANKING",
                "MOBILE_BANKING",
                "CONNECT_IPS",
                "SCT",
            ],
            "eventHandler": {
                onSuccess(payload) {
                    // hit merchant api for initiating verfication
                    console.log(payload);
                    let order_id = payload.product_identity;
                    let token = payload.token;

                    console.log(token, order_id);
                    
                    // Send the token and order ID to server for further processing
                    sendPaymentDetails(token, order_id);
                },
                onError(error) {
                    console.log(error);
                },
                onClose() {
                    console.log('widget is closing');
                }
            }
        };

        var checkout = new KhaltiCheckout(config);
        var btn = document.getElementById("payment-button");
        btn.onclick = function () {
            // minimum transaction amount must be 10, i.e 1000 in paisa.
            checkout.show({ amount: <?php echo $total_price * 100; ?> });
        }

        function sendPaymentDetails(token, order_id) {
            // Create a new FormData object
            var formData = new FormData();
            formData.append('token', token);
            formData.append('order_id', order_id);

            // Send a POST request to payment.php to insert order into database
            fetch('payment.php', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (response.ok) {
                    // Redirect to home page if payment was successful
                    window.location.href = 'home.php';
                } else {
                    console.error('Error inserting order into database');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    </script>
    <!-- Paste this code anywhere in you body tag -->
</body>
</html>
