<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: Login1/login.php"); // Redirect if not logged in
    exit();


}
?>
<!--<script>
  history.pushState(null, null, window.location.href);
  window.onpopstate = function () {
    history.pushState(null, null, window.location.href);
  };
</script>-->

<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
  <title>Housing.com</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="css/stylehp.css">

</head>
<body>
<!-- Header Section -->
<div class="header-container">
  <header class="bg-red-800 text-white">
    <div class="container mx-auto flex justify-between items-center py-4 px-6">
      <div class="flex items-center space-x-4">
        <span class="hover-effect">
          <a href="https://www.google.com/maps/place/Kankavli,+Maharashtra+416602">
          <i class="fas fa-map-marker-alt"></i>
            Kankavli
          </a>  
        </span>
        <div class="flex space-x-2 social_box">
          <a href="https://www.facebook.com/" class="hover-effect"><i class="fab fa-facebook-f"></i></a>
          <a href="https://www.linkedin.com/feed/" class="hover-effect"><i class="fab fa-linkedin-in"></i></a>
          <a href="https://www.instagram.com/" class="hover-effect"><i class="fab fa-instagram"></i></a>
          <a href="https://x.com/?lang=en&mx=2" class="hover-effect"><i class="fab fa-twitter"></i></a>
        </div>
      </div>
      <div class="flex items-center space-x-4">
        <span class="hover-effect">
          <i class="fas fa-phone-alt"></i>
          +91-8459962255
        </span>
        <span class="hover-effect">
          <i class="fas fa-envelope"></i>
          info@SocietyEase.com
        </span>
        <div class="auth-links">
        <a class="hover-effect" href="Login1/login.php">Log In</a>
        <span>|</span>
        <a class="hover-effect" href="Login1/Register.php">Sign Up</a>
      </div>
      </div>
    </div>
  </header>
</div>

  <!-- Navigation Bar Section -->
  <div class="nav-container">
  <nav class="bg-red-800 shadow">
    <div class="container mx-auto flex justify-between items-center py-4 px-6">
      <div class="flex items-center space-x-4">
        <span class="text-xl font-bold text-white">Society.com</span>
      </div>
      <div class="hidden md:flex space-x-6">
        <a class="text-white font-bold hover-effect" href="index.php">HOME</a>
        <a class="text-white font-bold hover-effect" href="frmAnnouncement.php">DASHBOARD</a>
        <a class="text-white font-bold hover-effect" href="frmAboutUs.php">ABOUT US</a>
        <a class="text-white font-bold hover-effect" href="frmContact.php">CONTACT US</a>
        <a class="text-white font-bold hover-effect" href="frmComplaint.php">COMPLAINT</a>
        <a class="text-white font-bold hover-effect" href="frmFeedback.php">FEEDBACK</a>
      </div>
      <div class="md:hidden">
        <button class="text-white">
          <i class="fas fa-bars"></i>
        </button>
      </div>
    </div>
  </nav>
</div>

  <!-- Background Image Section -->
  <div class="bg-cover bg-center h-screen" style="background-image: url('images/hsm2.png');">
    <!-- Optional content within the background section -->
  </div>


<!-- Contact Section -->
<section class="contact_section" style="background-color: #000; color: #fff; padding: 50px 0;">
  <div class="container">
    <!-- Heading -->
    <div class="heading_container" style="text-align: center; margin-bottom: 30px;">
      <h2 style="color: #f00; font-weight: bold;">Get In Touch</h2>
    </div>

    <!-- Map -->
    <div class="map_container" style="text-align: center; margin-bottom: 30px;">
      <iframe 
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d30640.22087888615!2d73.68886310048778!3d16.270355404049905!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bc0162e91b560fd%3A0xf6aae07d9c847036!2sKankavli%2C%20Maharashtra%20416602!5e0!3m2!1sen!2sin!4v1738433319540!5m2!1sen!2sin"
        width="80%" height="300" frameborder="0" 
        style="border: 0; border-radius: 10px; display: block; margin: 0 auto;" 
        allowfullscreen>
      </iframe>
    </div>

    <!-- Form Section -->
    <div class="custom-form-container">
      <form action="">
        <div>
          <input type="text" placeholder="Name" class="form-input" aria-label="Name" />
        </div>
        <div>
          <input type="email" placeholder="Email" class="form-input" aria-label="Email" />
        </div>
        <div>
          <input type="text" placeholder="Phone Number" class="form-input" aria-label="Phone Number" />
        </div>
        <div>
          <input type="text" placeholder="Message" class="form-input" aria-label="Message" />
        </div>
        <div>
          <button type="submit" class="btn">Send</button>
        </div>
      </form>
    </div>
  </div>
</section>

<!-- Info Section -->
<section class="bg-black text-white py-10">
  <div class="container mx-auto">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
      <!-- About Apartment -->
      <div class="text-left">
        <div>
          <h5 class="text-lg font-bold text-white">About Apartment</h5>
          <p class="mt-2">
            <a href="https://www.google.com/maps/place/Kankavli,+Maharashtra+416602">
            <img src="images/location.png" class="inline-block w-4 mr-2" alt="Location Icon" /> Kankavli</a>
          </p>
          <p class="mt-2">
            <img src="images/phone.png" class="inline-block w-4 mr-2" alt="Phone Icon" /> +91 8459962255
          </p>
          <p class="mt-2">
            <img src="images/mail.png" class="inline-block w-4 mr-2" alt="Mail Icon" /> info@SocietyEase.com
          </p>
        </div>
      </div>

      <!-- Information -->
      <div class="text-left">
        <h5 class="text-lg font-bold text-white">Information</h5>
        <p class="mt-2">
          Our housing society is committed to providing a safe, clean, and inclusive community.
          Stay informed about maintenance schedules, upcoming events, and society updates.
        </p>
      </div>
       <!-- Useful Link -->
       <div class="text-left">
        <h5 class="text-lg font-bold text-white">Useful Link</h5>
        <p class="mt-2">
          <a href="frmContact.php">
          Contact Us
          </a>
          <br>
          FeedBack
        
        </p>
      </div>

      <!-- Newsletter -->
      <div class="text-left">
        <h5 class="text-lg font-bold text-white">Newsletter</h5>
        <input
          type="email"
          placeholder="Enter your email"
          class="mt-2 w-full px-4 py-2 rounded border border-gray-300 text-black"
        />
        <button class="mt-2 bg-orange-500 text-white px-4 py-2 rounded">Subscribe</button>

 
 
        <div class="mt-4 flex space-x-3">
          <a href="https://www.facebook.com/"><img src="images/fb.png" alt="Facebook Icon" class="w-6" /></a>
          <a href="https://x.com/?lang=en&mx=2"><img src="images/twitter.png" alt="Twitter Icon" class="w-6" /></a>
          <a href="https://www.linkedin.com/feed/"><img src="images/linkedin.png" alt="LinkedIn Icon" class="w-6" /></a>
          <a href="https://www.youtube.com"><img src="images/youtube.png" alt="YouTube Icon" class="w-6" /></a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- footer section -->
<section class="container-fluid footer_section">
  <div class="container">
    <p> <span style="color: #f00;">2025 All Rights Reserved By <a>Gaurav Umesh Malankar</a></p></span> 
  </div>
</section>
<!-- end footer section -->

  <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.js"></script>
  <script type="text/javascript" src="js/custom.js"></script>
    

</body>
</html>

