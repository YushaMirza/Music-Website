<?php
session_start();
include '../connection.php';

$sql_users = "SELECT * FROM user_data WHERE id != 1";
$user_results = mysqli_query($con, $sql_users);

$sql_artists = "SELECT * FROM artists";
$artist_results = mysqli_query($con, $sql_artists);

$sql_rev_artists = "SELECT * FROM artists ORDER BY id DESC";
$artist_rev_results = mysqli_query($con, $sql_rev_artists);

$sql_songs = "SELECT * FROM songs";
$song_results = mysqli_query($con, $sql_songs);

$sql_rev_songs = "SELECT * FROM songs ORDER BY id DESC";
$song_rev_results = mysqli_query($con, $sql_rev_songs);

$sql_videos = "SELECT * FROM videos";
$video_results = mysqli_query($con, $sql_videos);

$sql_rev_videos = "SELECT * FROM videos ORDER BY id DESC";
$video_rev_results = mysqli_query($con, $sql_rev_videos);

$sql_albums = "SELECT * FROM albums";
$album_results = mysqli_query($con, $sql_albums);

$sql_rev_albums = "SELECT * FROM albums ORDER BY id DESC";
$album_rev_results = mysqli_query($con, $sql_rev_albums);

?>





<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home | SOUND Group</title>
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

    /* Enhanced Hero Section */
    .hero {
      padding: 80px 0 100px;
      text-align: center;
      position: relative;
      overflow: hidden;
      background: linear-gradient(rgb(0 0 0 / 82%), rgba(0, 0, 0, 0.7)), url('https://images.unsplash.com/photo-1511379938547-c1f69419868d?ixlib=rb-4.0.3&auto=format&fit=crop&w=1950&q=80') center/cover;
      animation: gradientShift 15s infinite alternate;
    }

    @keyframes gradientShift {
      0% { background-position: 0% 50%; }
      100% { background-position: 100% 50%; }
    }

    .hero-content {
      position: relative;
      max-width: 800px;
      margin: 0 auto;
      padding: 0 20px;
      transform: translateY(20px);
      opacity: 0;
      animation: fadeUp 1s ease forwards;
    }

    @keyframes fadeUp {
      to {
        transform: translateY(0);
        opacity: 1;
      }
    }

    .hero h1 {
      font-size: 4.5rem;
      font-weight: 800;
      margin-bottom: 20px;
      text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
      font-family: 'Montserrat', sans-serif;
      background: linear-gradient(to right, #fff, #E1306C, #405DE6);
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
      animation: textGradient 8s infinite alternate;
    }

    @keyframes textGradient {
      0% { background-position: 0% 50%; }
      100% { background-position: 100% 50%; }
    }

    .hero p {
      font-size: 1.5rem;
      color: rgba(255, 255, 255, 0.9);
      margin-bottom: 30px;
      animation: fadeIn 1.5s ease forwards;
      animation-delay: 0.3s;
      opacity: 0;
    }

    @keyframes fadeIn {
      to { opacity: 1; }
    }

    .hero-btn {
      background: var(--gradient);
      border: none;
      padding: 15px 40px;
      font-size: 1.2rem;
      font-weight: 600;
      border-radius: 50px;
      transition: all 0.3s;
      box-shadow: 0 5px 15px rgba(225, 48, 108, 0.4);
      position: relative;
      overflow: hidden;
      z-index: 1;
    }

    .hero-btn::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: linear-gradient(45deg, #405DE6, #E1306C);
      z-index: -1;
      transition: transform 0.5s ease;
      transform: scaleX(0);
      transform-origin: right;
    }

    .hero-btn:hover::before {
      transform: scaleX(1);
      transform-origin: left;
    }

    .hero-btn:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 25px rgba(225, 48, 108, 0.6);
    }

    .floating-badge {
      display: inline-block;
      background: rgba(0, 0, 0, 0.5);
      backdrop-filter: blur(5px);
      padding: 8px 20px;
      border-radius: 30px;
      margin: 0 5px 10px;
      transition: all 0.3s ease;
      animation: up 6s infinite ease-in-out;
      
    }

    @keyframes up {
      0% {
    transform: translateY(0px);
        }
50% {
    transform: translateY(-10px);
}
100% {
    transform: translateY(0px);
}
    }

    .video-card-container {
  position: relative;
  border-radius: 16px;
  overflow: hidden;
  box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
  transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
  aspect-ratio: 16/9;
}

.video-card-container:hover {
  transform: translateY(-10px) scale(1.02);
  box-shadow: 0 20px 40px rgba(225, 48, 108, 0.4);
}

.video-thumbnail {
  position: relative;
  width: 100%;
  height: 100%;
  overflow: hidden;
}

.video-thumbnail img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.5s ease;
}

.video-card-container:hover .video-thumbnail img {
  transform: scale(1.05);
}

.play-overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  align-items: center;
  justify-content: center;
  opacity: 0;
  transition: opacity 0.3s ease;
}

.video-card-container:hover .play-overlay {
  opacity: 1;
}

.play-icon {
  width: 70px;
  height: 70px;
  background: var(--primary);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 28px;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
  transition: transform 0.3s;
}

.video-card-container:hover .play-icon {
  transform: scale(1.1);
}

.video-info {
  position: absolute;
  bottom: 0;
  left: 0;
  width: 100%;
  padding: 20px;
  background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
  z-index: 2;
}

.video-info h4 {
  font-size: 1.3rem;
  font-weight: 700;
  margin-bottom: 5px;
  font-family: 'Montserrat', sans-serif;
}

.video-info p {
  font-size: 0.9rem;
  color: var(--light);
  margin-bottom: 0;
}

.video-stats {
  display: flex;
  gap: 15px;
  margin-top: 10px;
  font-size: 0.85rem;
}

.video-stats span {
  display: flex;
  align-items: center;
  gap: 5px;
}

.video-badge {
  position: absolute;
  top: 15px;
  right: 15px;
  background: linear-gradient(45deg, var(--primary), var(--secondary));
  color: white;
  padding: 5px 15px;
  border-radius: 50px;
  font-size: 12px;
  font-weight: bold;
  z-index: 3;
  box-shadow: 0 3px 10px rgba(0, 0, 0, 0.3);
  animation: pulse 2s infinite;
}

@keyframes pulse {
  0% { box-shadow: 0 0 0 0 rgba(225, 48, 108, 0.7); }
  70% { box-shadow: 0 0 0 10px rgba(225, 48, 108, 0); }
  100% { box-shadow: 0 0 0 0 rgba(225, 48, 108, 0); }
}

    /* Enhanced Media Cards */
    .media-card {
      background: rgba(30, 30, 46, 0.7);
      backdrop-filter: blur(10px);
      border-radius: 16px;
      padding: 20px;
      transition: 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      position: relative;
      overflow: hidden;
      height: 100%;
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
      border: 1px solid rgba(255, 255, 255, 0.1);
      transform: translateY(0);
      opacity: 0;
    }

    .media-card.animate {
      animation: cardAppear 0.6s ease forwards;
    }

    @keyframes cardAppear {
      to {
        transform: translateY(0);
        opacity: 1;
      }
    }

    .media-card:hover {
      transform: translateY(-10px) scale(1.02);
      box-shadow: 0 15px 30px rgba(225, 48, 108, 0.4);
      border-color: rgba(225, 48, 108, 0.3);
    }

    .media-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 5px;
      background: var(--gradient);
      opacity: 0;
      transition: opacity 0.3s;
    }

    .media-card:hover::before {
      opacity: 1;
    }

    .media-card img {
      border-radius: 12px;
      width: 100%;
      height: 200px;
      object-fit: cover;
      transition: transform 0.5s;
      margin-bottom: 15px;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
    }

    .media-card:hover img {
      transform: scale(1.05);
    }

    .play-button {
      position: absolute;
      bottom: 25px;
      right: 25px;
      background: var(--primary);
      border: none;
      border-radius: 50%;
      width: 50px;
      height: 50px;
      display: flex;
      align-items: center;
      justify-content: center;
      opacity: 0;
      transition: 0.3s;
      cursor: pointer;
      box-shadow: 0 5px 15px rgba(225, 48, 108, 0.4);
      transform: scale(0.8);
    }

    .media-card:hover .play-button {
      opacity: 1;
      transform: scale(1);
    }

    .trending-badge {
      background: var(--gradient);
      color: var(--lighter);
      font-size: 12px;
      font-weight: 600;
      padding: 5px 15px;
      border-radius: 50px;
      position: absolute;
      top: 20px;
      right: 15px;
      z-index: 2;
      box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
      animation: pulse 2s infinite;
    }

    @keyframes pulse {
      0% { box-shadow: 0 0 0 0 rgba(225, 48, 108, 0.7); }
      70% { box-shadow: 0 0 0 10px rgba(225, 48, 108, 0); }
      100% { box-shadow: 0 0 0 0 rgba(225, 48, 108, 0); }
    }

    /* Artist Images */
    .artist-img {
      border-radius: 50%;
      width: 160px;
      height: 160px;
      object-fit: cover;
      margin-bottom: 20px;
      border: 3px solid transparent;
      background: var(--gradient) border-box;
      transition: all 0.4s ease;
      box-shadow: 0 5px 25px rgba(0, 0, 0, 0.4);
    }

    .artist-img:hover {
      transform: scale(1.1);
      box-shadow: 0 0 30px rgba(225, 48, 108, 0.6);
    }

    /* Section Enhancements */
    .section {
      padding: 100px 0;
      position: relative;
      overflow: hidden;
    }

    .section-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-end;
      margin-bottom: 50px;
      transform: translateY(20px);
      opacity: 0;
      animation: fadeUp 0.8s ease forwards;
    }

    .section-title {
      font-size: 2.8rem;
      font-weight: 800;
      margin-bottom: 15px;
      color: var(--lighter);
      position: relative;
      display: inline-block;
      font-family: 'Montserrat', sans-serif;
      background: linear-gradient(to right, #fff, #E1306C);
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
    }

    .section-title::after {
      content: '';
      position: absolute;
      bottom: -10px;
      left: 0;
      width: 80px;
      height: 4px;
      background: var(--gradient);
      border-radius: 2px;
    }

    .see-all {
      font-size: 1.1rem;
      color: var(--primary);
      text-decoration: none;
      font-weight: 600;
      transition: all 0.3s;
      display: flex;
      align-items: center;
      gap: 5px;
    }

    .see-all:hover {
      text-decoration: underline;
      gap: 10px;
      color: var(--secondary);
    }

    /* Floating Elements */
    .floating-element {
      position: absolute;
      border-radius: 50%;
      opacity: 0.7;
      z-index: 0;
      filter: blur(40px);
    }

    /* Section Backgrounds */
    .trending-artist-section {
      background: linear-gradient(135deg, #0f0c29, #302b63, #24243e);
    }

    .trending-songs-section {
      background: linear-gradient(135deg, #1a2a6c, #b21f1f, #1a2a6c);
    }

    .trending-videos-section {
      background: linear-gradient(135deg, #3a1c71, #d76d77, #ffaf7b);
    }

    .albums-section {
      background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
    }

    
    .section-content {
      padding: 30px 0;
    }

    .carousel-control-prev,
    .carousel-control-next {
      width: 50px;
      height: 50px;
      background: rgba(255, 255, 255, 0.1);
      border-radius: 50%;
      top: 50%;
      transform: translateY(-50%);
      opacity: 0.7;
      transition: all 0.3s;
      backdrop-filter: blur(5px);
    }

    .carousel-control-prev:hover,
    .carousel-control-next:hover {
      opacity: 1;
      background: var(--primary);
    }

    .carousel-control-prev {
      left: -25px;
    }

    .carousel-control-next {
      right: -25px;
    }

    .hero-btn {
      background: var(--primary);
      border: none;
      padding: 12px 35px;
      font-size: 18px;
      font-weight: 600;
      border-radius: 50px;
      transition: all 0.3s;
      box-shadow: 0 5px 15px rgba(225, 48, 108, 0.4);
    }

    .hero-btn:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 20px rgba(225, 48, 108, 0.6);
    }

    /* Responsive Adjustments */
    @media (max-width: 992px) {
      .hero h1 {
        font-size: 3.5rem;
      }
      
      .section-title {
        font-size: 2.2rem;
      }
    }

    @media (max-width: 768px) {
      .hero h1 {
        font-size: 2.8rem;
      }
      
      .hero p {
        font-size: 1.2rem;
      }
      
      .section-title {
        font-size: 2rem;
      }
      
      .section-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 15px;
      }
    }

    @media (max-width: 576px) {
      .hero h1 {
        font-size: 2.2rem;
      }
      
      .hero p {
        font-size: 1rem;
      }
      
      .section-title {
        font-size: 1.8rem;
      }
    }

    /* Animated Background Elements */
    .animated-bg-element {
      position: absolute;
      border-radius: 50%;
      z-index: -1;
      opacity: 0.3;
      filter: blur(60px);
    }

    /* Scroll Reveal Animation */
    .reveal {
      position: relative;
      transform: translateY(50px);
      opacity: 0;
      transition: all 1s ease;
    }

    .reveal.active {
      transform: translateY(0);
      opacity: 1;
    }



.page-content {
      min-height: calc(100vh - 300px);
      padding: 80px 0;
    }

    .page-title {
      font-size: 42px;
      font-weight: 700;
      margin-bottom: 30px;
      position: relative;
      padding-bottom: 15px;
      font-family: 'Montserrat', sans-serif;
    }

    .page-title::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      width: 80px;
      height: 4px;
      background: var(--primary);
      border-radius: 2px;
    }

    .page-description {
      font-size: 18px;
      max-width: 800px;
      margin-bottom: 40px;
      color: var(--light);
      line-height: 1.7;
    }

    @media (max-width: 768px) {
      .hero h1 {
        font-size: 36px;
      }

      .hero p {
        font-size: 18px;
      }

      .section {
        padding: 50px 0;
      }

      .section-title {
        font-size: 26px;
      }

      .media-card img {
        height: 180px;
      }

      .artist-img {
        width: 120px;
        height: 120px;
      }

      .video-card iframe {
        height: 200px;
      }

      .section-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 15px;
      }

      .page-title {
        font-size: 32px;
      }

      .user-menu {
        gap: 10px;
      }

      .user-name {
        display: none;
      }
    }

    .toggle-password {
    color: var(--light);
    transition: all 0.3s;
}

.toggle-password:hover {
    color: var(--primary);
}



.floating-element, .animated-bg-element {
  position: absolute;
  border-radius: 50%;
  z-index: -1; /* Ensure they stay behind content */
  will-change: transform; /* Optimize for performance */
  pointer-events: none; /* Prevent interaction */
  backface-visibility: hidden; /* Fix rendering glitches */
}

/* Reduce blur intensity */
.floating-element {
  opacity: 0.5;
  filter: blur(30px);
}

.animated-bg-element {
  opacity: 0.3;
  filter: blur(40px);
}

    .about-section {
      padding: 100px 20px;
      position: relative;
      overflow: hidden;
    }

    /* Geometric background elements */
    .geometric-shape {
      position: absolute;
      z-index: -1;
      opacity: 0.05;
    }

    .shape-1 {
      top: 10%;
      left: 5%;
      width: 200px;
      height: 200px;
      border-radius: 50%;
      background: var(--gradient);
      filter: blur(40px);
    }

    .shape-2 {
      bottom: 15%;
      right: 7%;
      width: 150px;
      height: 150px;
      background: var(--primary);
      transform: rotate(45deg);
      filter: blur(30px);
    }

    .shape-3 {
      top: 25%;
      right: 20%;
      width: 100px;
      height: 100px;
      border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
      background: var(--secondary);
      filter: blur(30px);
    }

    .section-header {
      text-align: center;
      margin-bottom: 60px;
      position: relative;
      z-index: 2;
    }

    .section-heading {
      font-size: 14px;
      text-transform: uppercase;
      letter-spacing: 3px;
      color: var(--primary);
      margin-bottom: 15px;
      font-weight: 600;
      position: relative;
          text-align: center;
    width: 40%;
    display: block !important;
    }

    .section-heading::after {
      content: "";
      position: absolute;
      width: 60%;
      height: 3px;
      background: var(--gradient);
      bottom: -8px;
      left: 20%;
      border-radius: 3px;
    }

    .section-title {
      font-size: 3.5rem;
      font-weight: 800;
      margin-bottom: 20px;
      background: linear-gradient(to right, #fff, #E1306C, #405DE6);
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
      font-family: 'Montserrat', sans-serif;
      line-height: 1.2;
    }

    .section-subtitle {
      font-size: 1.3rem;
      color: var(--light);
      max-width: 700px;
      margin: 0 auto;
      line-height: 1.7;
    }

    .about-content {
      display: flex;
      flex-wrap: wrap;
      gap: 50px;
      max-width: 1300px;
      margin: 0 auto;
      padding: 0 20px;
      position: relative;
    }

    .about-text {
      flex: 1;
      min-width: 300px;
      position: relative;
    }

    .about-image-container {
      flex: 1;
      min-width: 300px;
      position: relative;
      perspective: 1000px;
    }

    .image-frame {
      position: relative;
      border-radius: 20px;
      overflow: hidden;
      transform: rotate(-3deg);
      box-shadow: 0 30px 50px rgba(0, 0, 0, 0.5);
      transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      border: 2px solid transparent;
      background: linear-gradient(var(--dark), var(--dark)) padding-box,
                  var(--gradient) border-box;
    }

    .about-image-container:hover .image-frame {
      transform: rotate(0deg) translateY(-15px);
      box-shadow: 0 40px 60px rgba(225, 48, 108, 0.3);
    }

    .about-image {
      width: 100%;
      height: auto;
      display: block;
      transition: transform 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .about-image-container:hover .about-image {
      transform: scale(1.05);
    }

    .floating-element {
      position: absolute;
      width: 80px;
      height: 80px;
      border-radius: 50%;
      background: var(--gradient);
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-size: 1.5rem;
      box-shadow: 0 10px 30px rgba(225, 48, 108, 0.3);
      animation: float 8s ease-in-out infinite;
      z-index: 3;
    }

    .floating-1 {
      top: -30px;
      left: -30px;
      animation-delay: 0s;
    }

    .floating-2 {
      bottom: 30px;
      right: -30px;
      animation-delay: 1s;
      width: 70px;
      height: 70px;
    }

    .floating-3 {
      top: 40%;
      right: 20%;
      animation-delay: 2s;
      width: 60px;
      height: 60px;
    }

    @keyframes float {
      0% { transform: translateY(0px) rotate(0deg); }
      50% { transform: translateY(-7px) rotate(5deg); }
      100% { transform: translateY(0px) rotate(0deg); }
    }

    .about-description {
      font-size: 1.15rem;
      line-height: 1.8;
      color: var(--light);
      margin-bottom: 30px;
      position: relative;
    }

    .highlight {
      background: linear-gradient(90deg, transparent 50%, rgba(225, 48, 108, 0.2) 50%);
      background-size: 200% 100%;
      background-position: 100% 0;
      transition: background-position 0.6s ease;
      padding: 0 5px;
      border-radius: 3px;
    }

    .about-description:hover .highlight {
      background-position: 0 0;
    }

    .features-container {
      display: flex;
      flex-wrap: wrap;
      gap: 25px;
      margin-top: 40px;
    }

    .feature-card {
      flex: 1;
      min-width: 250px;
      background: rgba(30, 30, 46, 0.6);
      backdrop-filter: blur(10px);
      border-radius: 15px;
      padding: 25px;
      transition: all 0.4s ease;
      border: 1px solid rgba(255, 255, 255, 0.1);
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
      position: relative;
      overflow: hidden;
      z-index: 1;
    }

    .feature-card::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      width: 5px;
      height: 0;
      background: var(--gradient);
      transition: height 0.5s ease;
      z-index: -1;
    }

    .feature-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 15px 30px rgba(225, 48, 108, 0.3);
    }

    .feature-card:hover::before {
      height: 100%;
    }

    .feature-icon {
      font-size: 2.5rem;
      margin-bottom: 20px;
      color: var(--primary);
      transition: all 0.3s ease;
    }

    .feature-card:hover .feature-icon {
      transform: scale(1.2);
      color: var(--lighter);
    }

    .feature-title {
      font-size: 1.3rem;
      font-weight: 700;
      margin-bottom: 15px;
      color: var(--lighter);
      font-family: 'Montserrat', sans-serif;
    }

    .feature-description {
      font-size: 0.95rem;
      color: var(--light);
      line-height: 1.6;
    }

    .cta-container {
      text-align: center;
      margin-top: 50px;
      position: relative;
      z-index: 2;
    }

    .cta-button {
      display: inline-block;
      background: var(--gradient);
      color: white;
      padding: 16px 40px;
      border-radius: 50px;
      text-decoration: none;
      font-weight: 600;
      font-size: 1.2rem;
      transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      position: relative;
      overflow: hidden;
      box-shadow: 0 15px 35px rgba(225, 48, 108, 0.4);
      border: none;
    }

    .cta-button::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: linear-gradient(45deg, #405DE6, #E1306C);
      z-index: -1;
      transition: transform 0.5s ease;
      transform: scaleX(0);
      transform-origin: right;
    }

    .cta-button:hover {
      transform: translateY(-5px) scale(1.05);
      box-shadow: 0 20px 40px rgba(225, 48, 108, 0.6);
    }

    .cta-button:hover::before {
      transform: scaleX(1);
      transform-origin: left;
    }

    /* Responsive adjustments */
    @media (max-width: 992px) {
      .section-title {
        font-size: 2.8rem;
      }
      
      .about-content {
        flex-direction: column;
      }
      
      .image-frame {
        transform: rotate(0deg);
        max-width: 600px;
        margin: 0 auto;
      }
    }
    
    @media (max-width: 768px) {
      .section-title {
        font-size: 2.3rem;
      }
      
      .section-subtitle {
        font-size: 1.1rem;
      }
      
      .feature-card {
        min-width: 100%;
      }
      
      .floating-element {
        display: none;
      }
    }
    
    @media (max-width: 576px) {
      .section-title {
        font-size: 2rem;
      }
      
      .about-section {
       padding: 70px 15px;
      }
    }
    
    /* Adjust video card for 5 items */
    .video-card-container.smaller {
      height: 100%;
    }
    
    .video-card-container.smaller .video-info {
      padding: 15px;
    }
    
    .video-card-container.smaller .video-info h4 {
      font-size: 1.1rem;
    }
    
    .video-card-container.smaller .video-info p {
      font-size: 0.85rem;
    }
    
    .video-card-container.smaller .video-stats {
      font-size: 0.8rem;
    }


  </style>

</head>

<body>
  <?php
  include 'header.php'
  ?>
  
  <!-- Enhanced Hero Section -->
  <section class="hero">
    <!-- Animated background elements -->
    <div class="animated-bg-element" style="width: 300px; height: 300px; background: var(--primary); top: 10%; left: 10%; animation: float 8s infinite ease-in-out;"></div>
    <div class="animated-bg-element" style="width: 200px; height: 200px; background: var(--secondary); bottom: 20%; right: 15%; animation: float 12s infinite ease-in-out reverse;"></div>
    
    <div class="hero-content">
      <h1>Discover Viral Music on SOUND Group</h1>
      <p>Explore the hottest songs, artists and videos trending right now</p>
      <a href="#about" class="btn hero-btn">Learn More</a>
      <div class="mt-4 d-flex justify-content-center gap-3 flex-wrap">
        <span class="floating-badge">#1 Music Platform</span>
        <?php
        if(mysqli_num_rows($user_results) <= 10 || mysqli_num_rows($artist_results) <= 10){
          $users = mysqli_num_rows($user_results);
          $artists = mysqli_num_rows($artist_results);
        }else if(mysqli_num_rows($user_results) > 10 || mysqli_num_rows($artist_results) > 10){
          $users = "10+";
          $artists = "10+";
        }else if(mysqli_num_rows($user_results) > 20 || mysqli_num_rows($artist_results) > 20){
          $users = "20+";
          $artists = "20+";
        }else if(mysqli_num_rows($user_results) > 30 || mysqli_num_rows($artist_results) > 30){
          $users = "30+";
          $artists = "30+";
        }else if(mysqli_num_rows($user_results) > 40 || mysqli_num_rows($artist_results) > 40){
          $users = "40+";
          $artists = "40+";
        }else if(mysqli_num_rows($user_results) > 50 || mysqli_num_rows($artist_results) > 50){
          $users = "50+";
          $artists = "50+";
        }
        ?>
        <span class="floating-badge" style="animation-delay: 0.3s;"><?php echo $users ?> Users</span>
        <span class="floating-badge" style="animation-delay: 0.6s;"><?php echo $artists ?> Artists</span>
      </div>
    </div>
  </section>
  
  <!-- New About Section -->
 <section class="about-section" id="about">
    <!-- Geometric background elements -->
    <div class="geometric-shape shape-1"></div>
    <div class="geometric-shape shape-2"></div>
    <div class="geometric-shape shape-3"></div>
    
    <div class="section-heading">Our Story</div>
    <div class="section-header">
      <h2 class="section-title">Why SOUND Group?</h2>
      <p class="section-subtitle">Discover the platform that connects music lovers with the hottest trends on Instagram</p>
    </div>
    
    <div class="about-content">
      <div class="about-text">
        <p class="about-description">
          <span class="highlight">SOUND Group</span> was born from a simple idea: to create the ultimate destination for discovering 
          the <span class="highlight">hottest music trends</span> on Instagram. We saw how viral sounds were shaping 
          social media and wanted to build a platform that makes it easy to find, explore, 
          and enjoy these musical moments.
        </p>
        
        <p class="about-description">
          Our team of music enthusiasts and tech experts work tirelessly to track 
          <span class="highlight">viral songs</span>, identify <span class="highlight">trending artists</span>, and curate the most popular 
          videos. We bring you the pulse of what's happening in the music world, updated 
          in real-time as trends emerge and evolve.
        </p>
        
        <div class="features-container">
          <div class="feature-card">
            <div class="feature-icon">
              <i class="fas fa-music"></i>
            </div>
            <h3 class="feature-title">Real-time Trends</h3>
            <p class="feature-description">
              Track songs as they gain popularity on Instagram with our live trend monitoring.
            </p>
          </div>
          
          <div class="feature-card">
            <div class="feature-icon">
              <i class="fas fa-chart-line"></i>
            </div>
            <h3 class="feature-title">Artist Discovery</h3>
            <p class="feature-description">
              Find emerging artists before they hit the mainstream with our spotlight features.
            </p>
          </div>
        </div>
        
        <div class="features-container">
          <div class="feature-card">
            <div class="feature-icon">
              <i class="fas fa-headphones"></i>
            </div>
            <h3 class="feature-title">Curated Albums</h3>
            <p class="feature-description">
              Listen to albums created from trending sounds across Instagram.
            </p>
          </div>
          
          <div class="feature-card">
            <div class="feature-icon">
              <i class="fas fa-bolt"></i>
            </div>
            <h3 class="feature-title">Viral Predictions</h3>
            <p class="feature-description">
              See which songs are about to blow up with our predictive algorithms.
            </p>
          </div>
        </div>
      </div>
      
      <div class="about-image-container">
        <div class="image-frame">
          <img src="https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80" alt="SOUND Group platform" class="about-image">
        </div>
        <div class="floating-element floating-1">
          <i class="fas fa-music"></i>
        </div>
        <div class="floating-element floating-2">
          <i class="fas fa-chart-line"></i>
        </div>
        <div class="floating-element floating-3">
          <i class="fas fa-heart"></i>
        </div>
      </div>
    </div>
    
    <div class="cta-container">
      <a href="#artists" class="cta-button">Start Exploring Now</a>
    </div>
  </section>

  <!-- Trending Artists -->
  <section class="section trending-artist-section reveal" id="artists">
    <div class="container">
      <div class="section-header">
        <div>
          <div class="section-heading">Top Artists</div>
          <h2 class="section-title">Trending Artists</h2>
        </div>
        <a onclick="navigateTo('artists')" class="see-all">View All <i class="bi bi-arrow-right"></i></a>
      </div>

      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 g-4">

      <?php

      $count = 0;
      
        if (mysqli_num_rows($artist_rev_results) > 0) {
          while ($rows = mysqli_fetch_assoc($artist_rev_results)) {

            if ($count >= 5) break;
            
           echo '

        <!-- Artist 1 -->
        <div class="col">
  <div class="text-center artist-card" onclick="navigateTo(\'artist\', ' . $rows['id'] . ')">
    <img src="../../admin/uploads/artists/' . $rows['image'] . '" alt="' . $rows['name'] . '" class="artist-img">
    <h4>' . $rows['name'] . '</h4>
    <p>' . $rows['genres'] . ' • 12M followers</p>
    <span class="trending-badge">+320K this week</span>
  </div>
</div>

        ';

        $count++;
        
        }
      }
    ?>

      </div>
    </div>
  </section>

  <section class="section trending-songs-section reveal" id="trending">
    <div class="container">
      <div class="section-header">
        <div>
          <div class="section-heading">Viral Tracks</div>
          <h2 class="section-title">Latest Songs</h2>
        </div>
        <a onclick="navigateTo('songs')" class="see-all">View All <i class="bi bi-arrow-right"></i></a>
      </div>

      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 g-4">

      <?php
      $count = 0;
      
        if (mysqli_num_rows($song_rev_results) > 0) {
          while ($rows = mysqli_fetch_assoc($song_rev_results)) {
            $viralBadge = ($rows['new_flag'] == 'NEW') 
      ? '<span class="trending-badge">NEW</span>' 
      : '';

      if ($count >= 5) break;
      
           echo '
        <div class="col">
          <div class="media-card">
            <img
              src="../../admin/uploads/songscover/' . $rows['image'] . '"
              alt="' . $rows['title'] . '">
            <h4>' . $rows['title'] . '</h4>
            <p>' . $rows['artist'] . '</p>
            <div class="stats">
              <span><i class="bi bi-play-fill"></i> 8.7M</span>
              <span><i class="bi bi-heart-fill"></i> 1.1M</span>
            </div>
            ' . $viralBadge . '
            <button class="play-button" onclick="navigateTo(\'song\', ' . $rows['id'] . ')"><i class="bi bi-play-fill"></i></button>
          </div>
        </div>
        
        ';

        $count++;
        }
      }
    ?>
      </div>
    </div>
  </section>

  <section class="section trending-videos-section reveal" id="videos">
    <div class="container">
      <div class="section-header">
        <div>
          <div class="section-heading">Popular Videos</div>
          <h2 class="section-title">Latest Music Videos</h2>
        </div>
        <a onclick="navigateTo('videos')" class="see-all">View All <i class="bi bi-arrow-right"></i></a>
      </div>
      <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-5 g-4">
        <?php
        $count = 0;
        
        if (mysqli_num_rows($video_rev_results) > 0) {
          while ($rows = mysqli_fetch_assoc($video_rev_results)) {
            $viralBadge = ($rows['new_flag'] == 'Yes') 
      ? '<span class="trending-badge">NEW</span>' 
      : '';

      if ($count >= 5) break;
      
           echo '
        <div class="col">
          <div class="video-card-container smaller" onclick="navigateTo(\'video\', ' . $rows['id'] . ')">
            <div class="video-thumbnail">
              <img src="../../admin/uploads/videoscover/' . $rows['image'] . '" alt="' . $rows['artist'] . ' - ' . $rows['title'] . '">
              <div class="play-overlay">
                <div class="play-icon">
                  <i class="bi bi-play-fill"></i>
                </div>
              </div>
            </div>
            <div class="video-info">
              <h4>' . $rows['title'] . '</h4>
              <p>' . $rows['artist'] . '</p>
              <div class="video-stats">
                <span><i class="bi bi-play-fill"></i> 1.2B views</span>
                <span><i class="bi bi-heart-fill"></i> 18M</span>
              </div>
            </div>
            ' . $viralBadge . '
          </div>
        </div>
        ';

        $count++;
        
        }
      }
    ?>
      </div>
    </div>
  </section>

  <section class="section albums-section reveal" id="albums">
    <div class="container">
      <div class="section-header">
        <div>
          <div class="section-heading">For You</div>
          <h2 class="section-title">Trending Albums</h2>
        </div>
        <a onclick="navigateTo('albums')" class="see-all">View All <i class="bi bi-arrow-right"></i></a>
      </div>
      <div class="row g-4">



      <?php

      $count = 0;
      
        if (mysqli_num_rows($album_rev_results) > 0) {
          while ($rows = mysqli_fetch_assoc($album_rev_results)) {

            $songsArray = array_filter(array_map('trim', explode(',', $rows['songs'])));
            $songCount = count($songsArray);
            $videosArray = array_filter(array_map('trim', explode(',', $rows['videos'])));
            $videoCount = count($videosArray);
            $trackCount = $songCount + $videoCount;

            if ($count >= 4) break;

           echo '
      
        <div class="col-md-3 col-sm-6">
          <div class="media-card">
            <img
              src="../../admin/uploads/albumscover/' . $rows['cover_image'] . '"
              alt="' . $rows['title'] . ' album cover">
            <h4>' . $rows['title'] . '</h4>
            <p>' . $trackCount . ' tracks • 2h 30m</p>
            <button class="play-button" onclick="navigateTo(\'album\', ' . $rows['id'] . ')"><i class="bi bi-play-fill"></i></button>
          </div>
        </div>
      
      ';

      $count++;
      
        }
      }
    ?>
    </div>
    </div>
  </section>

  <?php
  include 'footer.php'
  ?>

  <?php
  include 'auth-modals.php'
  ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
     document.addEventListener('DOMContentLoaded', function() {
      const animateOnScroll = (element) => {
        element.style.opacity = "0";
        element.style.transform = "translateY(30px)";
        element.style.transition = "opacity 0.8s ease, transform 0.8s ease";
        
        setTimeout(() => {
          element.style.opacity = "1";
          element.style.transform = "translateY(0)";
        }, 300);
      };
      
      // Animate the main elements
      animateOnScroll(document.querySelector('.section-header'));
      animateOnScroll(document.querySelector('.about-text'));
      animateOnScroll(document.querySelector('.about-image-container'));
    });




document.addEventListener('DOMContentLoaded', function() {
            const featureCards = document.querySelectorAll('.feature-card');
            
            featureCards.forEach((card, index) => {
                // Add delay for staggered animation
                card.style.transitionDelay = `${index * 0.1}s`;
            });
            
            // Add animation to the image when it comes into view
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = "1";
                        entry.target.style.transform = "translateY(0)";
                    }
                });
            }, { threshold: 0.1 });
            
            const aboutImage = document.querySelector('.about-image');
            aboutImage.style.opacity = "0";
            aboutImage.style.transform = "translateY(50px)";
            aboutImage.style.transition = "opacity 0.8s ease, transform 0.8s ease";
            
            observer.observe(aboutImage);
        });




        // Navbar scroll effect
    window.addEventListener('scroll', function() {
      const navbar = document.querySelector('.navbar');
      if (window.scrollY > 50) {
        navbar.classList.add('navbar-scrolled');
      } else {
        navbar.classList.remove('navbar-scrolled');
      }
    });

    // Scroll reveal animation
    function reveal() {
      const reveals = document.querySelectorAll('.reveal');
      for (let i = 0; i < reveals.length; i++) {
        const windowHeight = window.innerHeight;
        const elementTop = reveals[i].getBoundingClientRect().top;
        const elementVisible = 150;
        
        if (elementTop < windowHeight - elementVisible) {
          reveals[i].classList.add('active');
          
          // Animate cards after section appears
          const cards = reveals[i].querySelectorAll('.media-card');
          cards.forEach((card, index) => {
            card.classList.add('animate');
            card.style.animationDelay = `${index * 0.1}s`;
          });
        }
      }
    }

    window.addEventListener('scroll', reveal);
    reveal(); // Initialize

    // Create floating background elements
    function createFloatingElements() {
      const sections = document.querySelectorAll('.section');
      sections.forEach(section => {
        for (let i = 0; i < 3; i++) {
          const element = document.createElement('div');
          element.classList.add('floating-element');
          
          // Random properties
          const size = Math.random() * 200 + 100;
          const colors = [getComputedStyle(document.documentElement).getPropertyValue('--primary'), 
                         getComputedStyle(document.documentElement).getPropertyValue('--secondary'),
                         'rgba(255, 255, 255, 0.2)'];
          const color = colors[Math.floor(Math.random() * colors.length)];
          
          const posX = Math.random() * 100;
          const posY = Math.random() * 100;
          const animationDuration = Math.random() * 15 + 10;
          const animationDelay = Math.random() * 5;
          
          element.style.width = `${size}px`;
          element.style.height = `${size}px`;
          element.style.left = `${posX}%`;
          element.style.top = `${posY}%`;
          element.style.animationDuration = `${animationDuration}s`;
          element.style.animationDelay = `${animationDelay}s`;
          element.style.background = color;
          
          section.appendChild(element);
        }
      });
    }






function navigateTo(page, id = null) {
    if (!isLoggedIn) {
      const loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
    loginModal.show();
    return;
    }

    // Logged in? Redirect based on selected page
    switch (page) {
      case 'home':
        window.location.href = 'home-page.php';
        break;
      case 'songs':
        window.location.href = 'songs-page.php';
        break;
      case 'artists':
        window.location.href = 'artists-page.php';
        break;
      case 'videos':
        window.location.href = 'videos-page.php';
        break;
      case 'albums':
        window.location.href = 'albums-page.php';
        break;
      case 'search':
        window.location.href = 'search-page.php';
        break;
        case 'song':
        if (id !== null) {
        window.location.href = `song.php?id=${id}`;
          }
        break;
        case 'artist':
        if (id !== null) {
        window.location.href = `artist.php?artist=${id}`;
          }
        break;
        case 'video':
        if (id !== null) {
        window.location.href = `video.php?id=${id}`;
          }
        break;
        case 'album':
        if (id !== null) {
        window.location.href = `album.php?album=${id}`;
          }
        break;
        case 'contact':
        window.location.href = 'contact.php';
        break;
        case 'favorites':
        window.location.href = 'favorites.php';
        break;
        default:
        alert("Page Not Found");
    }
  }

    
  </script>
</body>
</html>

