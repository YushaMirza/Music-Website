<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .footer {
      background: rgba(10, 10, 20, 0.95);
      padding: 80px 0 30px;
      text-align: center;
      font-size: 14px;
      color: var(--light);
      border-top: 1px solid rgba(255, 255, 255, 0.05);
      position: relative;
    }

    .footer::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 3px;
      background: var(--gradient);
    }

    .footer-logo {
      font-size: 2.5rem;
      font-weight: bold;
      color: var(--lighter);
      margin-bottom: 20px;
      font-family: 'Montserrat', sans-serif;
      background: linear-gradient(to right, #fff, #E1306C, #405DE6);
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
    }
    .social-icons a {
      color: var(--light);
      font-size: 1.5rem;
      transition: all 0.3s;
      width: 50px;
      height: 50px;
      border-radius: 50%;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      background: rgba(255, 255, 255, 0.1);
      margin: 0 10px;
      animation: float 4s infinite ease-in-out;
    }

    .social-icons a:hover {
      color: var(--lighter);
      background: var(--primary);
      transform: translateY(-5px) scale(1.1);
      box-shadow: 0 5px 15px rgba(225, 48, 108, 0.4);
    }

    .social-icons a:nth-child(2) { animation-delay: 0.5s; }
    .social-icons a:nth-child(3) { animation-delay: 1s; }
    .social-icons a:nth-child(4) { animation-delay: 1.5s; }
    .social-icons a:nth-child(5) { animation-delay: 2s; }
    </style>
</head>
<body>
    <footer class="footer" style="margin-top: 7rem;">
    <div class="container">
      <div class="footer-logo">SOUND<span> Group</span></div>
      <p>Your ultimate source for trending music on Instagram</p>

      <div class="social-icons">
        <a href="#"><i class="bi bi-instagram"></i></a>
        <a href="#"><i class="bi bi-youtube"></i></a>
        <a href="#"><i class="bi bi-spotify"></i></a>
        <a href="#"><i class="bi bi-tiktok"></i></a>
      </div>

      <div class="mt-4">
        <p>© 2023 SOUND Group. All rights reserved.</p>
        <div class="mt-3">
          <a href="#" class="text-light me-3">Privacy Policy</a>
          <a href="#" class="text-light me-3">Terms of Service</a>
          <a href="../Profile_Pages/contact.php" class="text-light">Contact Us</a>
        </div>
      </div>
    </div>
  </footer>
</body>
</html>