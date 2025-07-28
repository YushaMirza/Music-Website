<?php
session_start();

include '../connection.php';

$albumId = isset($_GET['album']) ? intval($_GET['album']) : 0;

$sql_albums_header = "SELECT * FROM albums WHERE id = $albumId";
$header_results = mysqli_query($con, $sql_albums_header);

$sql_albums = "SELECT * FROM albums";
$results = mysqli_query($con, $sql_albums);
?>




<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Album Details | SOUND Group</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="icon" type="image/png" href="../../admin/uploads/icon/favicon.png">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>

    :root {
      --primary: #ff2e63;
      --secondary: #08d9d6;
      --dark: #121212;
      --darker: #000;
      --medium: #181818;
      --light: #b3b3b3;
      --lighter: #ffffff;
      --gradient: linear-gradient(135deg, var(--primary), var(--secondary));
      --card-bg: rgba(30, 30, 46, 0.6);
      --hover-bg: rgba(255, 255, 255, 0.1);
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #0f0c29, #1a1a2e, #16213e);
      color: var(--lighter);
      min-height: 100vh;
      overflow-x: hidden;
    }

    section {
      padding-left: 20px !important;
      padding-right: 20px !important;
}


    .user-menu {
      display: flex;
      align-items: center;
      gap: 15px;
      position: absolute;
      right: 20px;
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
    
    
    
    
    
    
    .play-btn,.save-btn{
      color: white;
    }

    .play-btn, .save-btn {
      transition: opacity 0.3s ease;
    }

    .play-btn:hover, .save-btn:hover {
      opacity: 0.5;
    }

    

    .navbar .container {
  max-width: 100% !important;
  margin: 0 !important;
  padding: 0 20px;
}

.user-menu {
  z-index: 1001 !important; /* Higher than navbar's 1000 */
}

.dropdown-menu {
  z-index: 1002 !important;
}

    /* Header */
    .playlist-header {
      padding: 100px 0 40px;
      background: linear-gradient(to bottom, rgba(64, 93, 230, 0.2), rgba(10, 10, 20, 0.8));
      position: relative;
      overflow: hidden;
    }

    .header-content {
      display: flex;
      align-items: flex-end;
      gap: 30px;
      position: relative;
      z-index: 2;
    }

    .playlist-cover {
      width: 250px;
      height: 250px;
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.5);
      border-radius: 10px;
      overflow: hidden;
      flex-shrink: 0;
    }

    .playlist-cover img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .playlist-info {
      flex: 1;
      padding-bottom: 20px;
    }

    .playlist-type {
      text-transform: uppercase;
      font-size: 14px;
      letter-spacing: 1.5px;
      margin-bottom: 10px;
      color: var(--light);
    }

    .playlist-title {
      font-family: 'Montserrat', sans-serif;
      font-size: 4.5rem;
      font-weight: 800;
      margin-bottom: 15px;
      line-height: 1;
      text-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
    }

    .playlist-description {
      font-size: 16px;
      color: rgba(255, 255, 255, 0.8);
      max-width: 600px;
      margin-bottom: 25px;
      line-height: 1.6;
    }

    .playlist-stats {
      display: flex;
      align-items: center;
      gap: 25px;
      margin-bottom: 30px;
    }

    .stat {
      display: flex;
      align-items: center;
      gap: 8px;
      font-size: 14px;
      color: var(--light);
    }

    .stat i {
      color: var(--primary);
    }

    .playlist-actions {
      display: flex;
      gap: 20px;
      margin-top: 30px;
    }

    

    .floating-element {
      position: absolute;
      border-radius: 50%;
      opacity: 0.7;
      z-index: 1;
    }

    .floating-element:nth-child(1) {
      width: 120px;
      height: 120px;
      background: var(--primary);
      top: 10%;
      left: 10%;
    }

    .floating-element:nth-child(2) {
      width: 80px;
      height: 80px;
      background: var(--secondary);
      bottom: 20%;
      right: 15%;
    }


    /* Tracks Section */
    .tracks-section {
      padding: 40px 0;
    }

    .section-title {
      font-family: 'Montserrat', sans-serif;
      font-size: 1.8rem;
      font-weight: 700;
      margin-bottom: 25px;
      position: relative;
      display: inline-block;
    }

    .section-title::after {
      content: '';
      position: absolute;
      bottom: -8px;
      left: 0;
      width: 50px;
      height: 4px;
      background: var(--primary);
      border-radius: 2px;
    }

    .tracks-table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 50px;
    }

    .tracks-table th {
      text-align: left;
      padding: 15px 10px;
      font-weight: 500;
      color: var(--light);
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .tracks-table td {
      padding: 15px 10px;
      border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }

    .tracks-table tr:hover {
      background: var(--hover-bg);
      border-radius: 5px;
    }

    .track-number {
      width: 50px;
      text-align: center;
      color: var(--light);
    }

    .track-title {
      display: flex;
      align-items: center;
      gap: 15px;
    }

    .track-cover {
      width: 50px;
      height: 50px;
      border-radius: 5px;
      overflow: hidden;
    }

    .track-cover img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .track-info {
      display: flex;
      flex-direction: column;
    }

    .track-name {
      font-weight: 500;
      margin-bottom: 5px;
      cursor: pointer;
      color: inherit; 
      text-decoration: none;
      display: inline-block;
    }

    .track-name:hover{
      text-decoration: underline;
    }

    .track-artist {
      font-size: 14px;
      color: var(--light);
    }

    .track-album, .track-duration {
      color: var(--light);
    }

    /* Cards Section */
    .cards-section {
      padding: 30px 0 60px;
    }

    .cards-container {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
      gap: 25px;
      margin-top: 20px;
    }

    .card {
      background: var(--card-bg);
      border-radius: 10px;
      overflow: hidden;
      transition: all 0.3s ease;
      position: relative;
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
      border: 1px solid rgba(255, 255, 255, 0.05);
    }

    .card:hover {
      transform: translateY(-10px);
      background: rgba(40, 40, 60, 0.7);
      box-shadow: 0 15px 30px rgba(255, 46, 99, 0.3);
    }

    .card-cover {
      width: 100%;
      height: 200px;
      position: relative;
      overflow: hidden;
    }

    .card-cover img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.5s ease;
    }

    .card:hover .card-cover img {
      transform: scale(1.1);
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

    .card:hover .play-overlay {
      opacity: 1;
    }

    .play-icon {
      width: 50px;
      height: 50px;
      background: var(--primary);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 20px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
      align-content: center;
    }

    .card-content {
      padding: 20px;
    }

    .card-title {
      font-family: 'Montserrat', sans-serif;
      font-weight: 700;
      font-size: 18px;
      margin-bottom: 8px;
      display: -webkit-box;
      -webkit-line-clamp: 1;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }

    .card-description {
      font-size: 14px;
      color: var(--light);
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
      min-height: 40px;
    }

    .card-stats {
      display: flex;
      justify-content: space-between;
      margin-top: 15px;
      color: var(--light);
      font-size: 13px;
    }

    
    /* Responsive */
    @media (max-width: 992px) {
      .header-content {
        flex-direction: column;
        align-items: flex-start;
      }
      
      .playlist-cover {
        width: 200px;
        height: 200px;
      }
      
      .playlist-title {
        font-size: 3.5rem;
      }
    }

    @media (max-width: 768px) {
      .playlist-title {
        font-size: 2.8rem;
      }
      
      .tracks-table .track-album {
        display: none;
      }
      
      .cards-container {
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
      }
    }

    @media (max-width: 576px) {
      .playlist-title {
        font-size: 2.2rem;
      }
      
      .playlist-stats {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
      }
      
      .playlist-actions {
        flex-direction: column;
        gap: 10px;
      }
      
      .btn {
        width: 100%;
      }

      .btn-icon .active {
  color: #1db954;
}
      
      .footer-content {
        flex-direction: column;
        text-align: center;
      }
      
      .footer-links {
        justify-content: center;
      }
    }




/* Player Bar */
.player-bar {
  position: fixed;
  bottom: 0;
  left: 0;
  width: 100%;
  background: rgba(10, 10, 20, 0.95);
  backdrop-filter: blur(10px);
  padding: 15px 20px;
  border-top: 1px solid rgba(255, 255, 255, 0.1);
  display: flex;
  align-items: center;
  z-index: 1000;
  box-shadow: 0 -5px 25px rgba(0, 0, 0, 0.3);
  gap: 30px;
}

.now-playing {
  display: flex;
  align-items: center;
  flex: 1;
  min-width: 250px;
}

.now-playing-img {
  width: 60px;
  height: 60px;
  border-radius: 8px;
  object-fit: cover;
  margin-right: 15px;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
}

.now-playing-info {
  flex: 1;
  overflow: hidden;
}

.now-playing-title {
  font-size: 16px;
  font-weight: 600;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  margin-bottom: 5px;
}

.now-playing-artist {
  font-size: 14px;
  font-weight: 400;
  color: var(--light);
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.player-controls {
  display: flex;
  align-items: center;
  gap: 25px;
  flex: 1;
  justify-content: center;
}

.control-btn {
  background: rgba(255, 255, 255, 0.1);
  border: none;
  color: var(--lighter);
  font-size: 20px;
  cursor: pointer;
  transition: all 0.3s;
  width: 50px;
  height: 50px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
}

.control-btn:hover {
  background: rgba(255, 255, 255, 0.2);
  color: var(--primary);
  transform: scale(1.05);
}

.control-btn.active {
  color: var(--primary);
}

#playPauseBtn {
  width: 60px;
  height: 60px;
  background: var(--primary);
}

#playPauseBtn:hover {
  background: #ff1a52;
  transform: scale(1.08);
}

.progress-container {
  flex: 2;
  max-width: 500px;
}

.progress-bar {
  height: 4px;
  background: rgba(255, 255, 255, 0.1);
  border-radius: 2px;
  cursor: pointer;
  position: relative;
  margin-bottom: 5px;
}

.progress {
  height: 100%;
  background: var(--gradient);
  border-radius: 2px;
  width: 0%;
  position: relative;
  transition: width 0.2s linear;
}

.progress-time {
  display: flex;
  justify-content: space-between;
  font-size: 12px;
  color: var(--light);
}

.volume-control {
  display: flex;
  align-items: center;
  gap: 15px;
  flex: 1;
  max-width: 200px;
}

.volume-slider {
  width: 100px;
  accent-color: var(--primary);
}

@media (max-width: 992px) {
  .progress-container {
    display: none;
  }
  
  .volume-control {
    max-width: 150px;
  }
}

@media (max-width: 768px) {
.volume-control {
        display: none !important;
    }
}

@media (max-width: 768px) {
  .player-bar {
    gap: 15px;
    padding: 10px 15px;
  }
  
  .now-playing {
    min-width: 180px;
  }
  
  .now-playing-img {
    width: 50px;
    height: 50px;
  }
  
  .player-controls {
    gap: 15px;
  }
  
  .control-btn {
    width: 40px;
    height: 40px;
    font-size: 18px;
  }
  
  #playPauseBtn {
    width: 50px;
    height: 50px;
  }
  
  .volume-control {
    max-width: 120px;
  }
  
  .volume-slider {
    width: 80px;
  }
}

@media (max-width: 576px) {
  .player-bar {
    flex-wrap: wrap;
    height: auto;
    padding: 15px;
  }
  
  .now-playing {
    width: 100%;
    margin-bottom: 15px;
  }
  
  .player-controls {
    order: 3;
    width: 100%;
    justify-content: center;
    margin-top: 10px;
  }
  
  .volume-control {
    justify-content: flex-end;
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


  .player-bar {
    display: none;
  }
  
  /* Show player bar when active */
  .player-bar.active {
    display: flex;
  }
  
  /* Style for active play button */
  .btn.play-btn.active {
    background: #1db954;
    border-color: #1db954;
  }
  </style>
</head>
<body>

<?php
include 'header.php';
?>

  <!-- Playlist Header -->
  <header class="playlist-header">
    <!-- Floating elements -->
    <div class="floating-element"></div>
    <div class="floating-element"></div>
    
    <div class="container">
      <div class="header-content">
          <?php
            if (mysqli_num_rows($header_results) > 0) {
                while ($rows = mysqli_fetch_assoc($header_results)) {
                  $songsArray = array_filter(array_map('trim', explode(',', $rows['songs'])));
                  $songCount = count($songsArray);
                  $videosArray = array_filter(array_map('trim', explode(',', $rows['videos'])));
                  $videoCount = count($videosArray);
                  $trackCount = $songCount + $videoCount;
                    echo '
        <div class="playlist-cover">
          <img src="../../admin/uploads/albumscover/' . htmlspecialchars($rows['cover_image']) . '" alt="Viral Instagram Hits">
        </div>
        <div class="playlist-info">
          <div class="playlist-type">Album</div>
          <h1 class="playlist-title">' . $rows['title'] . '</h1>
          <p class="playlist-description">' . $rows['description'] . '</p>
          
          <div class="playlist-stats">
            <div class="stat">
              <i class="fas fa-music"></i> ' . $trackCount . ' tracks
            </div>
            <div class="stat">
              <i class="fas fa-clock"></i> 2h 30m
            </div>
          </div>
          <div class="playlist-actions">
            <button class="btn play-btn" id="playAlbumBtn">
              <i class="fas fa-play"></i> Play
            </button>
          </div>
        </div>
        ';
              }
          }
          ?>
      </div>
    </div>
  </header>


<section class="tracks-section container">
  <h2 class="section-title">Tracks</h2>
  <table class="tracks-table">
    <thead>
      <tr>
        <th class="track-number">#</th>
        <th class="track-title-header">Title</th>
        <th class="track-title-header">Type</th>
        <th class="track-album">Album</th>
        <th class="track-duration"><i class="fas fa-clock"></i></th>
      </tr>
    </thead>
    <tbody>
      <?php
      mysqli_data_seek($header_results, 0);
      $album = mysqli_fetch_assoc($header_results);
      $trackNumber = 1;
      
      if ($album) {
        // Process songs
        $songs_column = isset($album['songs']) ? trim($album['songs']) : '';
        if (!empty($songs_column)) {
          $song_titles = explode(',', $songs_column);
          foreach ($song_titles as $song_title) {
            $song_title = trim($song_title);
            if (empty($song_title)) continue;

            $safeSong = mysqli_real_escape_string($con, $song_title);
            // Use LIKE with wildcards to match titles that contain the string
            $song_query = mysqli_query($con, "SELECT * FROM songs WHERE title LIKE '%$safeSong%'");

            if ($song_query && mysqli_num_rows($song_query) > 0) {
              while ($song = mysqli_fetch_assoc($song_query)) {
                echo '
                <tr class="song-track" data-title="' . htmlspecialchars($song['title']) . '" data-artist="' . htmlspecialchars($song['artist']) . '"  data-src="../../admin/uploads/songs/' . $song['file'] . '" data-image="../../admin/uploads/songscover/' . htmlspecialchars($song['image']) . '" onclick="handleTrackClick(this)">
                  <td class="track-number">' . $trackNumber++ . '</td>
                  <td class="track-title">
                    <div class="track-cover">
                      <img src="../../admin/uploads/songscover/' . htmlspecialchars($song['image']) . '" alt="Song Cover">
                    </div>
                    <div class="track-info">
                      <a class="track-name" href="song.php?id='. $song['id'] .'" onclick="event.stopPropagation();">' . htmlspecialchars($song['title']) . '</a>
                      <div class="track-artist">' . htmlspecialchars($song['artist']) . '</div>
                    </div>
                  </td>
                  <td>Song</td>
                  <td class="track-album">' . htmlspecialchars($album['title']) . '</td>
                  <td class="track-duration">3:29</td>
                </tr>';
              }
            } else {
              // Debug output
              echo '<!-- Song not found: ' . htmlspecialchars($song_title) . ' -->';
            }
          }
        }

        // Process videos
        $videos_column = isset($album['videos']) ? trim($album['videos']) : '';
        if (!empty($videos_column)) {
          $video_titles = explode(',', $videos_column);
          foreach ($video_titles as $video_title) {
            $video_title = trim($video_title);
            if (empty($video_title)) continue;

            $safeVideo = mysqli_real_escape_string($con, $video_title);
            // Use LIKE with wildcards to match titles that contain the string
            $video_query = mysqli_query($con, "SELECT * FROM videos WHERE title LIKE '%$safeVideo%'");

            if ($video_query && mysqli_num_rows($video_query) > 0) {
              while ($video = mysqli_fetch_assoc($video_query)) {
                echo '
                <tr class="video-track" data-title="' . htmlspecialchars($video['title']) . '" data-artist="' . htmlspecialchars($video['artist']) . '" data-image="../../admin/uploads/videoscover/' . htmlspecialchars($video['image']) . '" data-type="video" data-link="' . htmlspecialchars($video['link']) . '" onclick="handleTrackClick(this)">
                  <td class="track-number">' . $trackNumber++ . '</td>
                  <td class="track-title">
                    <div class="track-cover">
                      <img src="../../admin/uploads/videoscover/' . htmlspecialchars($video['image']) . '" alt="Video Thumbnail">
                    </div>
                    <div class="track-info">
                      <a class="track-name" href="video.php?id='. $video['id'] .'" onclick="event.stopPropagation();">' . htmlspecialchars($video['title']) . '</a>
                      <div class="track-artist">' . htmlspecialchars($video['artist']) . '</div>
                    </div>
                  </td>
                  <td>Video</td>
                  <td class="track-album">' . htmlspecialchars($album['title']) . '</td>
                  <td class="track-duration">4:10</td>
                </tr>';
              }
            } else {
              // Debug output
              echo '<!-- Video not found: ' . htmlspecialchars($video_title) . ' -->';
            }
          }
        }
      } else {
        echo '<tr><td colspan="5" class="text-center py-4">No tracks found for this album</td></tr>';
      }
      ?>
    </tbody>
  </table>
</section>



  
  <section class="cards-section container">
    <h2 class="section-title">More Playlists</h2>
    <div class="cards-container">
      <?php
    $sql_albums = "SELECT * FROM albums";
$results = mysqli_query($con, $sql_albums);
if ($results && mysqli_num_rows($results) > 1) {
              while ($rows = mysqli_fetch_assoc($results)) {
                $songsArray = array_filter(array_map('trim', explode(',', $rows['songs'])));
                $songCount = count($songsArray);
                $videosArray = array_filter(array_map('trim', explode(',', $rows['videos'])));
                $videoCount = count($videosArray);
                $trackCount = $songCount + $videoCount;
                echo '
      <div class="card">
        <div class="card-cover">
          <img src="../../admin/uploads/albumscover/' . htmlspecialchars($rows['cover_image']) . '" alt="Playlist Cover">
          <div class="play-overlay">
            <div class="play-icon">
              <i class="fas fa-play"></i>
            </div>
          </div>
        </div>
        <div class="card-content">
          <h3 class="card-title">' . $rows['title'] . '</h3>
          <p class="card-description">' . $rows['description'] . '</p>
          <div class="card-stats">
            <span>' . $trackCount . ' tracks</span>
            <span>2h 30m</span>
          </div>
        </div>
      </div>
      ';
              }
            }else {
    echo '
    <div class="no-albums-card">
        <div class="no-albums-icon">
            <i class="fas fa-music"></i>
        </div>
        <div class="no-albums-content">
            <h3>No More Albums Available</h3>
            <p>We couldn’t find any albums at the moment. Please check back later or add some new content.</p>
        </div>
    </div>';
}
            ?>
    </div>
  </section>




  <!-- Rating Section -->
<div class="rating-section glass">
  <form action="submit-rating.php" method="POST">
  <?php

    $sql_album = "SELECT * FROM albums WHERE id = $albumId";
$album_result = mysqli_query($con, $sql_album);
        if (mysqli_num_rows($album_result) > 0) {
          while ($rows = mysqli_fetch_assoc($album_result)) {
            echo '
          <input type="hidden" name="album_id" id="album-id" value="' . $albumId . '">
          <input type="hidden" name="item_name" id="itemName" value="' . $rows['title'] . '">
          <input type="hidden" name="item_type" id="itemType" value="album">

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
  

  <!-- Replace the existing player-bottom-bar with this code -->
<div class="player-bar">
  <div class="now-playing">
    <img id="nowPlayingImg" src="https://images.unsplash.com/photo-1507874457470-272b3c8d8ee2?auto=format&fit=crop&w=56&q=80" alt="Album cover" class="now-playing-img">
    <div class="now-playing-info">
      <div id="nowPlayingTitle" class="now-playing-title">Carti</div>
      <div id="nowPlayingArtist" class="now-playing-artist">Shubh</div>
    </div>
  </div>
  
  <div class="player-controls">
    <button class="control-btn" id="prevBtn">
      <i class="bi bi-skip-backward-fill"></i>
    </button>
    <button class="control-btn" id="playPauseBtn">
      <i class="bi bi-play-fill"></i>
    </button>
    <button class="control-btn" id="nextBtn">
      <i class="bi bi-skip-forward-fill"></i>
    </button>
  </div>
  
  <div class="progress-container">
    <div class="progress-bar" onclick="setProgress(event)">
      <div class="progress" id="progress"></div>
    </div>
    <div class="progress-time">
      <span id="currentTime">0:00</span> / <span id="duration">0:00</span>
    </div>
  </div>
  
  <div class="volume-control">
    <button class="control-btn" id="loopBtn" onclick="toggleLoop(this)">
      <i class="bi bi-arrow-repeat"></i>
    </button>
    <input type="range" min="0" max="100" value="80" class="volume-slider" id="volumeSlider">
  </div>
</div>


<audio id="audio-player" src="" preload="auto"></audio>
  <?php
  include 'footer.php';
  ?>

  <?php
  include 'auth-modals.php';
  ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css"></script>
  <script>

let trackElements = [];
let currentTrackIndex = -1;
let ytPlayer = null;
let currentVideoID = null;
let currentAudioSrc = null;
let isCurrentTrackVideo = false;
let isLooping = false;
let progressUpdateInterval;

// Initialize when page loads
document.addEventListener("DOMContentLoaded", function() {

  document.getElementById("playAlbumBtn")?.addEventListener("click", playFirstTrack);
});


  
  // Get all track elements
  trackElements = Array.from(document.querySelectorAll("tr.song-track, tr.video-track"));
  
  // Set up track click events
  trackElements.forEach((el, index) => {
    el.addEventListener("click", () => {
      currentTrackIndex = index;
      handleTrackClick(el);
    });
  
  // Player controls setup
  setupPlayerControls();
  
  // Initialize audio player events
  const audioPlayer = document.getElementById('audio-player');
  if (audioPlayer) {
    audioPlayer.addEventListener('timeupdate', updateMediaProgress);
    audioPlayer.addEventListener('ended', handleTrackEnd);
  }
  
  // Setup volume control
  setupVolumeControl();
});

// Player control functions
function setupPlayerControls() {
  const playBtn = document.getElementById("playPauseBtn");
  
  // Play/Pause button
  playBtn?.addEventListener("click", () => {
    if (isCurrentTrackVideo) {
      toggleVideoPlayback();
    } else {
      toggleAudioPlayback();
    }
  });
  
  // Previous track button
  document.getElementById("prevBtn")?.addEventListener("click", () => {
    if (currentTrackIndex > 0) {
      currentTrackIndex--;
      trackElements[currentTrackIndex].click();
    }
  });
  
  // Next track button
  document.getElementById("nextBtn")?.addEventListener("click", () => {
    if (currentTrackIndex < trackElements.length - 1) {
      currentTrackIndex++;
      trackElements[currentTrackIndex].click();
    }
  });
  
  // Progress bar click event
  document.querySelector('.progress-bar')?.addEventListener('click', setProgress);
}

// Volume control setup
function setupVolumeControl() {
  const volumeSlider = document.getElementById('volumeSlider');
  const audioPlayer = document.getElementById('audio-player');
  
  if (volumeSlider && audioPlayer) {
    volumeSlider.addEventListener('input', (e) => {
      const volume = e.target.value / 100;
      audioPlayer.volume = volume;
      if (ytPlayer) ytPlayer.setVolume(e.target.value);
    });
    
    // Set initial volume
    audioPlayer.volume = volumeSlider.value / 100;
  }
}

// Toggle video playback
function toggleVideoPlayback() {
  if (!ytPlayer) return;
  
  const state = ytPlayer.getPlayerState();
  const playBtn = document.getElementById("playPauseBtn");
  
  if (state === YT.PlayerState.PLAYING) {
    ytPlayer.pauseVideo();
    playBtn.innerHTML = '<i class="bi bi-play-fill"></i>';
  } else {
    ytPlayer.playVideo();
    playBtn.innerHTML = '<i class="bi bi-pause-fill"></i>';
  }
}

// Toggle audio playback
function toggleAudioPlayback() {
  const audio = document.getElementById('audio-player');
  const playBtn = document.getElementById("playPauseBtn");
  
  if (!audio?.src) return;
  
  if (audio.paused) {
    audio.play();
    playBtn.innerHTML = '<i class="bi bi-pause-fill"></i>';
  } else {
    audio.pause();
    playBtn.innerHTML = '<i class="bi bi-play-fill"></i>';
  }
}

// Handle track click
function handleTrackClick(element) {
  // Update playing icon
  updatePlayingIcon(element);

  document.querySelector('.player-bar').classList.add('active');
  
  // Get track info
  const title = element.getAttribute('data-title');
  const artist = element.getAttribute('data-artist');
  const image = element.getAttribute('data-image');
  const isVideo = element.getAttribute('data-type') === 'video';
  const link = element.getAttribute('data-link');
  
  // Update player bar info
  document.getElementById('nowPlayingImg').src = image;
  document.getElementById('nowPlayingTitle').textContent = title;
  document.getElementById('nowPlayingArtist').textContent = artist;
  
  // Show player bar
  document.querySelector('.player-bar').classList.add('active');
  
  // Play the track
  if (isVideo && link) {
    playVideoTrack(link);
  } else {
    playAudioTrack(element);
  }
}

// Update playing icon on current track
function updatePlayingIcon(element) {
  // Remove all old playing icons
  trackElements.forEach(row => {
    const oldIcon = row.querySelector('.playing-icon');
    if (oldIcon) oldIcon.remove();
  });
  
  // Add new playing icon to clicked track
  const icon = document.createElement('span');
  icon.className = 'playing-icon';
  icon.textContent = '🔊';
  const trackNameEl = element.querySelector('.track-name');
  if (trackNameEl) trackNameEl.prepend(icon);
}

// Play video track
function playVideoTrack(link) {
  const audio = document.getElementById('audio-player');
  audio.pause();
  
  isCurrentTrackVideo = true;
  currentVideoID = extractYouTubeID(link);
  
  // Initialize YouTube player if needed
  if (!ytPlayer) {
    initializeYouTubePlayer();
  } else {
    // Load and play the video
    ytPlayer.loadVideoById(currentVideoID);
    ytPlayer.playVideo();
  }
  
  // Update play button
  document.getElementById('playPauseBtn').innerHTML = '<i class="bi bi-pause-fill"></i>';
  
  // Start progress updates
  startProgressUpdates();

  document.querySelector('.player-bar').classList.add('active');
}

// Play audio track
function playAudioTrack(element) {
  if (ytPlayer && ytPlayer.pauseVideo) ytPlayer.pauseVideo();
  
  isCurrentTrackVideo = false;
  const audio = document.getElementById('audio-player');
  currentAudioSrc = element.getAttribute('data-src');
  audio.src = currentAudioSrc;
  audio.play();
  
  // Update play button
  document.getElementById('playPauseBtn').innerHTML = '<i class="bi bi-pause-fill"></i>';
  
  // Start progress updates
  startProgressUpdates();

  document.querySelector('.player-bar').classList.add('active');
}

// Start progress updates
function startProgressUpdates() {
  // Clear any existing interval
  if (progressUpdateInterval) {
    clearInterval(progressUpdateInterval);
  }
  
  // Start new interval
  progressUpdateInterval = setInterval(updateMediaProgress, 200);
}

// Update progress bar
function updateMediaProgress() {
  const progress = document.getElementById('progress');
  const currentTimeEl = document.getElementById('currentTime');
  const durationEl = document.getElementById('duration');
  
  if (isCurrentTrackVideo && ytPlayer) {
    // Video progress
    const currentTime = ytPlayer.getCurrentTime();
    const duration = ytPlayer.getDuration();
    const percent = (currentTime / duration) * 100;
    
    if (progress) progress.style.width = percent + '%';
    if (currentTimeEl) currentTimeEl.textContent = formatTime(currentTime);
    if (durationEl) durationEl.textContent = formatTime(duration);
  } else {
    // Audio progress
    const audio = document.getElementById('audio-player');
    if (audio && !isNaN(audio.duration)) {
      const percent = (audio.currentTime / audio.duration) * 100;
      if (progress) progress.style.width = percent + '%';
      if (currentTimeEl) currentTimeEl.textContent = formatTime(audio.currentTime);
      if (durationEl) durationEl.textContent = formatTime(audio.duration);
    }
  }
}

// Set progress when user clicks on progress bar
function setProgress(event) {
  const progressBar = event.currentTarget;
  const clickPosition = event.offsetX;
  const progressBarWidth = progressBar.offsetWidth;
  const percentClicked = (clickPosition / progressBarWidth) * 100;
  
  if (isCurrentTrackVideo && ytPlayer) {
    const duration = ytPlayer.getDuration();
    const seekTo = (percentClicked / 100) * duration;
    ytPlayer.seekTo(seekTo, true);
  } else {
    const audio = document.getElementById('audio-player');
    if (audio) {
      const seekTo = (percentClicked / 100) * audio.duration;
      audio.currentTime = seekTo;
    }
  }
  
  // Immediately update progress display
  updateMediaProgress();
}

// Handle track ending
function handleTrackEnd() {
  if (!isLooping && currentTrackIndex < trackElements.length - 1) {
    currentTrackIndex++;
    trackElements[currentTrackIndex].click();
  }
}

// Initialize YouTube player
function initializeYouTubePlayer() {
  // Load YouTube API if needed
  if (!window.YT) {
    const tag = document.createElement('script');
    tag.src = "https://www.youtube.com/iframe_api";
    const firstScriptTag = document.getElementsByTagName('script')[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
    
    // Create global callback
    window.onYouTubeIframeAPIReady = () => {
      createYouTubePlayer();
    };
  } else {
    createYouTubePlayer();
  }
}

// Create YouTube player
function createYouTubePlayer() {
  ytPlayer = new YT.Player('youtube-player', {
    height: '0',
    width: '0',
    videoId: currentVideoID,
    events: {
      'onReady': (event) => {
        event.target.playVideo();
      },
      'onStateChange': onPlayerStateChange
    }
  });
}

// YouTube player state change handler
function onPlayerStateChange(event) {
  const playBtn = document.getElementById('playPauseBtn');
  
  if (event.data === YT.PlayerState.PLAYING) {
    if (playBtn) playBtn.innerHTML = '<i class="bi bi-pause-fill"></i>';
  } else if (event.data === YT.PlayerState.PAUSED) {
    if (playBtn) playBtn.innerHTML = '<i class="bi bi-play-fill"></i>';
  } else if (event.data === YT.PlayerState.ENDED) {
    if (playBtn) playBtn.innerHTML = '<i class="bi bi-play-fill"></i>';
    handleTrackEnd();
  }
}

// Utility functions
function extractYouTubeID(url) {
  const regExp = /(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|embed\/|v\/|shorts\/))([\w-]{11})/;
  const match = url.match(regExp);
  return match ? match[1] : null;
}

function formatTime(seconds) {
  const mins = Math.floor(seconds / 60);
  const secs = Math.floor(seconds % 60);
  return `${mins}:${secs < 10 ? '0' : ''}${secs}`;
}

// Loop functionality
function toggleLoop(button) {
  const icon = button.querySelector('i');
  isLooping = !isLooping;
  const audio = document.getElementById('audio-player');

  if (isLooping) {
    icon.classList.add('active');
    icon.style.color = '#1db954';
    if (audio) audio.loop = true;
  } else {
    icon.classList.remove('active');
    icon.style.color = '';
    if (audio) audio.loop = false;
  }
}

// Rating System
let currentRating = 0;
let ratingInput = document.getElementById("ratingInput");

// Handle star click
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

// Handle submit
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

// Navigation function
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