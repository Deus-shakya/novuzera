<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_POST['send'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $msg = $_POST['msg'];
   $msg = filter_var($msg, FILTER_SANITIZE_STRING);

   $select_message = $conn->prepare("SELECT * FROM `messages` WHERE name = ? AND email = ? AND number = ? AND message = ?");
   $select_message->execute([$name, $email, $number, $msg]);

   if($select_message->rowCount() > 0){
      $message[] = 'already sent message!';
   }else{

      $insert_message = $conn->prepare("INSERT INTO `messages`(user_id, name, email, number, message) VALUES(?,?,?,?,?)");
      $insert_message->execute([$user_id, $name, $email, $number, $msg]);

      $message[] = 'sent message successfully!';

   }

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>contact</title>
   <link rel="icon" href="images/logo/iconLogo.png" type="image/x-icon">
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section id="contact-details">
        <div class="details" style="width: 40%;  ">
            <h2>Visit our location or contact us today</h2>
            <h3>office</h3>
            <div>
                <li>
                <i class="fas fa-map-marker-alt"></i>
                    <p> Sorakhutte, Kathmandu, Nepal</p>
                </li>
                <li>
                <i class="fas fa-envelope"></i>
                    <a href="mailto:novuzera@gmail.com"><p> novuzera@gmail.com</p></a>
                </li>
                <li>
                    <i class="fas fa-phone"></i>
                    <a href="tel:+977-9861779796"><p> +977-9861779796</p></a>
                </li>
                <li>
                    <i class="far fa-clock"></i>
                    <p> Sunday to Friday: 11.00AM to 5.00pm</p>
                </li>
            </div>
        </div>
        <div class="map">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d949.0856171084872!2d85.30979264268358!3d27.720445414928736!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39eb18e34235b98b%3A0x9209fa31001ca37d!2sSorhakhutte%2C%20Kathmandu%2044600!5e0!3m2!1sen!2snp!4v1686815907931!5m2!1sen!2snp"
                width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>

        </div>


     </section>

<section class="contact">

   <form action="" method="post">
      <h3>GET IN TOUCH</h3>
      <input type="text" name="name" placeholder="Your name" required maxlength="20" class="box">
      <input type="email" name="email" placeholder="Your email" required maxlength="50" class="box">
      <input type="number" name="number"  min="0" max="9999999999"  placeholder="Your number" required onkeypress="if(this.value.length == 10) return false;" class="box">
      <textarea name="msg" class="box" placeholder="Enter your message" cols="30" rows="10"></textarea>
      <input type="submit" value="send message" name="send" class="btn">
   </form>

</section>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>