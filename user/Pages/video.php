<?php
session_start();

include '../connection.php';


$video_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$sql = "SELECT * FROM videos ";
$result = mysqli_query($con, $sql);

$sql_video = "SELECT * FROM videos WHERE id = $video_id";
$video_result = mysqli_query($con, $sql_video);
$video = mysqli_fetch_assoc($video_result);

$artist_name = $video['artist'];
$sql_artist = "SELECT image FROM artists WHERE name = '" . mysqli_real_escape_string($con, $artist_name) . "' LIMIT 1";
$artist_result = mysqli_query($con, $sql_artist);
$artist = mysqli_fetch_assoc($artist_result);
$artist_image = $artist['image'];

// Format date
$date = substr($video['date_added'], 0, 10);









function getYoutubeEmbedUrl($url) {
    if (strpos($url, 'youtu.be/') !== false) {
        $parts = explode('/', parse_url($url, PHP_URL_PATH));
        $videoId = end($parts);
    }
    elseif (strpos($url, 'youtube.com/watch') !== false) {
        parse_str(parse_url($url, PHP_URL_QUERY), $query);
        $videoId = $query['v'] ?? '';
    }
    elseif (strpos($url, 'youtube.com/embed/') !== false) {
        $parts = explode('/', parse_url($url, PHP_URL_PATH));
        $videoId = end($parts);
    }
    else {
        return '';
    }

    return 'https://www.youtube.com/embed/' . $videoId . '?autoplay=1&mute=1&enablejsapi=1';
}


$is_favorite = false;
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $check_fav = mysqli_query($con, "SELECT * FROM favorites WHERE user_id = '$user_id' AND video_id = '$video_id'");
    $is_favorite = mysqli_num_rows($check_fav) > 0;
}

?>





<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $video['title']; ?> | SOUND Group</title>
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
      overflow: hidden;
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
      width: 90px;
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
      background: rgba(255, 0, 0, 0.2);
      border-left: 3px solid var(--primary);
      box-shadow: 0 5px 15px rgba(255, 0, 0, 0.2);
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
      overflow-y: auto;
      overflow-x: hidden;
      height: calc(100vh - 70px);
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

    /* Video Player */
    .video-container {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
      position: relative;
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 30px 50px rgba(0, 0, 0, 0.6);
      height: 70vh
      max-height: none;
      flex-shrink: 0;
      min-height: 410px;
      width: 95%;
    }

    .video-player {
      width: 100%;
      height: 100%;
      border-radius: 15px;
      object-fit: cover;
      background: #000;
    }

    /* Video Info */
    .video-info {
      text-align: left;
      margin-top: 30px;
      padding: 0 20px;
    }

    .video-info h1 {
      font-size: 36px;
      font-weight: 800;
      margin-bottom: 8px;
      font-family: 'Montserrat', sans-serif;
      color: var(--lighter);
      text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    }

    .video-info {
  padding: 20px;
  color: var(--lighter);
  font-family: 'Poppins', sans-serif;
  background: rgba(20, 20, 36, 0.7);
  border-radius: 12px;
  margin-top: 20px;
  border: 1px solid rgba(255, 255, 255, 0.1);
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
}

.video-title {
  font-size: 24px;
  font-weight: 700;
  margin-bottom: 20px;
  font-family: 'Montserrat', sans-serif;
  color: var(--lighter);
  line-height: 1.3;
}

.video-details {
  margin: 25px 0;
  background: rgba(30, 30, 46, 0.5);
  padding: 20px;
  border-radius: 10px;
  backdrop-filter: blur(5px);
}

.detail-row {
  display: flex;
  margin-bottom: 12px;
  font-size: 16px;
  align-items: center;
  padding: 8px 0;
  border-bottom: 1px solid rgba(255, 255, 255, 0.05);
}

.detail-row:last-child {
  border-bottom: none;
  margin-bottom: 0;
}

.detail-label {
  font-weight: 600;
  min-width: 100px;
  color: var(--primary);
  font-family: 'Montserrat', sans-serif;
}

.detail-value {
  flex: 1;
  color: var(--mdlight);
}

.artist-info {
  display: flex;
  align-items: center;
  gap: 20px;
  margin-top: 30px;
  padding: 15px;
  background: rgba(30, 30, 46, 0.5);
  border-radius: 10px;
}

.artist-image {
  width: 80px;
  height: 80px;
  border-radius: 50%;
  object-fit: cover;
  border: 2px solid var(--primary);
  box-shadow: 0 5px 15px rgba(225, 48, 108, 0.3);
}

.artist-meta {
  flex: 1;
}

.artist-name {
  font-size: 20px;
  font-weight: 700;
  color: var(--lighter);
  margin-bottom: 5px;
  font-family: 'Montserrat', sans-serif;
}

.artist-subscribers {
  font-size: 14px;
  color: var(--light);
}

/* Responsive adjustments */
@media (max-width: 768px) {
  .video-title {
    font-size: 20px;
  }
  
  .detail-row {
    flex-direction: column;
    align-items: flex-start;
    gap: 5px;
  }
  
  .detail-label {
    min-width: auto;
    font-size: 14px;
  }
  
  .artist-info {
    flex-direction: column;
    text-align: center;
  }
  
  .artist-meta {
    text-align: center;
    margin-top: 10px;
  }
}

    /* Player Controls */
    

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
      .video-info h1 {
        font-size: 30px;
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
      
      .player-content {
        padding: 20px;
      }
      
      .video-container {
        max-height: 50vh;
      }
    }

    @media (max-width: 768px) {
      .video-info h1 {
        font-size: 26px;
      }
      
      .control-buttons {
        flex-direction: column;
        gap: 15px;
      }
      
      .left-controls, .right-controls {
        width: 100%;
        justify-content: space-between;
      }
    }

    @media (max-width: 576px) {
      .video-info h1 {
        font-size: 22px;
      }
      
      .video-stats {
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
      }
      
      .channel-info {
        flex-direction: column;
        align-items: flex-start;
      }
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
  </style>
</head>
<body>
  <?php
  include 'header.php';
  ?>

  <!-- Player Container -->
  <div class="player-container">
    <!-- Sidebar - Queue List -->
    <div class="sidebar">
      <div class="sidebar-header">
        <h3><i class="bi bi-collection-play"></i> Play Queue</h3>
        <span class="queue-count"><?php echo mysqli_num_rows($result) ?> Videos</span>
      </div>
      <div class="queue-list">
      <?php
      $sql_other_videos = "SELECT * FROM videos WHERE id != $video_id LIMIT 8";
  $other_videos = mysqli_query($con, $sql_other_videos);
      
            if (mysqli_num_rows($other_videos) > 0) {
                while ($other = mysqli_fetch_assoc($other_videos)) {
                    echo '
        <div class="queue-item active mb-3" onclick=location.href="video.php?id=' .  $other['id'] . '">
          <img src="../../admin/uploads/videoscover/' . htmlspecialchars($other['image']) . '" alt="' . $other['title'] . '">
          <div class="queue-info">
            <h5>' . $other['title'] . '</h5>
            <p>' . $other['artist'] . ' • Official Music Video</p>
          </div>
          <div class="queue-duration">3:32</div>
        </div>
        ';
                }
            } else {
      echo '<div class="text-center  py-3">No other songs in queue</div>';
  }
            ?>
      </div>
    </div>
    
    <!-- Main Player Content -->
    <div class="main-player">
      <!-- Floating Particles -->
      <div class="particles" id="particles"></div>
      
      <!-- Dynamic Background -->
      <div class="player-bg" style="background-image: url('https://i.ytimg.com/vi/dQw4w9WgXcQ/maxresdefault.jpg');"></div>
      <div class="player-overlay"></div>
      
      <div class="player-content">
        <?php

          $artist = $video['artist'];

          $raw_url = $video['link'];
$embed_url = getYoutubeEmbedUrl($raw_url);

        $sql_artist = "SELECT image FROM artists WHERE name = '" . mysqli_real_escape_string($con, $artist) . "' LIMIT 1";
        $artist_result = mysqli_query($con, $sql_artist);

        if (mysqli_num_rows($artist_result) > 0) {
            $artist = mysqli_fetch_assoc($artist_result);
            $artist_image = $artist['image'];
        }

            echo '
            
        <div class="video-container">
          <iframe 
            class="video-player" 
            src="' . $embed_url . '" 
            frameborder="0" 
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
            allowfullscreen
            id="youtube-player">
          </iframe>
        </div>
        
        <!-- Video Info -->
        <div class="video-info">
        <h1 class="video-title">'. $video['title'] .' - '. $video['artist'] .' (Official Music Video)
        <!-- Favorite icon -->
        <i id="favoriteIcon" class="bi bi-heart'. ($is_favorite ? '-fill' : '') .'" 
           style="color: '. ($is_favorite ? '#E1306C' : 'var(--light)') .'; 
                  cursor: pointer; 
                  margin-left: 15px; font-size: 30px;"
           data-id="'. $video_id .'"
           data-loggedin="'. (isset($_SESSION['user_id']) ? '1' : '0') .'"></i>
          </h1>
  
          <div class="video-stats">
            <span><i class="bi bi-eye"></i> 1.5B views</span>
            <span class="divider"></span>
            <span><i class="bi bi-calendar"></i> ' . $date . '</span>
            <span class="divider"></span>
            <span><i class="bi bi-hand-thumbs-up"></i> 18M</span>
            <span class="divider"></span>
            <span><i class="bi bi-hand-thumbs-down"></i> 1.2M</span>
          </div>
          
          <div class="video-description">
            ' . $video['description'] . '
          </div>
          
          <div class="video-details">
            <div class="detail-row">
              <span class="detail-label">Artist:</span>
              <span class="detail-value">' . $video['artist'] . '</span>
            </div>
            <div class="detail-row">
              <span class="detail-label">Album:</span>
              <span class="detail-value">' . $video['album'] . '</span>
            </div>
            <div class="detail-row">
              <span class="detail-label">Released:</span>
              <span class="detail-value">' . $video['year'] . '</span>
            </div>
            <div class="detail-row">
              <span class="detail-label">Genre:</span>
              <span class="detail-value">' . $video['genre'] . '</span>
            </div>
          </div>
          
          
          <div class="artist-info">
            <img src="../../admin/uploads/artists/' . $artist_image . '" alt="' . $video['artist'] . '" class="artist-image">
            <div class="artist-meta">
              <div class="artist-name">' . $video['artist'] . '</div>
            </div>
          </div>
          ';
            ?>
      </div>
        
        <!-- Rating Section -->
<div class="rating-section glass">
  <form action="submit-rating.php" method="POST">
  <?php

    $sql_video = "SELECT * FROM videos WHERE id = $video_id";
$video_result = mysqli_query($con, $sql_video);
        if (mysqli_num_rows($video_result) > 0) {
          while ($rows = mysqli_fetch_assoc($video_result)) {
            echo '
          <input type="hidden" name="video_id" id="video-id" value="' . $video_id . '">
          <input type="hidden" name="item_name" id="itemName" value="' . $rows['title'] . '">
          <input type="hidden" name="item_type" id="itemType" value="video">

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
    
    
    document.addEventListener('DOMContentLoaded', function() {
      // Create floating particles
      const particlesContainer = document.getElementById('particles');
      const particleCount = 30;
      
      for (let i = 0; i < particleCount; i++) {
        const particle = document.createElement('div');
        particle.classList.add('particle');
        
        // Random properties
        const size = Math.random() * 10 + 5;
        const posX = Math.random() * 100;
        const posY = Math.random() * 100;
        const animationDuration = Math.random() * 20 + 10;
        const animationDelay = Math.random() * 5;
        
        particle.style.width = `${size}px`;
        particle.style.height = `${size}px`;
        particle.style.left = `${posX}%`;
        particle.style.top = `${posY}%`;
        particle.style.animationDuration = `${animationDuration}s`;
        particle.style.animationDelay = `${animationDelay}s`;
        
        particlesContainer.appendChild(particle);
      }
      
      // Video player functionality
      const player = document.getElementById('youtube-player');
      const playBtn = document.getElementById('play-btn');
      let isPlaying = true;
      
      // Toggle play/pause
      playBtn.addEventListener('click', function() {
        if (isPlaying) {
          player.contentWindow.postMessage('{"event":"command","func":"pauseVideo","args":""}', '*');
          playBtn.innerHTML = '<i class="bi bi-play-fill"></i>';
        } else {
          player.contentWindow.postMessage('{"event":"command","func":"playVideo","args":""}', '*');
          playBtn.innerHTML = '<i class="bi bi-pause-fill"></i>';
        }
        isPlaying = !isPlaying;
      });
      
      // Queue item click
      const queueItems = document.querySelectorAll('.queue-item');
      queueItems.forEach(item => {
        item.addEventListener('click', function() {
          // Remove active class from all items
          queueItems.forEach(i => i.classList.remove('active'));
          
          // Add active class to clicked item
          this.classList.add('active');
          
          // Update player with new video data
          
          const videoId = this.querySelector('img').src.split('/')[4];
          const video = videoData[videoId];
          
          // Update video player
          player.src = `https://www.youtube.com/embed/${videoId}?autoplay=1&mute=0&enablejsapi=1`;
          
          // Update background
          document.querySelector('.player-bg').style.backgroundImage = `url('${video.thumbnail}')`;
          
          // Update video info
          document.querySelector('.video-info h1').textContent = video.title;
          document.querySelector('.video-stats span:nth-child(1)').textContent = video.views;
          document.querySelector('.video-stats span:nth-child(5)').innerHTML = `<i class="bi bi-hand-thumbs-up"></i> ${video.likes}`;
          document.querySelector('.video-stats span:nth-child(7)').innerHTML = `<i class="bi bi-hand-thumbs-down"></i> ${video.dislikes}`;
          
          // Update tags
          const tagsContainer = document.querySelector('.video-tags');
          tagsContainer.innerHTML = '';
          video.tags.forEach(tag => {
            const tagEl = document.createElement('span');
            tagEl.classList.add('video-tag');
            tagEl.textContent = tag;
            tagsContainer.appendChild(tagEl);
          });
          
          // Update comments
          const commentsContainer = document.querySelector('.comments-list');
          commentsContainer.innerHTML = '';
          video.comments.forEach(comment => {
            const commentEl = document.createElement('div');
            commentEl.classList.add('comment');
            commentEl.innerHTML = `
              <img src="https://randomuser.me/api/portraits/${Math.random() > 0.5 ? 'men' : 'women'}/${Math.floor(Math.random()*50)}.jpg" alt="User" class="comment-avatar">
              <div class="comment-content">
                <div class="comment-author">${comment.author}</div>
                <div class="comment-text">${comment.text}</div>
                <div class="comment-time">${comment.time}</div>
              </div>
            `;
            commentsContainer.appendChild(commentEl);
          });
          
          // Ensure player is playing
          isPlaying = true;
          playBtn.innerHTML = '<i class="bi bi-pause-fill"></i>';
        });
      });
      
      // Progress bar interaction
      const progressBar = document.querySelector('.progress-bar');
      const progress = document.querySelector('.progress');
      
      progressBar.addEventListener('click', function(e) {
        const percent = e.offsetX / this.offsetWidth;
        progress.style.width = `${percent * 100}%`;
        
        // Update time
        const totalTime = 212; // 3:32 in seconds
        const currentTime = Math.floor(totalTime * percent);
        const mins = Math.floor(currentTime / 60);
        const secs = currentTime % 60;
        document.querySelector('.progress-time span:first-child').textContent = 
          `${mins}:${secs < 10 ? '0' + secs : secs}`;
      });
      
      // Volume control
      const volumeSlider = document.querySelector('.volume-slider');
      const volumeIcons = document.querySelectorAll('.volume-control i');
      
      volumeSlider.addEventListener('input', function() {
        const volume = this.value;
        
        // Update volume icons
        if (volume == 0) {
          volumeIcons[0].className = 'bi bi-volume-mute';
          volumeIcons[1].className = 'bi bi-volume-mute';
        } else if (volume < 50) {
          volumeIcons[0].className = 'bi bi-volume-down';
          volumeIcons[1].className = 'bi bi-volume-down';
        } else {
          volumeIcons[0].className = 'bi bi-volume-down';
          volumeIcons[1].className = 'bi bi-volume-up';
        }
      });
    });







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

  fetch("submit-rating.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: `rating=${currentRating}&item_name=${encodeURIComponent(itemName)}&item_type=${itemType}&review=${encodeURIComponent(review)}`
  })
  .then(res => res.text())
  .then(msg => {
    document.getElementById("ratingMessage").textContent = msg;
    currentRating = 0;
    updateStars(0);
    document.getElementById("review").value = "";
  });
});



// Add this to your video.php (similar to song.php)
document.getElementById('favoriteIcon').addEventListener('click', function() {
    const videoId = this.getAttribute('data-id');
    const isLoggedIn = this.getAttribute('data-loggedin') === '1';
    
    if (!isLoggedIn) {
        const loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
        loginModal.show();
        return;
    }
    
    const isFilled = this.classList.contains('bi-heart-fill');
    const action = isFilled ? 'remove' : 'add';
    
    // Toggle immediately for better UX
    this.classList.toggle('bi-heart');
    this.classList.toggle('bi-heart-fill');
    this.style.color = isFilled ? 'var(--light)' : '#E1306C';
    
    const formData = new FormData();
    formData.append('video_id', videoId);
    formData.append('action', action);
    
    fetch('toggle_favorite.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'error') {
            // Revert UI changes if error occurs
            this.classList.toggle('bi-heart');
            this.classList.toggle('bi-heart-fill');
            this.style.color = isFilled ? '#E1306C' : 'var(--light)';
            showNotification('Error: ' + data.message);
        } else {
            showNotification(data.message);
        }
    })
    .catch(error => {
        // Revert UI changes if request fails
        this.classList.toggle('bi-heart');
        this.classList.toggle('bi-heart-fill');
        this.style.color = isFilled ? '#E1306C' : 'var(--light)';
        showNotification('Request failed: ' + error.message);
    });
});

// Notification function
function showNotification(message) {
    const notification = document.createElement('div');
    notification.textContent = message;
    notification.style.position = 'fixed';
    notification.style.top = '20px';
    notification.style.right = '20px';
    notification.style.padding = '15px 25px';
    notification.style.background = 'linear-gradient(135deg, #E1306C, #405DE6)';
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