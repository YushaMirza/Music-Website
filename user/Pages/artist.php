<?php
session_start();

include '../connection.php';

$artistId = isset($_GET['artist']) ? intval($_GET['artist']) : 0;


$sql_other_artists = "SELECT * FROM artists WHERE id != $artistId LIMIT 5";

$query = "SELECT * FROM artists WHERE id = $artistId";
$result = mysqli_query($con, $query);
$artist = mysqli_fetch_assoc($result);

?>




<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Artist Profile | SOUND Group</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="icon" type="image/png" href="../../admin/uploads/icon/favicon.png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <style>
    :root {
      --primary: #E1306C;
      --secondary: #405DE6;
      --dark: #121212;
      --darker: #000;
      --medium: #181818;
      --light: #b3b3b3;
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

    

    /* Artist Header */
    .artist-header {
      position: relative;
      padding: 100px 0 50px;
      background: linear-gradient(135deg, #0f0c29, #302b63, #24243e);
      overflow: hidden;
      margin-bottom: 40px;
    }
    
    .header-overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: radial-gradient(circle at top right, rgba(225, 48, 108, 0.2), transparent 70%),
                  radial-gradient(circle at bottom left, rgba(64, 93, 230, 0.2), transparent 70%);
    }
    
    .header-content {
      position: relative;
      z-index: 2;
    }
    
    .artist-avatar {
      width: 220px;
      height: 220px;
      border-radius: 50%;
      object-fit: cover;
      border: 4px solid rgba(255, 255, 255, 0.1);
      box-shadow: 0 15px 40px rgba(0, 0, 0, 0.5);
      background: linear-gradient(white, white) padding-box,
                  var(--gradient) border-box;
      margin-bottom: 20px;
    }
    
    .artist-name {
      font-size: 3.2rem;
      font-weight: 800;
      margin-bottom: 10px;
      background: var(--gradient);
      -webkit-background-clip: text;
      background-clip: text;
      -webkit-text-fill-color: transparent;
      display: inline-block;
    }
    
    .artist-genre {
      font-size: 1.3rem;
      color: var(--light);
      margin-bottom: 25px;
    }
    
    .artist-stats {
      display: flex;
      justify-content: center;
      gap: 30px;
      margin-bottom: 30px;
    }
    
    .artist-stat {
      text-align: center;
    }
    
    .stat-value {
      font-size: 1.8rem;
      font-weight: 700;
      color: var(--lighter);
    }
    
    .stat-label {
      font-size: 0.95rem;
      color: var(--light);
    }
    
    .artist-actions {
      display: flex;
      gap: 15px;
      justify-content: center;
      margin-bottom: 20px;
    }
    
    .action-btn {
      padding: 10px 25px;
      border-radius: 50px;
      font-weight: 600;
      transition: all 0.3s;
      display: flex;
      align-items: center;
      gap: 8px;
    }
    
    .play-btn {
      background: var(--gradient);
      color: white;
      border: none;
    }
    
    .follow-btn {
      background: rgba(255, 255, 255, 0.1);
      color: var(--lighter);
      border: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    .action-btn:hover {
      transform: translateY(-3px);
      box-shadow: 0 5px 20px rgba(225, 48, 108, 0.4);
    }
    
    /* Tabs */
    .tabs-container {
      background: rgba(30, 30, 46, 0.7);
      backdrop-filter: blur(10px);
      border-radius: 15px;
      padding: 20px;
      margin-bottom: 40px;
      border: 1px solid rgba(255, 255, 255, 0.1);
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
    }
    
    .nav-tabs {
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
      margin-bottom: 25px;
    }
    
    .nav-tabs .nav-link {
      color: var(--light);
      padding: 12px 25px;
      border: none;
      border-radius: 50px;
      font-weight: 500;
      margin: 0 5px;
    }
    
    .nav-tabs .nav-link.active {
      background: var(--gradient);
      color: white;
      border: none;
    }
    
    .nav-tabs .nav-link:hover:not(.active) {
      background: rgba(255, 255, 255, 0.1);
      color: var(--lighter);
    }
    
    /* Sections */
    .section-title {
      font-size: 1.8rem;
      font-weight: 700;
      margin-bottom: 25px;
      position: relative;
      padding-bottom: 10px;
    }
    
    .section-title::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      width: 50px;
      height: 4px;
      background: var(--primary);
      border-radius: 2px;
    }

    @media (max-width: 700px) {

      .player-left {
    min-width: 165px !important;
}

      .album-art{
    width: 50px !important;
    height: 50px !important;
}

.player-bottom-bar{
    padding: 0 8px !important;
    gap: 10px !important;
}
      
      .track-info {
    margin-top: 7px !important;
}

.track-title{
    font-size: 16px !important;
}

.artist-name{
    font-size: 1rem !important;
}



.track-item {
    padding: 15px 0px !important;
}

.track-number {
    width: 15px !important;
}

.track-cover {
    margin-right: 18px !important;
}

.track-type{
  display: none !important;
}
    }

    @media (max-width: 520px){
      button.btn-icon.repeatbtn {
    display: none !important;
}

.player-bottom-bar {
        padding: 0px 35px !important;
    gap: 50px !important;
}
    }

    @media (max-width: 480px){
      .player-bottom-bar {
    padding: 0 1rem !important;
    gap: .5rem !important;
}
    }

    @media (max-width: 425px){
      .player-bottom-bar {
    padding: 0 .5rem !important;
    gap: .4rem !important;
}
    }

    @media (max-width: 400px){

      .player-center {
    justify-content: center !important;
    gap: 10px !important;
}

      .btn-icon{
    width: 40px !important;
    height: 40px !important;
}
      
      .btn-icon.toggle-play{
    width: 50px !important;
    height: 50px !important;
}

.player-bottom-bar {
    gap: 8vw !important;
}
    }

    @media (max-width: 380px){
      .player-bottom-bar {
    gap: 4vw !important;
}
    }
    
    /* Popular Tracks */
    .track-list {
      background: rgba(30, 30, 46, 0.5);
      border-radius: 15px;
      overflow: hidden;
    }
    
    .track-item {
      display: flex;
      align-items: center;
      padding: 15px 20px;
      border-bottom: 1px solid rgba(255, 255, 255, 0.05);
      transition: all 0.3s;
    }
    
    .track-item:hover {
      background: rgba(255, 255, 255, 0.05);
    }
    
    .track-number {
      width: 40px;
      font-size: 1.1rem;
      color: var(--light);
      margin-right: 15px;
    }

    .track-cover {
      width: 50px;
      height: 50px;
      border-radius: 5px;
      overflow: hidden;
      margin-right: 10px;
    }

    .track-cover img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
    
    .track-info {
      flex: 1;
    }
    
    .track-title {
      font-weight: 600;
      margin-bottom: 5px;
    }
    
    .track-artist {
      font-size: 0.9rem;
      color: var(--light);
    }
    
    .track-duration {
      color: var(--light);
      margin: 0 20px;
    }
    
    .track-play {
      color: var(--light);
      font-size: 1.2rem;
      transition: all 0.3s;
    }
    
    .track-play:hover {
      color: var(--primary);
      transform: scale(1.2);
    }
    
    /* Albums */
    .album-card {
      background: rgba(30, 30, 46, 0.6);
      border-radius: 15px;
      overflow: hidden;
      transition: all 0.3s;
      border: 1px solid rgba(255, 255, 255, 0.08);
    }
    
    .album-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 15px 40px rgba(225, 48, 108, 0.3);
    }
    
    .album-cover {
      width: 100%;
      height: 200px;
      object-fit: cover;
    }
    
    .album-info {
      padding: 20px;
    }
    
    .album-title {
      font-weight: 600;
      margin-bottom: 5px;
    }
    
    .album-year {
      color: var(--light);
      font-size: 0.9rem;
    }
    
    /* Related Artists */
    .related-artist-card {
      text-align: center;
      background: rgba(30, 30, 46, 0.6);
      border-radius: 15px;
      padding: 20px;
      transition: all 0.3s;
      border: 1px solid rgba(255, 255, 255, 0.08);
    }
    
    .related-artist-card:hover {
      transform: translateY(-5px);
      background: rgba(40, 40, 60, 0.7);
    }
    
    .related-artist-avatar {
      width: 120px;
      height: 120px;
      border-radius: 50%;
      object-fit: cover;
      margin-bottom: 15px;
      border: 2px solid rgba(255, 255, 255, 0.1);
    }
    
    .related-artist-name {
      font-weight: 600;
      margin-bottom: 5px;
    }
    
    .related-artist-genre {
      color: var(--light);
      font-size: 0.9rem;
    }
    
    /* Biography */
    .biography {
      background: rgba(30, 30, 46, 0.6);
      border-radius: 15px;
      padding: 30px;
      line-height: 1.8;
    }
    
    
    
    /* Responsive */
    @media (max-width: 768px) {
      .artist-name {
        font-size: 2.5rem;
      }
      
      .artist-avatar {
        width: 180px;
        height: 180px;
      }
      
      .artist-stats {
        gap: 15px;
      }
      
      .stat-value {
        font-size: 1.5rem;
      }
    }
    
    @media (max-width: 576px) {
      .artist-name {
        font-size: 2rem;
      }
      
      .artist-avatar {
        width: 150px;
        height: 150px;
      }
      
      .artist-actions {
        flex-direction: column;
        align-items: center;
      }
      
      .action-btn {
        width: 80%;
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



 /* Updated Player Styles */
.player-bottom-bar {
  position: fixed;
  bottom: 0;
  left: 0;
  right: 0;
  height: 80px;
  background: rgba(20, 20, 20, 0.95);
  backdrop-filter: blur(10px);
  border-top: 1px solid rgba(255, 255, 255, 0.1);
  display: none;
  align-items: center;
  padding: 0 25px;
  z-index: 9999;
  transition: all 0.3s ease;
  font-family: sans-serif;
  gap: 20px;
}

.player-bottom-bar.active {
  display: flex;
}

.player-left,
.player-center,
.player-right {
  display: flex;
  align-items: center;
  gap: 20px;
}

.player-left {
  flex: 1;
  min-width: 250px;
}

.player-center {
  flex: 2;
  justify-content: center;
}

.player-right {
  flex: 1;
  justify-content: flex-end;
}

.playing-icon {
  margin-right: 6px;
  color: #1db954;
  font-weight: bold;
}

.album-art {
  width: 60px;
  height: 60px;
  border-radius: 8px;
  object-fit: cover;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
}

.track-info {
  overflow: hidden;
  display: flex;
  flex-direction: column;
  color: white;
}

.track-title {
  font-size: 16px;
  font-weight: 600;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.artist-name {
  font-size: 1.5rem;
  font-weight: 600;
  color: #aaa;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.btn-icon {
  background: rgba(255, 255, 255, 0.1);
  border: none;
  cursor: pointer;
  color: white;
  display: flex;
  align-items: center;
  justify-content: center;
  width: 50px;
  height: 50px;
  border-radius: 50%;
  font-size: 22px;
  transition: all 0.2s ease;
}

.btn-icon:hover {
  background: rgba(255, 255, 255, 0.2);
  transform: scale(1.05);
}

.btn-icon.toggle-play {
  width: 60px;
  height: 60px;
  background: var(--primary);
}

.btn-icon.toggle-play:hover {
  background: #ff1a52;
  transform: scale(1.08);
}

.volume-slider {
  width: 100px;
  accent-color: var(--primary);
}




  </style>
</head>
<body>
  <script>
  var tag = document.createElement('script');
  tag.src = "https://www.youtube.com/iframe_api";
  var firstScriptTag = document.getElementsByTagName('script')[0];
  firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
</script>
  
  
  
  <!-- Navbar -->
  <?php
  include 'header.php'
  ?>


   <?php
   $name = $artist['name'];
   
   $song_query = mysqli_query($con, "SELECT title FROM songs WHERE artist = '$name'");
$video_query = mysqli_query($con, "SELECT title FROM videos WHERE artist = '$name'");
$album_query = mysqli_query($con, "SELECT title FROM albums WHERE artist = '$name'");

// Count songs and videos
$songCount = mysqli_num_rows($song_query);
$videoCount = mysqli_num_rows($video_query);
$albumCount = mysqli_num_rows($album_query);

// Total tracks = songs + videos
$trackCount = $songCount + $videoCount;

   echo '

  <section class="artist-header">
    <div class="header-overlay"></div>
    <div class="container header-content text-center">
      <img src="../../admin/uploads/artists/' . $artist['image'] . '" alt="' . $artist['name'] . '" class="artist-avatar"><br>
      <h1 class="artist-name">' . $artist['name'] . '</h1>
      <p class="artist-genre">' . $artist['genres'] . '</p>
      
      <div class="artist-stats">
        <div class="artist-stat">
          <div class="stat-value">55.7M</div>
          <div class="stat-label">Followers</div>
        </div>
        <div class="artist-stat">
          <div class="stat-value">' . $trackCount . '</div>
          <div class="stat-label">Tracks</div>
        </div>
        <div class="artist-stat">
          <div class="stat-value">' . $albumCount . '</div>
          <div class="stat-label">Albums</div>
        </div>
        <div class="artist-stat">
          <div class="stat-value">2.3B</div>
          <div class="stat-label">Streams</div>
        </div>
      </div>
      
      <div class="artist-actions">
        <button class="action-btn play-btn">
          <i class="bi bi-play-fill"></i> Play Artist
        </button>
      </div>
      
    </div>
  </section>
  ';
  ?>

  <!-- Main Content -->
  <div class="container">
    <!-- Tabs -->
    <div class="tabs-container">
      <ul class="nav nav-tabs" id="artistTabs" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link active" id="tracks-tab" data-bs-toggle="tab" data-bs-target="#tracks" type="button" role="tab">Popular Tracks</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="albums-tab" data-bs-toggle="tab" data-bs-target="#albums" type="button" role="tab">Albums</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="related-tab" data-bs-toggle="tab" data-bs-target="#related" type="button" role="tab">Related Artists</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="bio-tab" data-bs-toggle="tab" data-bs-target="#bio" type="button" role="tab">Biography</button>
        </li>
      </ul>
      
      <div class="tab-content" id="artistTabsContent">
        <!-- Popular Tracks -->
        <div class="tab-pane fade show active" id="tracks" role="tabpanel">
          <h3 class="section-title">Top Tracks</h3>
          <div class="track-list">
            
            <?php
            $trackNumber = 1;

            $artistName = mysqli_real_escape_string($con, $artist['name']);

// Fetch songs where artist name matches
$song_query = mysqli_query($con, "SELECT * FROM songs WHERE artist = '$artistName'");
if ($song_query && mysqli_num_rows($song_query) > 0) {
    $trackNumber = 1;
    while ($song = mysqli_fetch_assoc($song_query)) {
        echo '
        <div class="track-item song-track" data-title="' . htmlspecialchars($song['title']) . '" data-artist="' . htmlspecialchars($song['artist']) . '"  data-src="../../admin/uploads/songs/' . $song['file'] . '" data-image="../../admin/uploads/songscover/' . htmlspecialchars($song['image']) . '" onclick="handleTrackClick(this)">
          <div class="track-number">' . $trackNumber++ . '</div>
          <div class="track-cover">
                      <img src="../../admin/uploads/songscover/' . htmlspecialchars($song['image']) . '" alt="Song Cover">
          </div>
          <div class="track-info">
            <div class="track-title">' . htmlspecialchars($song['title']) . '</div>
            <div class="track-artist">' . htmlspecialchars($song['artist']) . '</div>
          </div>
          <span class="track-type" >song</span>
          <div class="track-duration">3:22</div>
          <a href="#" class="track-play">
            <i class="bi bi-play-circle"></i>
          </a>
        </div>
        ';

        
    }
  } 
  $video_query = mysqli_query($con, "SELECT * FROM videos WHERE artist = '$artistName'");
if ($video_query && mysqli_num_rows($video_query) > 0) {
    while ($video = mysqli_fetch_assoc($video_query)) {
        echo '
        <div class="track-item video-track" data-title="' . htmlspecialchars($video['title']) . '" data-artist="' . htmlspecialchars($video['artist']) . '" data-image="../../admin/uploads/videoscover/' . htmlspecialchars($video['image']) . '" data-type="video" data-link="' . htmlspecialchars($video['link']) . '" onclick="handleTrackClick(this)">
          <div class="track-number">' . $trackNumber++ . '</div>
          <div class="track-cover">
                      <img src="../../admin/uploads/videoscover/' . htmlspecialchars($video['image']) . '" alt="Video Cover">
          </div>
          <div class="track-info">
            <div class="track-title">' . htmlspecialchars($video['title']) . '</div>
            <div class="track-artist">' . htmlspecialchars($video['artist']) . '</div>
          </div>
          <span class="track-type" >video</span>
          <div class="track-duration">3:22</div>
          <a href="#" class="track-play">
            <i class="bi bi-play-circle"></i>
          </a>
        </div>
        ';
    }
}
            ?>
          </div>
        </div>
        
        <!-- Albums -->
        <div class="tab-pane fade" id="albums" role="tabpanel">
          <div class="row g-4">
          <h3 class="section-title">Discography</h3>
          <?php
          $album_query = mysqli_query($con, "SELECT * FROM albums WHERE artist = '$artistName'");
if ($album_query && mysqli_num_rows($album_query) > 0) {
    while ($album = mysqli_fetch_assoc($album_query)) {
      $songsArray = array_filter(array_map('trim', explode(',', $album['songs'])));
    $songCount = count($songsArray);
    $videosArray = array_filter(array_map('trim', explode(',', $album['videos'])));
    $videoCount = count($videosArray);
    $trackCount = $songCount + $videoCount;
        echo '
            <div class="col-lg-3 col-md-4 col-sm-6"  onclick=location.href="album.php?album=' . $album['id'] . '">
              <div class="album-card">
                <img src="../../admin/uploads/albumscover/' . $album['cover_image'] . '" alt="' . $album['title'] . '" class="album-cover">
                <div class="album-info">
                  <h5 class="album-title">' . $album['title'] . '</h5>
                  <div class="album-year">' . $album['release_year'] . ' • ' . $trackCount . ' songs</div>
                </div>
              </div>
            </div>
            ';
          }
      }
      ?>
          </div>
        </div>
        
        <!-- Related Artists -->
        <div class="tab-pane fade" id="related" role="tabpanel">
          <h3 class="section-title">Fans Also Like</h3>
          <div class="row g-4">
            <?php
  $other_artists = mysqli_query($con, $sql_other_artists);
      
            if (mysqli_num_rows($other_artists) > 0) {
                while ($other = mysqli_fetch_assoc($other_artists)) {
                    echo '
            <div class="col-lg-3 col-md-4 col-sm-6"> 
              <a href="artist.php?artist=' . $other['id'] . '" class="text-decoration-none text-white">
                <div class="related-artist-card">
                  <img src="../../admin/uploads/artists/' . htmlspecialchars($other['image']) . '" alt="' .  $other['name'] . '" class="related-artist-avatar">
                  <h5 class="related-artist-name">' .  $other['name'] . '</h5>
                  <div class="related-artist-genre">' .  $other['genres'] . '</div>
                </div>
              </a>
            </div>
            ';
                }
            } else {
      echo '<div class="text-center  py-3">No other artists in queue</div>';
  }
            ?>
            
          </div>
        </div>
        
        <!-- Biography -->
        <div class="tab-pane fade" id="bio" role="tabpanel">
          <h3 class="section-title">Artist Story</h3>
          <?php
          echo '
          <div class="biography">
            <p>' . $artist['biography'] . '</p>
          </div>
          ';
          ?>
        </div>
      </div>
    </div>

             <!-- Rating Section -->
<div class="rating-section glass">
  <form action="submit-rating.php" method="POST">
  <?php

    $sql_artist = "SELECT * FROM artists WHERE id = $artistId";
$artist_result = mysqli_query($con, $sql_artist);
        if (mysqli_num_rows($artist_result) > 0) {
          while ($rows = mysqli_fetch_assoc($artist_result)) {
            echo '
          <input type="hidden" name="artist_id" id="artist-id" value="' . $artistId . '">
          <input type="hidden" name="item_name" id="itemName" value="' . $rows['name'] . '">
          <input type="hidden" name="item_type" id="itemType" value="artist">

            ';
        }
      }
    ?>

    <input type="hidden" name="rating" id="ratingInput">
    <h3 class="rating-title">Enjoyed the tracks?</h3>
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



  <div style="display: none;">
  <div id="youtube-player"></div>
</div>
  

  <div class="player-bottom-bar" aria-label="Now playing">
  <div class="player-left">
    <img class="album-art" src="https://images.unsplash.com/photo-1507874457470-272b3c8d8ee2?auto=format&fit=crop&w=56&q=80" alt="Album cover" />
    <div class="track-info" aria-live="polite">
      <div class="track-title">Carti</div>
      <div class="artist-name">Shubh</div>
    </div>
  </div>

  <div class="player-center">
    <button class="btn-icon prev-btn" title="Previous" aria-label="Previous">
      <i class="fas fa-step-backward"></i>
    </button>
    
    <button class="btn-icon toggle-play" title="Play/Pause" aria-label="Play">
      <i class="fas fa-play play-icon" style="display: none;"></i>
      <i class="fas fa-pause pause-icon"></i>
    </button>
    
    <button class="btn-icon next-btn" title="Next" aria-label="Next">
      <i class="fas fa-step-forward"></i>
    </button>
  </div>

  <div class="player-right">
  <div class="loop-control" aria-label="Loop control">
    <button class="btn-icon repeatbtn" title="Repeat Track" aria-label="Repeat" onclick="toggleLoop(this)">
      <i class="fas fa-redo"></i>
    </button>
  </div>
</div>
</div>


<audio id="audio-player" src="" preload="auto"></audio>
  
  
  

  <!-- Footer -->
  <?php
  include 'footer.php'
  ?>

  <?php
  include 'auth-modals.php'
  ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    
      let trackElements = [];
let currentTrackIndex = -1;
let ytPlayer = null;
let currentVideoID = null;
let currentAudioSrc = null;
let isCurrentTrackVideo = false;
let isPlaying = false;


document.addEventListener("DOMContentLoaded", function () {
  trackElements = Array.from(document.querySelectorAll("div.song-track, div.video-track"));


  document.querySelector('.play-btn')?.addEventListener('click', () => {
  if (trackElements.length > 0) {
    currentTrackIndex = 0;
    trackElements[0].click(); // This will trigger the first track to play
  }
});
  

  trackElements.forEach((el, index) => {
    el.addEventListener("click", function () {
      currentTrackIndex = index;
      handleTrackClick(this);
    });
  });

  document.querySelector(".prev-btn")?.addEventListener("click", () => {
    if (currentTrackIndex > 0) {
      currentTrackIndex--;
      trackElements[currentTrackIndex].click();
    }
  });

  // Next Track Button
  document.querySelector(".next-btn")?.addEventListener("click", () => {
    if (currentTrackIndex < trackElements.length - 1) {
      currentTrackIndex++;
      trackElements[currentTrackIndex].click();
    }
  });

  // Toggle Play Button (bottom bar)
  const playBtn = document.querySelector(".toggle-play");
  const playIcon = playBtn?.querySelector(".play-icon");
  const pauseIcon = playBtn?.querySelector(".pause-icon");
  const audio = document.getElementById('audio-player');

  playBtn?.addEventListener("click", () => {
    if (isCurrentTrackVideo) {
      const state = ytPlayer?.getPlayerState();
      if (state === YT.PlayerState.PLAYING) {
        ytPlayer.pauseVideo();
        showPlayIcon();
      } else {
        ytPlayer.playVideo();
        showPauseIcon();
      }
    } else if (audio?.src) {
      if (audio.paused) {
        audio.play();
        showPauseIcon();
      } else {
        audio.pause();
        showPlayIcon();
      }
    }
  });

  // Add floating elements to header
  const header = document.querySelector('.playlist-header');
  for (let i = 0; i < 3; i++) {
    const element = document.createElement('div');
    element.classList.add('floating-element');

    const size = Math.random() * 80 + 40;
    const posX = Math.random() * 100;
    const posY = Math.random() * 100;
    const animationDuration = Math.random() * 20 + 10;
    const animationDelay = Math.random() * 5;

    element.style.width = `${size}px`;
    element.style.height = `${size}px`;
    element.style.left = `${posX}%`;
    element.style.top = `${posY}%`;
    element.style.animationDuration = `${animationDuration}s`;
    element.style.animationDelay = `${animationDelay}s`;

    const colors = ['var(--primary)', 'var(--secondary)', 'rgba(255, 255, 255, 0.2)'];
    element.style.background = colors[Math.floor(Math.random() * colors.length)];

    header.appendChild(element);
  }

  // Row Hover Effect
  document.querySelectorAll('.tracks-table tr').forEach(row => {
    row.addEventListener('mouseenter', () => row.style.backgroundColor = 'rgba(255, 255, 255, 0.05)');
    row.addEventListener('mouseleave', () => row.style.backgroundColor = '');
  });

  // Top player play icon
  const topPlayBtn = document.querySelector('.btn-icon.play');
  topPlayBtn?.addEventListener("click", () => {
    if (isCurrentTrackVideo) {
      const state = ytPlayer?.getPlayerState();
      if (state === YT.PlayerState.PLAYING) {
        ytPlayer.pauseVideo();
        showPlayIcon();
      } else {
        ytPlayer.playVideo();
        showPauseIcon();
      }
    } else {
      if (!audio?.src) return;
      if (audio.paused) {
        audio.play();
        showPauseIcon();
      } else {
        audio.pause();
        showPlayIcon();
      }
    }
  });
});



function extractYouTubeID(url) {
  const regExp = /(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|embed\/|v\/|shorts\/))([\w-]{11})/;
  const match = url.match(regExp);
  return match ? match[1] : null;
}

// Handle track clicks
function handleTrackClick(element) {
  // Remove all old playing icons
  trackElements.forEach(row => {
    const oldIcon = row.querySelector('.playing-icon');
    if (oldIcon) oldIcon.remove();
  });

  // Add new playing icon to clicked track
  const icon = document.createElement('span');
  icon.className = 'playing-icon';
  icon.textContent = '🔊';
  const trackNameEl = element.querySelector('.track-title');
  if (trackNameEl) trackNameEl.prepend(icon);

  const title = element.getAttribute('data-title');
  const artist = element.getAttribute('data-artist');
  const image = element.getAttribute('data-image');
  const isVideo = element.getAttribute('data-type') === 'video';
  const link = element.getAttribute('data-link');

  const playerBar = document.querySelector('.player-bottom-bar');
  const playerTitle = playerBar.querySelector('.track-title');
  const playerArtist = playerBar.querySelector('.artist-name');
  const playerImage = playerBar.querySelector('.album-art');

  playerTitle.textContent = title;
  playerArtist.textContent = artist;
  playerImage.src = image;
  playerBar.classList.add('active');

  const audio = document.getElementById('audio-player');

  if (isVideo && link) {
    isCurrentTrackVideo = true;
    currentVideoID = extractYouTubeID(link);
    if (ytPlayer && ytPlayer.loadVideoById) {
      ytPlayer.loadVideoById(currentVideoID);
      ytPlayer.playVideo();
    }
    audio.pause();
  } else {
    isCurrentTrackVideo = false;
    currentAudioSrc = element.getAttribute('data-src');
    audio.src = currentAudioSrc;
    audio.play();
    showPauseIcon();
    if (ytPlayer && ytPlayer.pauseVideo) ytPlayer.pauseVideo();
  }
}


window.onYouTubeIframeAPIReady = function() {
  ytPlayer = new YT.Player('youtube-player', {
    height: '0',
    width: '0',
    videoId: '',
    playerVars: {
      autoplay: 1,
      controls: 0,
      disablekb: 1,
      fs: 0,
      modestbranding: 1,
      rel: 0
    },
    events: {
      'onReady': onPlayerReady,
      'onStateChange': onPlayerStateChange
    }
  });
}

function onPlayerReady(event) {
  console.log("YouTube player ready");
}

function onPlayerStateChange(event) {
  // Handle player state changes if needed
  if (event.data === YT.PlayerState.PLAYING) {
    showPauseIcon();
  } else if (event.data === YT.PlayerState.PAUSED || event.data === YT.PlayerState.ENDED) {
    showPlayIcon();
  }
}

function showPlayIcon() {
  const playBtn = document.querySelector(".toggle-play");
  if (playBtn) {
    playBtn.querySelector(".pause-icon").style.display = "none";
    playBtn.querySelector(".play-icon").style.display = "inline";
  }
  isPlaying = false;
}

function showPauseIcon() {
  const playBtn = document.querySelector(".toggle-play");
  if (playBtn) {
    playBtn.querySelector(".play-icon").style.display = "none";
    playBtn.querySelector(".pause-icon").style.display = "inline";
  }
  isPlaying = true;
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
  <script src="https://www.youtube.com/iframe_api"></script>
  <audio id="audio-player" controls style="display: none;"></audio>
</body>
</html>