<?php

session_start();
include '../connection.php';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact Us | SOUND Group</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="icon" type="image/png" href="../../admin/uploads/icon/favicon.png">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  
  <style>

    :root {
      --primary: #E1306C;
      --secondary: #405DE6;
      --dark: #121212;
      --darker: #000;
      --medium: #181818;
      --light: #b3b3b3;
      --mdlight:rgb(230, 230, 230);
      --lighter: #fff;
      --gradient: linear-gradient(135deg, var(--primary), var(--secondary));
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #0f0c29, #1a1a2e, #16213e);
      color: var(--lighter);
      margin: 0;
      padding: 0;
      overflow-x: hidden;
    }

    a {
            cursor: pointer;
        }


        .navbar {
      background: rgba(0, 0, 0, 0.8);
      backdrop-filter: blur(10px);
      padding: 15px 12px;
      position: sticky;
      top: 0;
      z-index: 1000;
      box-shadow: 0 2px 15px rgba(0, 0, 0, 0.5);
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
      transition: all 0.4s ease;
    }

    .navbar-scrolled {
      padding: 10px 12px;
      background: rgba(10, 10, 20, 0.95);
    }

     /* temp */
    .container {
      max-width: 100%;
      margin: 0;
    }

    .navbar-brand-container {
        cursor: pointer;
      position: relative;
      display: flex;
      align-items: center;
    }

    .navbar-brand {
      font-size: 28px;
      font-weight: 700;
      color: var(--lighter) !important;
      display: flex;
      align-items: center;
      font-family: 'Montserrat', sans-serif;
      transition: opacity 0.3s ease;
    }

    .navbar-brand i {
      color: var(--primary);
      margin-right: 10px;
    }

    #navbarSearch {
      display: flex;
      align-items: center;
      margin-left: 10px;
    }

    #navbarSearch2 {
      display: none;
      align-items: center;
    }

    #searchbtn2{
    position: static;
    width: 54%;
    margin: 30px 0 0 50%;
    transform: translateX(-50%);
    }



    .navbar-brand.hidden {
      opacity: 0;
      pointer-events: none;
    }
    .search-toggle {
      position: relative;
      z-index: 2;
    }

    #navbarNav{
    justify-items: center;
}

    .loginbtncolor {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        border: none;
        border-radius: 10px;
        transition: all 0.3s;
        Color: var(--mdlight);
    }

    .loginbtncolor:hover {
      transform: translateY(-2px);
      box-shadow: 0 7px 20px rgba(225, 48, 108, 0.4);
    }

      .loginbtnoutline{
        background: transparent;
        border: 1px solid var(--primary);
        color: var(--primary);
        border-radius: 10px;
        transition: all 0.3s;
        flex: 1;
      }

      .loginbtnoutline:hover {
            background: rgba(225, 48, 108, 0.1);
        }

      #loginbtn1 {
        display: block ;
        position: absolute;
        right: 160px;
      }

      #loginbtn2 {
        display: none ;
      }

      #signupbtn {
        display: block ;
        position: absolute;
        right: 250px;
      }

    button.navbar-toggler {
      position: absolute;
      right: 150px ;
      top: 20px;
    }

    .user-name-dd{
      display: none;
    }

    span.user-name-dd{
    color: #b8b8b8;
    text-align: center;
}

.user-menu-divider1{
  display: none;
}

    @media (max-width: 1500px) {
      #loginbtn1 {
        display: block !important;
      }

      #signupbtn {
        position: static;
        margin-top: 21px;
        display: none !important;
      }
    }

    @media (min-width: 1330px) {

      .navbar-nav {
        padding-right: 1vw;
        width: 58vw;
        justify-content: center;
      }
    }

    @media (max-width: 1329px) {
      .navbar-nav {
        width: 55vw;
      }
    }

    @media (max-width: 1300px) AND (min-width: 1200px) {

       .user-menu-divider2{
          display: none !important;
       }

    }

    @media (min-width: 1199px) {
      #navbarSearch2 {
        display: none !important;
      }

      #navbarNav {
        gap: 10px;
      }

    }

    @media (max-width: 1199px) {

      #navbarSearch2 {
        display: none !important;
      }

      #navbarSearch {
        position: absolute !important;
        left: 280px;
        top: 19px;
      }
      #loginbtn1{
            right: 220px !important;
      }
      
    }

    @media (max-width:768px) {
      button.navbar-toggler {
        position: absolute;
        right: 90px;
      }

       .user-name-dd{
        display: block !important;
       }

       .user-menu-divider1{
          display: block !important;
       }
      
      #loginbtn1{
        display : none !important;
      }

      #loginbtn2{
        display : block !important;
        width: 30%;
      }
    }

    @media (max-width: 700px) {
      #navbarSearch {
        display: none !important;
      }

      #navbarSearch2 {
        display: block !important;
        width: 100%;
      }

      #loginbtn2{
        margin-top: 15px;
      }
    }

    @media (max-width: 540px) {
      #loginbtn1 {
        display: none !important;
      }

      #loginbtn2 {
        display: block !important;
      }
    }

    @media (max-width: 500px) {
      button.navbar-toggler {
        height: 45px;
        width: 50px;
        top: 18px !important;
      }

      .navbar-toggler-icon {
        width: 0.9em;
        height: 1em;
        margin-left: -2px;
      }

      .navbar-toggler-icon {
        display: inline-block;
        width: 0.9em;
        height: 1em;
        margin-left: -2px;
      }

      .navbar-brand {
        font-size: 23px;
      }
    }

    @media (max-width: 400px) {
      .logoicon {
        display: none;
      }
    }

    @media (max-width: 370px) {
      .navbar .container {
        padding: 0;
      }
    }

    .nav-link {
      color: var(--light) !important;
      margin-left: 20px;
      font-weight: 500;
      transition: all 0.3s;
      position: relative;
    }

    .nav-link:hover,
    .nav-link.active {
      color: var(--lighter) !important;
    }

    .nav-link::after {
      content: '';
      position: absolute;
      bottom: -5px;
      left: 0;
      width: 0;
      height: 2px;
      background: var(--primary);
      transition: width 0.3s;
    }

    .nav-link:hover::after,
    .nav-link.active::after {
      width: 100%;
    }

    #signupbtn {
      width: 110px;
    }


    .user-menu {
      display: flex;
      align-items: center;
      gap: 15px;
      position: absolute;
      right: 20px;
      top: 20px;
    }

    .user-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 18px;
    border: 2px solid var(--primary);
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    color: white;
}

.user-avatar.guest {
    background: var(--medium);
    border-color: var(--light);
    color: var(--lighter);
}

.user-name {
    font-weight: 500;
    color: var(--lighter);
}

.user-name:not(.logged-in) {
    opacity: 0.8;
}

    .user-name {
      font-weight: 500;
      color: var(--lighter);
    }

    .dropdown-menu {
      background: rgba(30, 30, 46, 0.9);
      backdrop-filter: blur(10px);
      border: 1px solid rgba(255, 255, 255, 0.1);
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    }

    .dropdown-item {
      color: var(--lighter);
      padding: 8px 15px;
    }

    .dropdown-item:hover {
      background: rgba(225, 48, 108, 0.2);
      color: var(--lighter);
    }

    .dropdown-divider {
      border-color: rgba(255, 255, 255, 0.1);
    }

    @media (max-width: 768px) {

      .user-menu {
        gap: 10px;
      }

      .user-name {
        display: none;
      }
    }

  
@media (min-width: 769px) {
    <?php if(isset($_SESSION['username'])): ?>
        #loginbtn1, #signupbtn {
            display: none !important;
        }
    <?php endif; ?>
}

@media (max-width: 768px) {
    <?php if(isset($_SESSION['username'])): ?>
        #loginbtn2 {
            display: none !important;
        }
    <?php endif; ?>
}

ul.navbar-nav{
    margin-left: 6vw;
}

    /* Contact Page Specific Styles */
    .contact-section {
      padding: 80px 0;
      position: relative;
      overflow: hidden;
      background: linear-gradient(135deg, #0f0c29, #1a1a2e, #16213e);
      min-height: 100vh;
    }
    
    .contact-container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 20px;
    }
    
    .contact-header {
      text-align: center;
      margin-bottom: 50px;
      position: relative;
      z-index: 2;
    }
    
    .contact-title {
      font-size: 3rem;
      font-weight: 800;
      margin-bottom: 15px;
      background: linear-gradient(to right, #fff, #E1306C, #405DE6);
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
      font-family: 'Montserrat', sans-serif;
      position: relative;
      display: inline-block;
    }
    
    .contact-title::after {
      content: '';
      position: absolute;
      bottom: -10px;
      left: 50%;
      transform: translateX(-50%);
      width: 80px;
      height: 4px;
      background: var(--gradient);
      border-radius: 2px;
    }
    
    .contact-subtitle {
      font-size: 1.2rem;
      color: var(--light);
      max-width: 700px;
      margin: 0 auto;
      line-height: 1.7;
    }
    
    .contact-content {
      display: flex;
      flex-wrap: wrap;
      gap: 40px;
      justify-content: center;
      position: relative;
      z-index: 2;
    }
    
    .contact-info {
      flex: 1;
      min-width: 300px;
      background: rgba(30, 30, 46, 0.8);
      backdrop-filter: blur(10px);
      border-radius: 20px;
      padding: 30px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
      border: 1px solid rgba(255, 255, 255, 0.15);
      transition: transform 0.4s ease, box-shadow 0.4s ease;
    }
    
    .contact-info:hover {
      transform: translateY(-5px);
      box-shadow: 0 15px 40px rgba(225, 48, 108, 0.3);
    }
    
    .contact-form-container {
      flex: 1;
      min-width: 400px;
      background: rgba(30, 30, 46, 0.8);
      backdrop-filter: blur(10px);
      border-radius: 20px;
      padding: 30px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
      border: 1px solid rgba(255, 255, 255, 0.15);
      transition: transform 0.4s ease, box-shadow 0.4s ease;
    }
    
    .contact-form-container:hover {
      transform: translateY(-5px);
      box-shadow: 0 15px 40px rgba(64, 93, 230, 0.3);
    }
    
    .contact-info-title {
      font-size: 1.6rem;
      font-weight: 700;
      margin-bottom: 25px;
      color: var(--lighter);
      position: relative;
      padding-bottom: 15px;
    }
    
    .contact-info-title::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      width: 50px;
      height: 3px;
      background: var(--gradient);
      border-radius: 2px;
    }
    
    .contact-method {
      display: flex;
      align-items: flex-start;
      margin-bottom: 25px;
      padding-bottom: 25px;
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .contact-icon {
      width: 45px;
      height: 45px;
      border-radius: 50%;
      background: var(--gradient);
      display: flex;
      align-items: center;
      justify-content: center;
      margin-right: 15px;
      flex-shrink: 0;
      transition: transform 0.3s ease;
    }
    
    .contact-method:hover .contact-icon {
      transform: rotate(15deg) scale(1.1);
    }
    
    .contact-icon i {
      font-size: 1.2rem;
      color: white;
    }
    
    .contact-details h4 {
      font-size: 1.1rem;
      font-weight: 600;
      margin-bottom: 8px;
      color: var(--lighter);
    }
    
    .contact-details p, .contact-details a {
      color: var(--light);
      margin-bottom: 0;
      text-decoration: none;
      transition: color 0.3s;
      font-size: 0.95rem;
      line-height: 1.6;
    }
    
    .contact-details a:hover {
      color: var(--primary);
    }
    
    .social-contact {
      display: flex;
      gap: 12px;
      margin-top: 20px;
    }
    
    .social-contact a {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      background: rgba(255, 255, 255, 0.1);
      color: var(--lighter);
      transition: all 0.3s;
      text-decoration: none;
    }
    
    .social-contact a:hover {
      background: var(--gradient);
      transform: translateY(-3px);
      box-shadow: 0 5px 15px rgba(225, 48, 108, 0.4);
    }
    
    .form-label {
      color: var(--lighter);
      font-weight: 500;
      margin-bottom: 8px;
      font-size: 0.95rem;
    }
    
    .form-control {
      background: rgba(20, 20, 36, 0.8);
      border: 1px solid rgba(255, 255, 255, 0.1);
      color: var(--lighter);
      padding: 12px 15px;
      border-radius: 8px;
      margin-bottom: 20px;
      transition: all 0.3s;
      font-size: 0.95rem;
    }
    
    .form-control:focus {
      border-color: var(--primary);
      box-shadow: 0 0 0 0.25rem rgba(225, 48, 108, 0.25);
      background: rgba(30, 30, 46, 0.9);
    }
    
    textarea.form-control {
      min-height: 150px;
      resize: vertical;
    }
    
    .contact-btn {
      background: var(--gradient);
      border: none;
      padding: 12px 30px;
      font-size: 1rem;
      font-weight: 600;
      border-radius: 50px;
      color: white;
      transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      position: relative;
      overflow: hidden;
      box-shadow: 0 8px 20px rgba(225, 48, 108, 0.4);
      width: 100%;
      margin-top: 10px;
      letter-spacing: 0.5px;
    }
    
    .contact-btn:hover {
      transform: translateY(-3px);
      box-shadow: 0 12px 25px rgba(225, 48, 108, 0.6);
    }
    
    .map-container {
      border-radius: 12px;
      overflow: hidden;
      height: 200px;
      margin-top: 25px;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
      border: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .map-container iframe {
      width: 100%;
      height: 100%;
      border: none;
    }
    
    /* Floating elements for contact page */
    .contact-floating {
      position: absolute;
      width: 150px;
      height: 150px;
      border-radius: 50%;
      background: linear-gradient(135deg, var(--primary), var(--secondary));
      opacity: 0.1;
      filter: blur(50px);
      z-index: 1;
      animation: float 15s infinite ease-in-out;
    }
    
    .contact-floating-1 {
      top: 10%;
      left: 5%;
      animation-delay: 0s;
    }
    
    .contact-floating-2 {
      bottom: 15%;
      right: 5%;
      animation-delay: 3s;
    }
    
    .contact-floating-3 {
      top: 50%;
      right: 20%;
      width: 100px;
      height: 100px;
      animation-delay: 6s;
    }
    
    .response-time {
      font-size: 0.9rem;
      color: var(--light);
      text-align: center;
      margin-top: 20px;
      position: relative;
      padding-top: 20px;
    }
    
    .response-time::before {
      content: '';
      position: absolute;
      top: 0;
      left: 50%;
      transform: translateX(-50%);
      width: 50px;
      height: 2px;
      background: var(--gradient);
    }
    
    @keyframes float {
      0% { transform: translateY(0px) rotate(0deg); }
      50% { transform: translateY(-20px) rotate(5deg); }
      100% { transform: translateY(0px) rotate(0deg); }
    }
    
    /* Responsive styles */
    @media (max-width: 992px) {
      .contact-title {
        font-size: 2.5rem;
      }
      
      .contact-subtitle {
        font-size: 1.1rem;
      }
    }
    
    @media (max-width: 768px) {
      .contact-section {
        padding: 60px 0;
      }
      
      .contact-title {
        font-size: 2.2rem;
      }
      
      .contact-content {
        flex-direction: column;
      }
      
      .contact-info, .contact-form-container {
        min-width: 100%;
      }
      
      .contact-info-title {
        font-size: 1.5rem;
      }
    }
    
    @media (max-width: 576px) {
      .contact-title {
        font-size: 2rem;
      }
      
      .contact-subtitle {
        font-size: 1rem;
      }
      
      .contact-method {
        flex-direction: column;
        align-items: flex-start;
      }
      
      .contact-icon {
        margin-bottom: 15px;
      }
    }

    input#name::placeholder {
    color: #bbb;
          font-size: 14px;
}
    input#email::placeholder {
    color: #bbb;
          font-size: 14px;
}
    textarea#message::placeholder {
    color: #bbb;
          font-size: 14px;
}
  </style>
</head>
<body>
  <nav class="navbar userheader navbar-expand-xl navbar-dark">
    <div class="container">
      <a class="navbar-brand" href="home-page.php">
        <i class="bi bi-music-note-beamed logoicon"></i>SOUND Group
      </a>
      
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item"><a class="nav-link" onclick="navigateTo('home')" data-page="home" >Home</a></li>
          <li class="nav-item"><a class="nav-link active songslink" onclick="navigateTo('songs')" data-page="songs" >Songs</a></li>
          <li class="nav-item"><a class="nav-link" onclick="navigateTo('artists')" data-page="artists" >Artists</a></li>
          <li class="nav-item"><a class="nav-link" onclick="navigateTo('videos')" data-page="videos" >Videos</a></li>
          <li class="nav-item"><a class="nav-link" onclick="navigateTo('albums')" data-page="albums" >Albums</a></li>
          <li class="nav-item"><a class="nav-link" onclick="navigateTo('favorites')" data-page="favorites" >Favourites</a></li>
        </ul>

        <?php if(isset($_SESSION['username'])): ?>
                <!-- Show nothing here when logged in -->
            <?php else: ?>
        <button class="btn loginbtncolor" id="loginbtn2" data-bs-toggle="modal" data-bs-target="#loginModal" >Login</button>
        <button class="btn loginbtnoutline" id="signupbtn" data-bs-toggle="modal" data-bs-target="#signupModal">Sign
          Up</button>
          <?php endif; ?>
      </div>

      <?php if(isset($_SESSION['username'])): ?>
            <!-- Hide login button when logged in -->
        <?php else: ?>
      <button class="btn loginbtncolor" id="loginbtn1" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
          <?php endif; ?>

      <button class="navbar-toggler navbar-toggler-admin" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
    </div>
    </div>


    <div class="user-menu userprofile-menu">
  <div class="dropdown">
    <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
      <div class="user-avatar <?php echo isset($_SESSION['username']) ? '' : 'guest'; ?>">
        <?php 
          if(isset($_SESSION['username'])) {
            // First letter of username for logged-in users
            echo strtoupper(substr($_SESSION['username'], 0, 1)); 
          } else {
            // 'G' for Guest users
            echo 'G';
          }
        ?>
      </div>
      <span class="user-name ms-2">
        <?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Guest'; ?>
      </span>
    </a>
    <ul class="dropdown-menu dropdown-menu-end userdropdown" aria-labelledby="userDropdown">
      <?php if(isset($_SESSION['username'])): ?>
        <!-- Logged-in user menu -->
         <span class="user-name-dd ms-2">
        <?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Guest'; ?>
      </span>
      <li><hr class="dropdown-divider user-menu-divider1"></li>
      <li><a class="dropdown-item" href="../Profile_Pages/contact.php" onclick="navigateTo('contact')" data-page="contact" ><i class="bi bi-envelope-fill me-2"></i> Contact</a></li>
      <li><hr class="dropdown-divider user-menu-divider2"></li>
        <li><a class="dropdown-item" href="../Pages/verification/logout.php"><i class="bi bi-box-arrow-right me-2"></i> Sign out</a></li>
      <?php else: ?>
        <!-- Guest user menu -->
        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#loginModal"><i class="bi bi-box-arrow-in-right me-2"></i> Login</a></li>
        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#signupModal"><i class="bi bi-person-plus me-2"></i> Sign Up</a></li>
      <?php endif; ?>
    </ul>
  </div>
</div>


<div class="user-menu user-menu-admin d-none">
  <div class="dropdown">
    <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
      <div class="user-avatar <?php echo  'guest'; ?>">
        <?php 
            echo 'A';
        ?>
      </div>
      <span class="user-name user-name-admin ms-2">
        <?php echo  'Admin'; ?>
      </span>
    </a>
    <ul class="dropdown-menu dropdown-menu-end profile-dropdown" aria-labelledby="userDropdown">
        <!-- Logged-in user menu -->
        <li><a class="dropdown-item" href="../Pages/verification/logout.php"><i class="bi bi-box-arrow-right me-2"></i> Sign out</a></li>
    </ul>
  </div>
</div>
  </nav>
  
  <!-- Contact Page Content -->
  <section class="contact-section">
    <div class="contact-floating contact-floating-1"></div>
    <div class="contact-floating contact-floating-2"></div>
    <div class="contact-floating contact-floating-3"></div>
    
    <div class="contact-container">
      <div class="contact-header">
        <h1 class="contact-title">Contact Us</h1>
        <p class="contact-subtitle">Have questions, feedback, or need support? We're here to help. Reach out to our team and we'll get back to you as soon as possible.</p>
      </div>
      
      <div class="contact-content">
        <div class="contact-info">
          <h2 class="contact-info-title">Get In Touch</h2>
          
          <div class="contact-method">
            <div class="contact-icon">
              <i class="bi bi-geo-alt-fill"></i>
            </div>
            <div class="contact-details">
              <h4>Our Location</h4>
              <p>123 Music Avenue, Sound City<br>Melbourne, VIC 3000, Australia</p>
            </div>
          </div>
          
          <div class="contact-method">
            <div class="contact-icon">
              <i class="bi bi-telephone-fill"></i>
            </div>
            <div class="contact-details">
              <h4>Phone Number</h4>
              <p>+61 3 1234 5678</p>
              <p>+61 4 1234 5678 (Support)</p>
            </div>
          </div>
          
          <div class="contact-method">
            <div class="contact-icon">
              <i class="bi bi-envelope-fill"></i>
            </div>
            <div class="contact-details">
              <h4>Email Address</h4>
              <p><a href="mailto:info@instasound.com">info@instasound.com</a></p>
              <p><a href="mailto:support@instasound.com">support@instasound.com</a></p>
            </div>
          </div>
          
          <h4>Follow Us</h4>
          <div class="social-contact">
            <a href="#" title="Instagram"><i class="bi bi-instagram"></i></a>
            <a href="#" title="Twitter"><i class="bi bi-twitter-x"></i></a>
            <a href="#" title="Facebook"><i class="bi bi-facebook"></i></a>
            <a href="#" title="TikTok"><i class="bi bi-tiktok"></i></a>
          </div>
          
          <div class="map-container">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d25201.09446417564!2d144.9403995181702!3d-37.81362721782813!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad642af0f11fd81%3A0x5045675218ce6e0!2sMelbourne%20VIC!5e0!3m2!1sen!2sau!4v1692400000000!5m2!1sen!2sau" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
          </div>
        </div>
        
        <div class="contact-form-container">
          <h2 class="contact-info-title">Send Us a Message</h2>
          
          <form id="contactForm" method="POST" action="../Pages/index.php">
            <div class="mb-3">
              <label for="name" class="form-label">Full Name</label>
              <input type="text" class="form-control" id="name" name="conname" placeholder="Enter your name" required>
            </div>
            
            <div class="mb-3">
              <label for="email" class="form-label">Email Address</label>
              <input type="email" class="form-control" id="email" name="conemail" placeholder="Enter your email" required>
            </div>
            
            <div class="mb-3">
              <label for="message" class="form-label">Your Message</label>
              <textarea class="form-control" id="message" rows="5" name="conmsg" placeholder="Type your message here..." required></textarea>
            </div>
            
            <button type="submit" class="contact-btn">
              <span class="submit-text">Send Message</span>
              <span class="sending-text" style="display:none;">
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                Sending...
              </span>
            </button>
            
            <div class="response-time">
              We typically respond within 24-48 hours
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
  
  <?php
  include '../Pages/footer.php';
  include '../Pages/auth-modals.php';
  ?>
  
  
  
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Form submission handling
    
    
    // Floating element animation
    function floatAnimation() {
      const elements = document.querySelectorAll('.contact-floating');
      elements.forEach(el => {
        const animation = el.style.animation;
        el.style.animation = 'none';
        setTimeout(() => {
          el.style.animation = animation;
        }, 10);
      });
    }
    
    // Reinitialize animation every 15 seconds (matches animation duration)
    setInterval(floatAnimation, 15000);

const pageMap = {
  'songs-page.php': 'songs',
  'song.php': 'songs',
  'videos-page.php': 'videos',
  'video.php': 'videos',
  'albums-page.php': 'albums',
  'album.php': 'albums',
  'artists-page.php': 'artists',
  'artist.php': 'artists',
  'search-page.php': 'search',
  'home-page.php': 'home',
  'contact.php': 'contact'
};

const currentFile = window.location.pathname.split('/').pop();
const currentPage = pageMap[currentFile] || ''; // fallback

const navLinks = document.querySelectorAll('.nav-link[data-page]');

    navLinks.forEach(link => {
  if (link.dataset.page === currentPage) {
    link.classList.add('active');
  } else {
    link.classList.remove('active');
  }
  });

    function navigateTo(page, id = null) {

    // Logged in? Redirect based on selected page
    switch (page) {
      case 'home':
        window.location.href = '../Pages/home-page.php';
        break;
      case 'songs':
        window.location.href = '../Pages/songs-page.php';
        break;
      case 'artists':
        window.location.href = '../Pages/artists-page.php';
        break;
      case 'videos':
        window.location.href = '../Pages/videos-page.php';
        break;
      case 'albums':
        window.location.href = '../Pages/albums-page.php';
        break;
      case 'search':
        window.location.href = '../Pages/search-page.php';
        break;
        case 'song':
        if (id !== null) {
        window.location.href = `../Pages/song.php?song=${id}`;
          }
        break;
        case 'artist':
        if (id !== null) {
        window.location.href = `../Pages/artist.php?artist=${id}`;
          }
        break;
        case 'video':
        if (id !== null) {
        window.location.href = `../Pages/video.php?video=${id}`;
          }
        break;
        case 'album':
        if (id !== null) {
        window.location.href = `../Pages/album.php?album=${id}`;
          }
        break;
        case 'favorites':
        window.location.href = '../Pages/favorites.php';
        break;
        case 'contact':
        window.location.href = 'contact.php';
        break;
        default:
        alert("Page Not Found");
    }
  }


  document.querySelecter('.nav-link[data-page="home"]').classList.remove('active');

  </script>
</body>
</html>