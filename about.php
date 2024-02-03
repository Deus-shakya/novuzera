<?php

include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
};

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>about</title>
   <link rel="icon" href="images/logo/iconLogo.png" type="image/x-icon">

   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>

<body>

   <?php include 'components/user_header.php'; ?>

   <section class="about">

      <div class="row">

         <div class="image">
            <img src="images/about/about.jpg " alt="">
         </div>

         <div class="content">
            <h3>Who are we?</h3> <br><br>
            <p>Novuzera is an independent ethical and sustainable brand by KHND(Kakani Himalayan Natural Dyes),
               dedicated to promote natural dyes and natural fabrics.
               All our products are naturally dyed and consiously made in Nepal using locally available resources.</p>
            <h3>Why us?</h3> <br><br>
            <p>Novuzera solely focuses on natural and sustainable techqniques to manufacture fashionable clothing line and products.
               We use promote and encourage sustainable methods which leaves little to no impact on eco system.
               All our fabrics are dyed using different natural herbs and natural minerals.
               Our products provide health benefits to customers with fashion and touch to the nature.
               We emphasize on promoting locally made products.Novuzera envisions new era of fashion which will be sustainable and ecological.
               <br><br>Novuzera is trust worthy and responsible brand.Novuzera believes in quality over quantity.
               All our products are crafted carefully by local artisans with love which ensures our quality is always top notch. </p>
         </div>

      </div>

   </section>

   <?php include 'components/footer.php'; ?>

   <script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

   <script src="js/script.js"></script>

   <script>
      var swiper = new Swiper(".reviews-slider", {
         loop: true,
         spaceBetween: 20,
         pagination: {
            el: ".swiper-pagination",
            clickable: true,
         },
         breakpoints: {
            0: {
               slidesPerView: 1,
            },
            768: {
               slidesPerView: 2,
            },
            991: {
               slidesPerView: 3,
            },
         },
      });
   </script>

</body>

</html>