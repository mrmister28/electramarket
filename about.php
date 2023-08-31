<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
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
         <img src="images/about-img.svg" alt="">
      </div>

      <div class="content">
         <h3>why choose us?</h3>
         <p>Welcome to our e-commerce website! We understand that you have a lot of options when it comes to shopping online, which is why we strive to provide an exceptional customer experience that sets us apart from the rest. When you choose to shop with us, you can expect high-quality products at affordable prices, fast and reliable shipping, and top-notch customer service from our dedicated team. We also offer a user-friendly website that makes it easy to find what you're looking for and complete your purchase with ease. Thank you for considering us for your shopping needs - we look forward to serving you!</p>
         <a href="contact.php" class="btn">contact us</a>
      </div>

   </div>

</section>

<section class="reviews">
   
   <h1 class="heading">client's reviews</h1>

   <div class="swiper reviews-slider">

   <div class="swiper-wrapper">

      <div class="swiper-slide slide">
         <img src="images/pic-1.jpg" alt="">
         <p>"I recently purchased a laptop from this website, and I must say, I am thoroughly impressed with the product quality and service. The website is easy to navigate, and the checkout process was a breeze. I highly recommend this website for all your electronics needs!"</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Gaurav Singh</h3>
      </div>

      <div class="swiper-slide slide">
         <img src="images/pic-2.jpg" alt="">
         <p>"I've been a loyal customer of this website for years now, and they never fail to disappoint. Their customer service is top-notch, and they always go above and beyond to ensure I am satisfied with my purchases. The range of products they offer is vast, and the prices are unbeatable."</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Zoya Arif</h3>
      </div>

      <div class="swiper-slide slide">
         <img src="images/pic-3.jpg" alt="">
         <p>"I was hesitant to order electronics online, but this website made it so easy and convenient. The product I ordered arrived on time and in perfect condition. I appreciate the attention to detail and care put into packaging the product. I will definitely be ordering from this website again!"</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Aman Kumar</h3>
      </div>

      <div class="swiper-slide slide">
         <img src="images/pic-4.jpg" alt="">
         <p>"I stumbled upon this website while searching for a specific electronic device, and I am so glad I did. The website is user-friendly, and the prices are competitive. I appreciate the detailed product descriptions and reviews, which helped me make an informed purchase. I will be recommending this website to all my friends and family!"</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Rohan Singh Anirban</h3>
      </div>

      <div class="swiper-slide slide">
         <img src="images/pic-5.jpg" alt="">
         <p>"I have purchased multiple electronics products from this website, and I am always satisfied with the quality and service. The delivery is always prompt, and the customer service is exceptional. I appreciate the hassle-free shopping experience and the wide range of products available on the website."</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Harsh Sharma</h3>
      </div>

      <div class="swiper-slide slide">
         <img src="images/pic-6.jpg" alt="">
         <p>"I highly recommend this website for all your electronics needs. The prices are competitive and the selection is vast. I was able to find exactly what I was looking for, and the checkout process was quick and easy. My order arrived ahead of schedule and I was impressed with the quality of the products. I will definitely be a repeat customer!"</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Anuj Thakur</h3>
      </div>

   </div>

   <div class="swiper-pagination"></div>

   </div>

</section>









<?php include 'components/footer.php'; ?>

<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<script src="js/script.js"></script>

<script>

var swiper = new Swiper(".reviews-slider", {
   loop:true,
   spaceBetween: 20,
   pagination: {
      el: ".swiper-pagination",
      clickable:true,
   },
   breakpoints: {
      0: {
        slidesPerView:1,
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