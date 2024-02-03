<?php

class DBConnection {
    public $conn;

    public function __construct() {
        // Your database connection logic here
        $db_name = 'mysql:host=localhost;dbname=novuzera';
        $user_name = 'root';
        $user_password = '';

        try {
            $this->conn = new PDO($db_name, $user_name, $user_password);
            // Set the PDO error mode to exception
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }
}

// Usage of the DBConnection class
$dbConnection = new DBConnection();

$token = '';
$orderid = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $token = isset($_POST["token"]) ? $_POST["token"] : '';
    $orderid = isset($_POST["bookid"]) ? $_POST["bookid"] : '';

    // Use prepared statement to prevent SQL injection
    $updateQuery = "UPDATE orders SET token = :token WHERE id = :orderid";
    $stmt = $dbConnection->conn->prepare($updateQuery);

    // Bind parameters
    $stmt->bindParam(':token', $token);
    $stmt->bindParam(':orderid', $orderid);

    // Execute the statement
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        header("location: home.php");
        exit;
    } else {
        echo "Error updating record";
    }
}
?>
