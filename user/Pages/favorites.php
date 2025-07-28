<?php
session_start();
include '../connection.php';

$user_id = $_SESSION['user_id'];

// Fetch favorite songs
$favorite_songs = mysqli_query($con, "
    SELECT songs.id, songs.title, songs.artist, songs.image, songs.file, 'song' as type 
    FROM favorites 
    JOIN songs ON favorites.song_id = songs.id 
    WHERE favorites.user_id = '$user_id'
    AND favorites.song_id IS NOT NULL
");

// Fetch favorite videos
$favorite_videos = mysqli_query($con, "
    SELECT videos.id, videos.title, videos.artist, videos.image, videos.link as file, 'video' as type 
    FROM favorites 
    JOIN videos ON favorites.video_id = videos.id 
    WHERE favorites.user_id = '$user_id'
    AND favorites.video_id IS NOT NULL
");

$all_favorites = [];
if ($favorite_songs) {
    while ($row = mysqli_fetch_assoc($favorite_songs)) $all_favorites[] = $row;
}
if ($favorite_videos) {
    while ($row = mysqli_fetch_assoc($favorite_videos)) $all_favorites[] = $row;
}
shuffle($all_favorites);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Your Favorites | SOUND Group</title>
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
    }

    .page-header {
      text-align: center;
      padding: 70px 20px 40px;
      position: relative;
    }

    .page-header h1 {
      font-size: 3.5rem;
      font-weight: 800;
      background: linear-gradient(to right, #fff, #ff9dbb);
      -webkit-background-clip: text;
      background-clip: text;
      -webkit-text-fill-color: transparent;
      margin-bottom: 15px;
    }

    .page-header p {
      font-size: 1.2rem;
      color: var(--light);
      max-width: 600px;
      margin: 0 auto;
    }

    .favorites-container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 20px;
    }

    .favorites-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
      gap: 25px;
    }

    .favorite-item {
      background: rgba(30, 30, 46, 0.6);
      border-radius: 16px;
      overflow: hidden;
      transition: all 0.3s ease;
      position: relative;
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
      border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .favorite-item:hover {
      transform: translateY(-10px);
      box-shadow: 0 15px 30px rgba(225, 48, 108, 0.3);
    }

    .favorite-image {
      width: 100%;
      height: 220px;
      object-fit: cover;
      display: block;
    }

    .favorite-info {
      padding: 20px;
    }

    .favorite-title {
      font-size: 1.4rem;
      font-weight: 700;
      margin-bottom: 5px;
      font-family: 'Montserrat', sans-serif;
    }

    .favorite-artist {
      color: var(--light);
      margin-bottom: 15px;
    }

    .play-btn {
      display: block;
      width: 100%;
      background: var(--gradient);
      color: white;
      text-align: center;
      padding: 12px;
      border-radius: 10px;
      font-weight: 600;
      text-decoration: none;
      transition: all 0.3s;
    }

    .play-btn:hover {
      transform: scale(1.05);
      box-shadow: 0 5px 15px rgba(225, 48, 108, 0.4);
    }

    .empty-favorites {
      text-align: center;
      padding: 50px 20px;
      max-width: 600px;
      margin: 0 auto;
    }

    .empty-icon {
      font-size: 5rem;
      color: var(--light);
      margin-bottom: 20px;
      opacity: 0.5;
    }

    /* Player Bar */
    #playerBar {
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
    }

    .now-playing {
      display: flex;
      align-items: center;
      flex: 1;
    }

    .now-playing-img {
      width: 60px;
      height: 60px;
      border-radius: 8px;
      object-fit: cover;
      margin-right: 15px;
    }

    .now-playing-info {
      flex: 1;
    }

    .now-playing-title {
      font-weight: 600;
      margin-bottom: 3px;
    }

    .now-playing-artist {
      font-size: 0.9rem;
      color: var(--light);
    }

    .player-controls {
      display: flex;
      align-items: center;
      gap: 20px;
    }

    .control-btn {
      background: transparent;
      border: none;
      color: var(--lighter);
      font-size: 20px;
      cursor: pointer;
      transition: all 0.3s;
      width: 40px;
      height: 40px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .control-btn:hover {
      background: rgba(255, 255, 255, 0.1);
      color: var(--primary);
    }

    .progress-container {
      flex: 2;
      max-width: 500px;
      margin: 0 20px;
    }

    .progress-bar {
      height: 4px;
      background: rgba(255, 255, 255, 0.1);
      border-radius: 2px;
      cursor: pointer;
      position: relative;
    }

    .progress {
      height: 100%;
      background: var(--gradient);
      border-radius: 2px;
      width: 0%;
      position: relative;
      transition: width 0.2s linear;
    }

    @media (max-width: 768px) {
      .page-header h1 {
        font-size: 2.5rem;
      }
      
      .progress-container {
        display: none;
      }
      
      .now-playing-info {
        max-width: 150px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
      }
    }
  </style>
</head>
<body>
  <?php include 'header.php'; ?>
  
  <div class="page-header">
    <div class="container">
      <h1>Your Favorite Songs</h1>
      <p>All the songs you've loved in one place</p>
    </div>
  </div>
  
  <div class="favorites-container">
    <?php if (count($all_favorites) > 0): ?>
        <div class="favorites-grid">
            <?php foreach ($all_favorites as $item): ?>
                <div class="favorite-item">
                    <img src="../../admin/uploads/<?= $item['type'] ?>scover/<?= $item['image'] ?>" 
                         alt="<?= htmlspecialchars($item['title']) ?>" 
                         class="favorite-image">
                    <div class="favorite-info">
                        <h3 class="favorite-title"><?= $item['title'] ?></h3>
                        <p class="favorite-artist"><?= $item['artist'] ?></p>
                        <p class="badge bg-primary"><?= ucfirst($item['type']) ?></p>
                        <a href="#" class="play-btn" 
                           onclick="playFavorite(<?= $item['id'] ?>, '<?= $item['type'] ?>')">
                            <i class="bi bi-play-fill"></i> Play
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="empty-favorites">
            <div class="empty-icon">
                <i class="bi bi-music-note-list"></i>
            </div>
            <h3>No favorites yet</h3>
            <p>Start adding songs and videos to your favorites and they'll appear here</p>
            <a href="songs-page.php" class="btn btn-primary mt-3">Browse Content</a>
        </div>
    <?php endif; ?>
</div>
  
  <!-- Player Bar -->
  <div id="playerBar" style="display: none;">
    <div class="now-playing">
      <img id="nowPlayingImg" src="" alt="Now Playing" class="now-playing-img">
      <div class="now-playing-info">
        <div id="nowPlayingTitle" class="now-playing-title"></div>
        <div id="nowPlayingArtist" class="now-playing-artist"></div>
      </div>
    </div>
    
    <div class="player-controls">
      <button class="control-btn" id="prevBtn"><i class="bi bi-skip-backward-fill"></i></button>
      <button class="control-btn" id="playPauseBtn"><i class="bi bi-play-fill"></i></button>
      <button class="control-btn" id="nextBtn"><i class="bi bi-skip-forward-fill"></i></button>
    </div>
    
    <div class="progress-container">
      <div class="progress-bar" onclick="setProgress(event)">
        <div class="progress" id="progress"></div>
      </div>
    </div>
  </div>
  
  <?php include 'footer.php'; ?>
  <?php include 'auth-modals.php'; ?>
  
  <audio id="audioPlayer"></audio>
  <div id="ytPlayerContainer" style="display: none;">
  <div id="ytPlayer"></div>
</div>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://www.youtube.com/iframe_api"></script>
  
  <script>

let ytPlayer;
let ytVideoID = "";

function onYouTubeIframeAPIReady() {
  ytPlayer = new YT.Player('ytPlayer', {
    height: '0',
    width: '0',
    videoId: '', // will be set later
    playerVars: {
      'autoplay': 1,
      'controls': 0,
      'rel': 0
    },
    events: {
      'onReady': () => console.log('YouTube Player ready')
    }
  });
}


    
    // Array to store favorite songs
    // Replace the old favoriteSongs array with the new combined favoriteItems
const favoriteItems = [
    <?php foreach ($all_favorites as $item): ?>
    {
        id: <?= $item['id'] ?>,
        type: '<?= $item['type'] ?>',
        title: '<?= addslashes($item['title']) ?>',
        artist: '<?= addslashes($item['artist']) ?>',
        image: '../../admin/uploads/<?= $item['type'] ?>scover/<?= $item['image'] ?>',
        file: '<?= $item['type'] === 'song' 
            ? '../../admin/uploads/songs/' . $item['file'] 
            : $item['file'] ?>'
    },
    <?php endforeach; ?>
];

let currentSongIndex = -1;
const audioPlayer = document.getElementById('audioPlayer');
const videoPlayer = document.getElementById('videoPlayer');
const playerBar = document.getElementById('playerBar');
const nowPlayingImg = document.getElementById('nowPlayingImg');
const nowPlayingTitle = document.getElementById('nowPlayingTitle');
const nowPlayingArtist = document.getElementById('nowPlayingArtist');
const progressBar = document.getElementById('progress');
const playPauseBtn = document.getElementById('playPauseBtn');

function playFavorite(id, type) {
  const index = favoriteItems.findIndex(i => i.id === id && i.type === type);
  if (index === -1) return;

  currentSongIndex = index;
  const item = favoriteItems[index];

  // Update UI
  nowPlayingImg.src = item.image;
  nowPlayingTitle.textContent = item.title;
  nowPlayingArtist.textContent = item.artist;
  playerBar.style.display = 'flex';

  // Reset players
  audioPlayer.pause();
  audioPlayer.src = '';
  isVideo = (type === 'video');

  if (type === 'video') {
  ytVideoID = getYouTubeID(item.file);

  if (ytPlayer && ytPlayer.loadVideoById) {
    ytPlayer.loadVideoById(ytVideoID);
  } else {
    // Wait until YouTube API is ready
    const interval = setInterval(() => {
      if (ytPlayer && ytPlayer.loadVideoById) {
        ytPlayer.loadVideoById(ytVideoID);
        clearInterval(interval);
      }
    }, 500);
  }

  playPauseBtn.innerHTML = '<i class="bi bi-pause-fill"></i>';
  document.getElementById('ytPlayerContainer').style.display = 'none'; // audio only
}else if (type === 'song') {
    document.getElementById('ytPlayer').style.display = 'none';
    audioPlayer.src = item.file;
    audioPlayer.play();
    playPauseBtn.innerHTML = '<i class="bi bi-pause-fill"></i>';
  } 
}



// Extract YouTube video ID
function getYouTubeID(url) {
  const match = url.match(/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^\&\?\/]+)/);
  return match ? match[1] : '';
}

// Convert normal YouTube URL to embed format
function convertToEmbedURL(url) {
  const ytMatch = url.match(/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^\&\?\/]+)/);
  if (ytMatch && ytMatch[1]) {
    return `https://www.youtube.com/embed/${ytMatch[1]}`;
  }
  return url; // fallback
}




// Play/Pause toggle
playPauseBtn.addEventListener('click', () => {
  if (favoriteItems.length === 0 || currentSongIndex === -1) return;

  const currentItem = favoriteItems[currentSongIndex];

  if (currentItem.type === 'song') {
    if (audioPlayer.paused) {
      audioPlayer.play();
      playPauseBtn.innerHTML = '<i class="bi bi-pause-fill"></i>';
    } else {
      audioPlayer.pause();
      playPauseBtn.innerHTML = '<i class="bi bi-play-fill"></i>';
    }
  } else if (currentItem.type === 'video') {
    if (ytPlayer.getPlayerState() === YT.PlayerState.PLAYING) {
      ytPlayer.pauseVideo();
      playPauseBtn.innerHTML = '<i class="bi bi-play-fill"></i>';
    } else {
      ytPlayer.playVideo();
      playPauseBtn.innerHTML = '<i class="bi bi-pause-fill"></i>';
    }
  }
});


setInterval(() => {
  if (currentSongIndex !== -1 && favoriteItems[currentSongIndex].type === 'video') {
    const duration = ytPlayer.getDuration();
    const currentTime = ytPlayer.getCurrentTime();
    const percent = (currentTime / duration) * 100;
    progressBar.style.width = percent + '%';
  }
}, 1000);



// Previous item
document.getElementById('prevBtn').addEventListener('click', () => {
    if (favoriteItems.length === 0) return;

    currentSongIndex = currentSongIndex > 0 ? currentSongIndex - 1 : favoriteItems.length - 1;
    const item = favoriteItems[currentSongIndex];
    playFavorite(item.id, item.type);
});

// Next item
document.getElementById('nextBtn').addEventListener('click', () => {
    if (favoriteItems.length === 0) return;

    currentSongIndex = currentSongIndex < favoriteItems.length - 1 ? currentSongIndex + 1 : 0;
    const item = favoriteItems[currentSongIndex];
    playFavorite(item.id, item.type);
});

// Progress bar update (only for songs)
audioPlayer.addEventListener('timeupdate', () => {
  if (favoriteItems.length === 0 || currentSongIndex === -1) return;

  const item = favoriteItems[currentSongIndex];
  if (item.type === 'song') {
    const percent = (audioPlayer.currentTime / audioPlayer.duration) * 100;
    progressBar.style.width = percent + '%';
  }
});

function setProgress(e) {
    if (favoriteItems.length === 0 || currentSongIndex === -1) return;

    const currentItem = favoriteItems[currentSongIndex];
    const width = e.currentTarget.clientWidth;
    const clickX = e.offsetX;

    if (currentItem.type === 'song') {
        const duration = audioPlayer.duration;
        audioPlayer.currentTime = (clickX / width) * duration;
    } else if (currentItem.type === 'video') {
        const duration = ytPlayer.getDuration();
        const seekTime = (clickX / width) * duration;
        ytPlayer.seekTo(seekTime, true);
    }
}



// Convert YouTube or local video URL to embed format
function convertToEmbedURL(url) {
  const ytMatch = url.match(/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^\&\?\/]+)/);
  if (ytMatch && ytMatch[1]) {
    return `https://www.youtube.com/embed/${ytMatch[1]}`;
  }
  return url;
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