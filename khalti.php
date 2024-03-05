<?php
$id = '';
$total_price = '';
if (isset($_GET['id']) && isset($_GET['total_price'])) {
    $id = $_GET['id'];
    $total_price = $_GET['total_price'];
} else {
    echo'error'; 
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
            "productIdentity":<?php echo $id?>,
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
                    passdata();

                    function passdata() {
                        var form = document.createElement("form");
                        form.method = "post";
                        form.action = "payment.php";

                        var tokenInput = document.createElement("input");
                        tokenInput.type = "hidden";
                        tokenInput.name = "token";
                        tokenInput.value = token;

                        var bookidInput = document.createElement("input");
                        bookidInput.type = "hidden";
                        bookidInput.name = "bookid";
                        bookidInput.value = order_id;

                        form.appendChild(tokenInput);
                        form.appendChild(bookidInput);

                        document.body.appendChild(form);

                        form.submit();
                    }
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
    </script>
    <!-- Paste this code anywhere in you body tag -->
</body>
</html>