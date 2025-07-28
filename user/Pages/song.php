<?php
session_start();
include '../connection.php';

$song_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Query to get song details
$query = "SELECT * FROM songs WHERE id = $song_id";
$result = mysqli_query($con, $query);
$song = mysqli_fetch_assoc($result);

$sql_other_songs = "SELECT * FROM songs WHERE id != $song_id LIMIT 8";
$other_result = mysqli_query($con, $sql_other_songs);

if (!$song) {
  echo "<h2>Song not found.</h2>";
  exit;
}

$songPath = "../../admin/uploads/songs/" . $song['file'];

// Check if user has favorited this song
$is_favorite = false;
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $check_fav = mysqli_query($con, "SELECT * FROM favorites WHERE user_id = $user_id AND song_id = $song_id");
    $is_favorite = mysqli_num_rows($check_fav) > 0;
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $song['title']; ?> | SOUND Group</title>
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
      --mdlight: rgb(230, 230, 230);
      --lighter: #fff;
      --gradient: linear-gradient(135deg, var(--primary), var(--secondary));
    }

    html{
      scroll-behavior: smooth;
      overflow-x: hidden;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #0f0c29, #1a1a2e, #16213e);
      color: var(--lighter);
      margin: 0;
      padding: 0;
      overflow-x: hidden;
      min-height: 100vh;
    }

    
    /* Player Container */
    .player-container {
      display: grid;
      grid-template-columns: 320px 1fr;
      height: calc(100vh - 70px);
    }

    /* Sidebar */
    .sidebar {
      background: rgba(10, 10, 20, 0.85);
      backdrop-filter: blur(10px);
      padding: 30px 20px;
      border-right: 1px solid rgba(255, 255, 255, 0.1);
      overflow-y: auto;
      position: relative;
      z-index: 2;
      height: 100vh;
    position: sticky;
    top: 80px;
    }

    .sidebar-header {
      margin-bottom: 30px;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .sidebar-header h3 {
      font-family: 'Montserrat', sans-serif;
      font-weight: 700;
      color: var(--lighter);
      display: flex;
      align-items: center;
      margin: 0;
    }

    .sidebar-header h3 i {
      color: var(--primary);
      margin-right: 10px;
    }

    .queue-count {
      background: var(--gradient);
      color: white;
      font-size: 12px;
      font-weight: 600;
      padding: 3px 10px;
      border-radius: 50px;
      width: 85px;
    }

    .queue-item {
      display: flex;
      align-items: center;
      padding: 12px 15px;
      border-radius: 12px;
      margin-bottom: 10px;
      transition: all 0.3s;
      cursor: pointer;
      background: rgba(30, 30, 46, 0.5);
      backdrop-filter: blur(5px);
      border: 1px solid rgba(255, 255, 255, 0.05);
    }

    .queue-item:hover {
      background: rgba(255, 255, 255, 0.1);
      transform: translateX(5px);
    }

    .queue-item.active {
      background: rgba(225, 48, 108, 0.2);
      border-left: 3px solid var(--primary);
      box-shadow: 0 5px 15px rgba(225, 48, 108, 0.2);
    }

    .queue-item img {
      width: 50px;
      height: 50px;
      border-radius: 8px;
      object-fit: cover;
      margin-right: 15px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    }

    .queue-info {
      flex: 1;
    }

    .queue-info h5 {
      font-size: 16px;
      margin-bottom: 5px;
      color: var(--lighter);
      font-weight: 600;
    }

    .queue-info p {
      font-size: 13px;
      color: var(--light);
      margin: 0;
    }

    .queue-duration {
      font-size: 12px;
      color: var(--light);
      background: rgba(0, 0, 0, 0.4);
      padding: 3px 8px;
      border-radius: 4px;
    }

    /* Main Player */
    .main-player {
      display: flex;
      flex-direction: column;
      position: relative;
    }

    .player-bg {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-size: cover;
      background-position: center;
      filter: blur(30px) brightness(0.7);
      opacity: 0.7;
      z-index: -2;
      transition: all 1s ease;
    }

    .player-overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: linear-gradient(135deg, rgb(26 26 46 / 42%), rgba(22, 33, 62, 0.9));
      z-index: -1;
    }

    .player-content {
      flex: 1;
      display: flex;
      flex-direction: column;
      padding: 40px;
      position: relative;
      z-index: 1;
    }

    /* Album Art */
    .album-art-container {
      display: flex;
      justify-content: center;
      align-items: center;
      flex: 1;
      position: relative;
    }

    .album-art-wrapper {
      position: relative;
      width: 400px;
      height: 400px;
      perspective: 1000px;
    }

    .album-art {
      width: 100%;
      height: 100%;
      border-radius: 15px;
      object-fit: cover;
      box-shadow: 0 30px 50px rgba(0, 0, 0, 0.6);
      transition: all 0.5s;
      position: relative;
      transform-style: preserve-3d;
      animation: floatAlbum 8s infinite ease-in-out;
    }

    @keyframes floatAlbum {
      0% { transform: translateY(0) rotate(0deg); }
      50% { transform: translateY(-15px) rotate(2deg); }
      100% { transform: translateY(0) rotate(0deg); }
    }

    @keyframes rotate {
      from { transform: rotate(0deg); }
      to { transform: rotate(360deg); }
    }

    /* Song Info */
    .song-info {
      text-align: center;
      margin-top: 30px;
    }

    .song-info h1 {
      font-size: 42px;
      font-weight: 800;
      margin-bottom: 8px;
      font-family: 'Montserrat', sans-serif;
      background: linear-gradient(to right, #fff, #ff9dbb);
      -webkit-background-clip: text;
      background-clip: text;
      -webkit-text-fill-color: transparent;
      text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    }

    .song-info h2 {
      font-size: 22px;
      color: var(--light);
      font-weight: 500;
      margin-bottom: 25px;
    }

    .song-tags {
      display: flex;
      justify-content: center;
      gap: 12px;
      margin-bottom: 30px;
      flex-wrap: wrap;
    }

    .song-tag {
      background: rgba(255, 255, 255, 0.1);
      color: var(--lighter);
      padding: 8px 20px;
      border-radius: 50px;
      font-size: 14px;
      font-weight: 600;
      transition: all 0.3s;
      backdrop-filter: blur(5px);
    }

    .song-tag.primary {
      background: var(--gradient);
      box-shadow: 0 4px 15px rgba(225, 48, 108, 0.4);
    }

    .song-tag:hover {
      transform: translateY(-3px);
      box-shadow: 0 5px 15px rgba(255, 255, 255, 0.1);
    }

    /* Player Controls */
    .player-controls {
      margin-top: 30px;
    }

    .progress-container {
      margin-bottom: 35px;
    }

    .progress-time {
      display: flex;
      justify-content: space-between;
      margin-bottom: 10px;
      font-size: 14px;
      color: var(--light);
    }

    .progress-bar {
      height: 8px;
      background: rgba(255, 255, 255, 0.1);
      border-radius: 4px;
      cursor: pointer;
      position: relative;
    }

    .progress {
      height: 100%;
      background: var(--gradient);
      border-radius: 4px;
      width: 30%;
      position: relative;
      transition: width 0.2s linear;
    }

    .progress-handle {
      width: 16px;
      height: 16px;
      background: var(--lighter);
      border-radius: 50%;
      position: absolute;
      right: -8px;
      top: 50%;
      transform: translateY(-50%);
      opacity: 0;
      transition: opacity 0.3s;
      box-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
    }

    .progress-bar:hover .progress-handle {
      opacity: 1;
    }

    /* Waveform Visualization */
    .waveform {
      height: 60px;
      display: flex;
      align-items: flex-end;
      justify-content: center;
      gap: 3px;
      margin: 20px 0 30px;
    }

    @media (max-width: 800px){
      .waveform {
        display: none !important;
      }

      .player-controls {
    margin-bottom: 5rem;
}
    }

    .wave-bar {
      width: 4px;
      background: rgba(255, 255, 255, 0.3);
      border-radius: 2px;
      transition: height 0.2s ease;
    }

    .control-buttons {
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 30px;
    }

    .control-btn {
      background: transparent;
      border: none;
      color: var(--lighter);
      font-size: 24px;
      cursor: pointer;
      transition: all 0.3s;
      width: 55px;
      height: 55px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      backdrop-filter: blur(5px);
      background: rgba(255, 255, 255, 0.08);
    }

    .control-btn:hover {
      color: var(--primary);
      background: rgba(255, 255, 255, 0.15);
      transform: scale(1.1);
    }

    .control-btn.play-btn {
      background: var(--lighter);
      color: var(--dark);
      width: 80px;
      height: 80px;
      font-size: 32px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.4);
    }

    .control-btn.play-btn:hover {
      transform: scale(1.1);
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.5);
    }

    .volume-control {
      display: flex;
      align-items: center;
      gap: 15px;
      margin-top: 35px;
      justify-content: center;
    }

    .volume-slider {
      width: 150px;
      cursor: pointer;
      background: rgba(255, 255, 255, 0.1);
      border-radius: 10px;
      height: 6px;
      appearance: none;
      outline: none;
    }

    .volume-slider::-webkit-slider-thumb {
      appearance: none;
      width: 16px;
      height: 16px;
      border-radius: 50%;
      background: var(--lighter);
      cursor: pointer;
      box-shadow: 0 0 5px rgba(0, 0, 0, 0.5);
    }

    /* Lyrics Section */
    .lyrics-container {
      background: rgba(0, 0, 0, 0.4);
      backdrop-filter: blur(10px);
      padding: 30px;
      border-radius: 20px;
      margin-top: 40px;
      max-height: 220px;
      overflow-y: auto;
      border: 1px solid rgba(255, 255, 255, 0.1);
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    }

    .lyrics-container h3 {
      font-family: 'Montserrat', sans-serif;
      margin-bottom: 20px;
      color: var(--primary);
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .lyrics-content {
      line-height: 1.9;
      color: var(--light);
      font-size: 18px;
      text-align: center;
    }

    .lyrics-line {
      transition: all 0.3s;
      padding: 5px 0;
    }

    .lyrics-line.active {
      color: var(--lighter);
      font-weight: 600;
      font-size: 20px;
      text-shadow: 0 0 10px rgba(225, 48, 108, 0.5);
      transform: scale(1.05);
    }

    /* Floating particles */
    .particles {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: -1;
      pointer-events: none;
    }

    .particle {
      position: absolute;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.1);
      animation: floatParticle 15s infinite linear;
    }

    @keyframes floatParticle {
      0% { transform: translateY(0) translateX(0) rotate(0deg); opacity: 0; }
      10% { opacity: 1; }
      90% { opacity: 1; }
      100% { transform: translateY(-100vh) translateX(100px) rotate(360deg); opacity: 0; }
    }

    /* Responsive Styles */
    @media (max-width: 1200px) {
      .album-art-wrapper {
        width: 350px;
        height: 350px;
      }
      
      .song-info h1 {
        font-size: 36px;
      }
    }

    @media (max-width: 992px) {
      .player-container {
        grid-template-columns: 1fr;
        height: auto;
      }
      
      .sidebar {
        display: none;
      }
      
      .album-art-wrapper {
        width: 300px;
        height: 300px;
        margin-top: 30px;
      }
      
      .player-content {
        padding: 30px 20px;
      }
    }

    @media (max-width: 576px) {
      .album-art-wrapper {
        width: 250px;
        height: 250px;
      }
      
      .song-info h1 {
        font-size: 28px;
      }
      
      .song-info h2 {
        font-size: 18px;
      }
      
      .control-buttons {
        gap: 20px;
      }
      
      .control-btn {
        width: 45px;
        height: 45px;
        font-size: 20px;
      }
      
      .control-btn.play-btn {
        width: 70px;
        height: 70px;
        font-size: 28px;
      }
      
      .lyrics-content {
        font-size: 16px;
      }
    }




    body {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
  }
  
  /* Adjust player container height */
  .player-container {
    height: calc(100vh - 70px - 60px); /* Subtract header and footer height */
    flex: 1;
  }
  
  /* Style the footer */
  footer {
    background: rgba(0, 0, 0, 0.85);
    color: var(--light);
    padding: 20px 0;
    text-align: center;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    position: relative;
    z-index: 100;
    height: 23rem !important;
    margin-top: 3rem !important;
  }





   /* Glass effect */
.rating-section.glass {
  margin-top: 30px;
  padding: 25px;
  border-radius: 20px;
  background: rgba(255, 255, 255, 0.05);
  backdrop-filter: blur(12px);
  border: 1px solid rgba(255, 255, 255, 0.15);
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.25);
  transition: all 0.3s;
}

/* Titles */
.rating-title {
  font-size: 22px;
  font-weight: 600;
  font-family: 'Montserrat', sans-serif;
  color: #fff;
  margin-bottom: 5px;
}

.rating-subtitle {
  font-size: 14px;
  color: #ccc;
  margin-bottom: 15px;
}

/* Stars */
.rating-stars {
  display: flex;
  gap: 12px;
  margin-bottom: 20px;
}

.rating-stars i {
  font-size: 30px;
  color: #888;
  transition: transform 0.2s ease, color 0.2s ease;
  cursor: pointer;
}

.rating-stars i:hover,
.rating-stars i.active {
  color: #ffd700;
  transform: scale(1.2);
}

/* Textarea */
.rating-section textarea {
  width: 100%;
  padding: 12px;
  border-radius: 10px;
  border: none;
  background: rgba(255, 255, 255, 0.07);
  color: #fff;
  font-family: inherit;
  resize: none;
  margin-bottom: 15px;
}

.rating-section textarea::placeholder {
  color: #bbb;
}

/* Button */
.submit-rating {
  padding: 10px 28px;
  border: none;
  border-radius: 30px;
  background: linear-gradient(135deg, #ff4d79, #6c5ce7);
  color: #fff;
  font-weight: bold;
  font-size: 14px;
  cursor: pointer;
  transition: 0.3s ease;
}

.submit-rating:hover {
  transform: translateY(-2px);
  box-shadow: 0 5px 20px rgba(255, 77, 121, 0.4);
}

/* Message */
.rating-message {
  margin-top: 10px;
  font-size: 14px;
  color: #00ffae;
  min-height: 20px;
}









.player {
            margin-top: 40px;
        }
        audio {
            width: 100%;
            margin-top: 20px;
        }
        .controls {
            margin: 20px 0;
        }
        .controls button {
            padding: 10px 20px;
            margin: 0 10px;
        }

        #progressBar {
  background-color: #4caf50;
  height: 100%;
  width: 0%;
  transition: width 0.3s ease;
}


  .notification {
      position: fixed;
      top: 20px;
      right: 20px;
      padding: 15px 25px;
      background: linear-gradient(135deg, #E1306C, #405DE6);
      color: white;
      border-radius: 10px;
      z-index: 10000;
      box-shadow: 0 5px 15px rgba(0,0,0,0.3);
      animation: fadeInOut 3s forwards;
      display: none;
    }
    
    @keyframes fadeInOut {
      0% { opacity: 0; transform: translateY(-20px); }
      10% { opacity: 1; transform: translateY(0); }
      90% { opacity: 1; transform: translateY(0); }
      100% { opacity: 0; transform: translateY(-20px); }
    }


  </style>
</head>
<body>

    <div id="notification" class="notification"></div>

  <audio id="audioPlayer" src="<?php echo $songPath; ?>"></audio>
  
  
  
  <?php
  include 'header.php';
  ?>


<ul id="playlist" style="display: none;">
  <?php foreach ($songs as $songPath): ?>
    <li><?= str_replace('../../', '', $songPath); ?></li>
  <?php endforeach; ?>
</ul>


  <!-- Player Container -->
  <div class="player-container">
    <!-- Sidebar - Queue List -->
    <div class="sidebar">
      <div class="sidebar-header">
        <h3><i class="bi bi-music-note-list"></i> Play Queue</h3>
        <span class="queue-count"><?php echo mysqli_num_rows($other_result) ?> songs</span>
      </div>
      <div class="queue-list">
        <?php
  $sql_other_songs = "SELECT * FROM songs WHERE id != $song_id LIMIT 8";
      $other_result = mysqli_query($con, $sql_other_songs);
            if (mysqli_num_rows($other_result) > 0) {
                while ($other = mysqli_fetch_assoc($other_result)) {
                    echo '
          <div class="queue-item" onclick=location.href="song.php?id=' .  $other['id']  . '">
             <img src="../../admin/uploads/songscover/' . $other['image'] . '" alt="' . htmlspecialchars($other['title']) . '">
            <div class="queue-info">
              <h5>' . $other['title'] . '</h5>
              <p>' . $other['album'] . '</p>
            </div>
            <div class="queue-duration">3:20</div>
          </div>
          ';
                }
            } else {
      echo '<div class="text-center  py-3">No other artists in queue</div>';
  }
            ?>
      </div>
    </div>
    
    <!-- Main Player Content -->
    <div class="main-player">
      <!-- Floating Particles -->
      <div class="particles" id="particles"></div>
      
      <!-- Dynamic Background -->
      <div class="player-bg" style="background-image: url('https://i.scdn.co/image/ab67616d00001e02ff9ca10b55ce82ae553c8228');"></div>
      <div class="player-overlay"></div>
      
      <div class="player-content">
        


      <?php
$sql_song = "SELECT * FROM songs WHERE id = $song_id";
$song_result = mysqli_query($con, $sql_song);

if (mysqli_num_rows($song_result) > 0) {
    while ($rows = mysqli_fetch_assoc($song_result)) {

        $is_favorite = false;
        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
            $song_id = $rows['id']; // assuming song ID is $rows['id']
            $check_fav = mysqli_query($con, "SELECT * FROM favorites WHERE user_id = $user_id AND song_id = $song_id");
            $is_favorite = mysqli_num_rows($check_fav) > 0;
        }

        $icon_class = $is_favorite ? 'bi-heart-fill' : 'bi-heart';
        $icon_color = $is_favorite ? '#E1306C' : 'gray';
        $logged_in = isset($_SESSION['user_id']) ? '1' : '0';

        $new = ($rows['new_flag'] === "Yes") ? "<span class='song-tag primary'>New</span>" : "";

        echo '
        <div class="album-art-container">
          <div class="album-art-wrapper">
            <img src="../../admin/uploads/songscover/' . htmlspecialchars($rows['image']) . '" alt="' . $rows['title'] . '" class="album-art">
          </div>
        </div>

        <!-- Song Info -->
        <div class="song-info">
          <h1>
            ' . $rows['title'] . '
            <i class="bi ' . ($is_favorite ? 'bi-heart-fill' : 'bi-heart') . ' favorite-icon"
               id="favoriteIcon"
               data-id="' . $song_id . '"
               data-state="' . ($is_favorite ? 'favorite' : 'not-favorite') . '"
               style="cursor:pointer; font-size:24px; 
                      color: ' . ($is_favorite ? '#E1306C' : 'gray') . ';">
            </i>
          </h1>
          <h2>' . $rows['artist'] . '</h2>

          <div class="song-tags">
            ' . $new . '
            <span class="song-tag">' . $rows['genre'] . '</span>
            <span class="song-tag">' . $rows['year'] . '</span>
            <span class="song-tag">3.2M Likes</span>
          </div>
        </div>

        <!-- Player Controls -->
        <div class="player-controls">
          <div class="progress-container">
            <div class="progress-time times">
              <span id="currentTime">0:00</span>
              <span id="duration">0:00</span>
            </div>
            <div class="progress-bar progress-bar-container" onclick="setProgress(event)">
              <div class="progress" id="progressBar"></div>
            </div>
          </div>

          <!-- Waveform Visualization -->
          <div class="waveform" id="waveform"></div>

          <div class="control-buttons">
            <button class="control-btn" onclick="seekBackward()"><i class="bi bi-skip-backward-fill"></i></button>
            <button id="playPauseBtn" class="control-btn play-btn" onclick="togglePlay()"><i class="bi bi-play-fill"></i></button>
            <button class="control-btn" onclick="seekForward()"><i class="bi bi-skip-forward-fill"></i></button>
          </div>
        </div>
        ';
    }
}
?>

        
        <!-- Rating Section -->
<div class="rating-section glass">
  <form action="submit-rating.php" method="POST">
  <?php

    $sql_song = "SELECT * FROM songs WHERE id = $song_id";
$song_result = mysqli_query($con, $sql_song);
        if (mysqli_num_rows($song_result) > 0) {
          while ($rows = mysqli_fetch_assoc($song_result)) {
            echo '
          <input type="hidden" name="song_id" id="song-id" value="' . $song_id . '">
          <input type="hidden" name="item_name" id="itemName" value="' . $rows['title'] . '">
          <input type="hidden" name="item_type" id="itemType" value="song">

            ';
        }
      }
    ?>

    <input type="hidden" name="rating" id="ratingInput">
    <h3 class="rating-title">Enjoyed the track?</h3>
    <p class="rating-subtitle">Leave a rating & short review ✨</p>

    <div class="rating-stars" id="ratingStars">
      <i class="bi bi-star" data-rating="1"></i>
      <i class="bi bi-star" data-rating="2"></i>
      <i class="bi bi-star" data-rating="3"></i>
      <i class="bi bi-star" data-rating="4"></i>
      <i class="bi bi-star" data-rating="5"></i>
    </div>

    <textarea name="review" id="review" rows="4" placeholder="Write your thoughts..."></textarea>

    <button id="submitRating" class="submit-rating">Submit</button>
  </form>
  <div id="ratingMessage" class="rating-message"></div>
</div>

      </div>
    </div>
  </div>


  <?php
  include 'footer.php';
  ?>


  <?php
  include 'auth-modals.php';
  ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>

const audioPlayer = document.getElementById("audioPlayer");
const audio = document.getElementById("audioPlayer");

    const playPauseBtn = document.getElementById("playPauseBtn");
    const progressBar = document.getElementById("progressBar");
    const currentTimeSpan = document.getElementById("currentTime");
    const durationSpan = document.getElementById("duration");

    // Play / Pause toggle
    function togglePlay() {
      if (audio.paused) {
        audio.play();
        playPauseBtn.textContent = "⏸️";
      } else {
        audio.pause();
        playPauseBtn.textContent = "▶️";
      }



      playPauseBtn.innerHTML = audio.paused
    ? '<i class="bi bi-play-fill"></i>'
    : '<i class="bi bi-pause-fill"></i>';
    }

    // Seek forward 10 seconds
    function seekForward() {
      audio.currentTime += 10;
    }

    // Seek backward 10 seconds
    function seekBackward() {
      audio.currentTime -= 10;
    }

    // Update progress
    audio.addEventListener("timeupdate", () => {
      const percent = (audio.currentTime / audio.duration) * 100;
      progressBar.style.width = percent + "%";

      currentTimeSpan.textContent = formatTime(audio.currentTime);
    });

    // Display duration
    audio.addEventListener("loadedmetadata", () => {
      durationSpan.textContent = formatTime(audio.duration);
    });

    // Click to set progress
    function setProgress(e) {
      const width = e.currentTarget.clientWidth;
      const clickX = e.offsetX;
      const duration = audio.duration;

      audio.currentTime = (clickX / width) * duration;
    }

    // Format time (mm:ss)
    function formatTime(time) {
      const minutes = Math.floor(time / 60);
      const seconds = Math.floor(time % 60);
      return `${minutes}:${seconds < 10 ? '0' + seconds : seconds}`;
    }









    
    
    
    
    
    
    
    
   








     // Rating System
let currentRating = 0;
let ratingInput = document.getElementById("ratingInput");

// ⭐ Handle star click
document.querySelectorAll("#ratingStars i").forEach(star => {
  star.addEventListener("click", () => {
    currentRating = parseInt(star.getAttribute("data-rating"));
    updateStars(currentRating);
    ratingInput.value = currentRating;
  });
});

function updateStars(rating) {
  const stars = document.querySelectorAll("#ratingStars i");
  stars.forEach((s, i) => {
    s.classList.toggle("active", i < rating);
    s.classList.toggle("bi-star-fill", i < rating);
    s.classList.toggle("bi-star", i >= rating);
  });
}

// ✅ Handle submit
document.getElementById("submitRating").addEventListener("click", () => {
  const itemName = document.getElementById("itemName").value;
  const itemType = document.getElementById("itemType").value;
  const review = document.getElementById("review").value;

  if (currentRating === 0 || itemName === "" || itemType === "") {
    document.getElementById("ratingMessage").textContent = "Please fill all fields and select a rating.";
    return;
  }

  alert('Thank you! Your review has been submitted.');
});









document.getElementById('favoriteIcon').addEventListener('click', function() {
      const songId = this.getAttribute('data-id');
      const currentState = this.getAttribute('data-state');
      const isFavorite = currentState === 'favorite';
      const action = isFavorite ? 'remove' : 'add';
      
      // Only proceed if user is logged in
      <?php if(isset($_SESSION['user_id'])): ?>
        toggleFavorite(songId, action);
      <?php else: ?>
        showNotification('Please login to save favorites!');
      <?php endif; ?>
    });
    
    function toggleFavorite(songId, action) {
      const formData = new FormData();
      formData.append('song_id', songId);
      formData.append('action', action);
      
      fetch('toggle_favorite.php', {
        method: 'POST',
        body: formData
      })
      .then(response => response.json())
      .then(data => {
        if (data.status === 'success') {
          const icon = document.getElementById('favoriteIcon');
          const isNowFavorite = action === 'add';
          
          // Update icon appearance
          icon.classList.toggle('bi-heart');
          icon.classList.toggle('bi-heart-fill');
          icon.style.color = isNowFavorite ? '#E1306C' : 'gray';
          icon.setAttribute('data-state', isNowFavorite ? 'favorite' : 'not-favorite');
          
          // Show success message
          showNotification(data.message);
        } else {
          showNotification('Error: ' + data.message);
        }
      })
      .catch(error => {
        showNotification('Request failed: ' + error.message);
      });
    }
    
    function showNotification(message) {
      const notification = document.getElementById('notification');
      notification.textContent = message;
      notification.style.display = 'block';
      
      setTimeout(() => {
        notification.style.display = 'none';
      }, 3000);
    }








// Notification function
function showNotification(message) {
    const notification = document.createElement('div');
    notification.textContent = message;
    notification.style.position = 'fixed';
    notification.style.top = '20px';
    notification.style.right = '20px';
    notification.style.padding = '15px 25px';
    notification.style.background = 'var(--gradient)';
    notification.style.color = 'white';
    notification.style.borderRadius = '10px';
    notification.style.zIndex = '10000';
    notification.style.boxShadow = '0 5px 15px rgba(0,0,0,0.3)';
    notification.style.animation = 'fadeInOut 3s forwards';
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.remove();
    }, 3000);
}

// Add CSS for fade animation
const style = document.createElement('style');
style.textContent = `
@keyframes fadeInOut {
    0% { opacity: 0; transform: translateY(-20px); }
    10% { opacity: 1; transform: translateY(0); }
    90% { opacity: 1; transform: translateY(0); }
    100% { opacity: 0; transform: translateY(-20px); }
}
`;
document.head.appendChild(style);










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
        window.location.href = `song.php?song=${id}`;
          }
        break;
        case 'artist':
        if (id !== null) {
        window.location.href = `artist.php?artist=${id}`;
          }
        break;
        case 'video':
        if (id !== null) {
        window.location.href = `video.php?video=${id}`;
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