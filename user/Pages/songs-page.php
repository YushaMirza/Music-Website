<?php
session_start();
include '../connection.php';


$sql = "SELECT * FROM songs";
$result = mysqli_query($con, $sql);

$sql_albums = "SELECT * FROM albums";
$album_results = mysqli_query($con, $sql_albums);

$sql_artists = "SELECT * FROM artists";
$artist_results = mysqli_query($con, $sql_artists);
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Browse Songs | SOUND Group</title>
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

    

    /* Hero Section */
    .song-hero {
      background: linear-gradient(135deg, #3a1c71, #d76d77, #ffaf7b);
      padding: 140px 0 100px;
      text-align: center;
      position: relative;
      overflow: hidden;
      margin-bottom: 50px;
    }

    .hero-content {
      position: relative;
      z-index: 2;
    }

    .song-hero::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: radial-gradient(circle at top right, rgba(225, 48, 108, 0.2), transparent 70%),
                  radial-gradient(circle at bottom left, rgba(64, 93, 230, 0.2), transparent 70%);
    }

    .section-title {
      font-size: 3.5rem;
      font-weight: 800;
      margin-bottom: 20px;
      color: var(--lighter);
      position: relative;
      font-family: 'Montserrat', sans-serif;
      text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
    }

    .section-subtitle {
      font-size: 1.2rem;
      color: rgba(255, 255, 255, 0.85);
      max-width: 700px;
      margin: 0 auto 40px;
      line-height: 1.7;
    }

    /* Floating elements */
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

    .floating-element:nth-child(3) {
      width: 60px;
      height: 60px;
      background: rgba(255, 255, 255, 0.2);
      top: 30%;
      right: 20%;
    }


        .song-card {
    background: rgba(30, 30, 46, 0.7);
    border-radius: 16px;
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    border: 1px solid rgba(255, 255, 255, 0.08);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    position: relative;
    height: 100%;
    backdrop-filter: blur(10px);
    }

    .song-card:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: 0 20px 45px rgba(225, 48, 108, 0.4);
    border-color: rgba(225, 48, 108, 0.3);
    }

    .song-card::before {
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

    .song-card:hover::before {
    opacity: 1;
    }

    .album-art {
    position: relative;
    overflow: hidden;
    height: 240px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }

    .album-art img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
    }

    .song-card:hover .album-art img {
    transform: scale(1.07);
    }

    .play-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent 60%);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
    }

    .song-card:hover .play-overlay {
    opacity: 1;
    }

    .play-icon {
    width: 65px;
    height: 65px;
    background: var(--primary);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
    color: #fff;
    box-shadow: 0 6px 20px rgba(225, 48, 108, 0.4);
    transform: scale(0.85);
    transition: all 0.3s;
    cursor: pointer;
    }

    .song-card:hover .play-icon {
    transform: scale(1);
    }

    .song-duration {
    position: absolute;
    bottom: 15px;
    right: 15px;
    background: rgba(0, 0, 0, 0.75);
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 13px;
    color: #fff;
    font-weight: 500;
    }

    .song-meta {
    padding: 16px 20px 18px;
    }

    .song-title {
    font-size: 17px;
    font-weight: 700;
    color: #fff;
    margin-bottom: 4px;
    font-family: 'Montserrat', sans-serif;
    line-height: 1.3;
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
    }

    .song-artist {
    font-size: 14px;
    color: #aaa;
    margin-bottom: 12px;
    font-family: 'Inter', sans-serif;
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
    }

    .song-stats {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 13px;
    color: #ddd;
    gap: 10px;
    flex-wrap: wrap;
    }

    .song-plays,
    .song-likes {
    display: flex;
    align-items: center;
    gap: 6px;
    }

    .song-genre {
    background: rgba(255, 255, 255, 0.08);
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 500;
    color: #ffc6e2;
    text-transform: uppercase;
    }

    .trending-badge {
    position: absolute;
    top: 15px;
    left: 15px;
    background: var(--gradient);
    color: white;
    padding: 6px 15px;
    border-radius: 50px;
    font-size: 12px;
    font-weight: bold;
    z-index: 2;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.3);
    }


    /* Filter Section */
    .filter-section {
      background: rgba(30, 30, 46, 0.7);
      backdrop-filter: blur(10px);
      border-radius: 15px;
      padding: 25px;
      margin-bottom: 40px;
      border: 1px solid rgba(255, 255, 255, 0.1);
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
    }

    .filter-reset {
            background: transparent;
            border: 1px solid var(--light);
            color: var(--light);
        }
        
        .filter-reset:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        button#applyFilters{
            height: 3rem;
            margin: auto;
            font-size: .8rem;
        }

        button#resetFilters {
            height: 3rem;
            margin: auto;
            font-size: .8rem;
        }

    .filter-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 25px;
      flex-wrap: wrap;
      gap: 15px;
    }

    .filter-title {
      font-size: 1.5rem;
      font-weight: 700;
      color: var(--lighter);
      font-family: 'Montserrat', sans-serif;
    }

    .search-box {
      position: relative;
      max-width: 350px;
      width: 100%;
    }

    .search-box input {
      width: 100%;
      padding: 12px 20px 12px 45px;
      border-radius: 50px;
      background: rgba(20, 20, 36, 0.8);
      border: 1px solid rgba(255, 255, 255, 0.1);
      color: var(--lighter);
      font-size: 1rem;
      transition: all 0.3s;
    }

    .search-box input:focus {
      outline: none;
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(225, 48, 108, 0.25);
    }

    .search-box i {
      position: absolute;
      left: 20px;
      top: 50%;
      transform: translateY(-50%);
      color: var(--light);
    }

    .filter-options {
      display: flex;
      flex-wrap: wrap;
      gap: 15px;
      margin-top: 15px;
    }

    .filter-btn {
      background: rgba(255, 255, 255, 0.08);
      border: 1px solid rgba(255, 255, 255, 0.15);
      color: var(--lighter);
      padding: 8px 20px;
      border-radius: 50px;
      transition: all 0.3s;
      font-size: 0.9rem;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .filter-btn:hover, .filter-btn.active {
      background: var(--gradient);
      border-color: transparent;
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(225, 48, 108, 0.3);
    }

    .sort-select {
      background: rgba(20, 20, 36, 0.8);
      color: var(--lighter);
      border: 1px solid rgba(255, 255, 255, 0.1);
      padding: 8px 15px;
      border-radius: 50px;
      min-width: 180px;
    }

    .sort-select:focus {
      outline: none;
      border-color: var(--primary);
    }

    .filter-group {
            margin-bottom: 15px;
        }
        
        .filter-group label {
            display: block;
            color: var(--light);
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: 500;
        }
        
        .filter-group select {
            width: 100%;
            background: rgba(20, 20, 36, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 14px 20px;
            color: var(--lighter);
            font-size: 16px;
        }
        
        .filter-group select:focus {
            border-color: var(--primary);
            outline: none;
        }
        
        /* Year Spinner Control */
        .year-control {
            display: flex;
            align-items: center;
            background: rgba(20, 20, 36, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }
        
        .year-btn {
            background: rgba(30, 30, 46, 0.5);
            border: none;
            color: var(--light);
            font-size: 18px;
            width: 40px;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .year-btn:hover {
            background: rgba(64, 93, 230, 0.3);
            color: var(--lighter);
        }
        
        .year-input {
            flex: 1;
            background: transparent;
            border: none;
            padding: 14px 20px;
            color: var(--lighter);
            font-size: 16px;
            text-align: center;
            width: 100%;
        }
        
        .year-input:focus {
            outline: none;
        }
        
        .actions {
            display: flex;
            gap: 15px;
            margin-top: 10px;
        }

    

    /* Player Modal */
    .player-modal .modal-content {
      background: rgba(20, 20, 36, 0.95);
      backdrop-filter: blur(20px);
      border-radius: 20px;
      overflow: hidden;
      border: 1px solid rgba(255, 255, 255, 0.1);
      box-shadow: 0 30px 60px rgba(0, 0, 0, 0.5);
    }

    .player-modal .modal-header {
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
      padding: 20px;
    }

    .player-modal .modal-title {
      font-weight: 700;
      font-size: 22px;
      color: var(--lighter);
      font-family: 'Montserrat', sans-serif;
    }

    .player-modal .btn-close {
      filter: invert(1);
      opacity: 0.7;
    }

    .player-modal .modal-body {
      padding: 30px;
      text-align: center;
    }

    .album-art-large {
      width: 250px;
      height: 250px;
      border-radius: 10px;
      margin: 0 auto 30px;
      overflow: hidden;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    }

    .album-art-large img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .player-controls {
      margin: 30px 0;
    }

    .song-info {
      margin-bottom: 30px;
    }

    .song-title-large {
      font-size: 28px;
      font-weight: 700;
      margin-bottom: 10px;
      font-family: 'Montserrat', sans-serif;
    }

    .song-artist-large {
      font-size: 18px;
      color: var(--light);
    }

    .progress-container {
      width: 100%;
      margin: 20px 0;
    }

    .progress-bar {
      width: 100%;
      height: 6px;
      background: rgba(255, 255, 255, 0.1);
      border-radius: 3px;
      position: relative;
      cursor: pointer;
    }

    .progress {
      height: 100%;
      background: var(--gradient);
      border-radius: 3px;
      width: 30%;
    }

    .time-info {
      display: flex;
      justify-content: space-between;
      margin-top: 8px;
      font-size: 14px;
      color: var(--light);
    }

    .control-buttons {
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 30px;
      margin-top: 20px;
    }

    .control-btn {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      background: rgba(255, 255, 255, 0.1);
      color: var(--lighter);
      font-size: 18px;
      transition: all 0.3s;
      border: none;
    }

    .control-btn:hover {
      background: var(--primary);
      transform: scale(1.1);
    }

    .play-btn {
      width: 70px;
      height: 70px;
      background: var(--gradient);
      font-size: 24px;
    }

    /* Responsive */
    @media (max-width: 1200px) {
      .section-title {
        font-size: 3rem;
      }
    }

    @media (max-width: 992px) {
      .song-hero {
        padding: 120px 0 80px;
      }
      
      .section-title {
        font-size: 2.5rem;
      }
      
      .filter-header {
        flex-direction: column;
        align-items: flex-start;
      }
      
      .search-box {
        max-width: 100%;
      }
    }

    @media (max-width: 768px) {
      .section-title {
        font-size: 2rem;
      }
      
      .album-art {
        height: 200px;
      }
      
      .album-art-large {
        width: 200px;
        height: 200px;
      }
    }

    @media (max-width: 576px) {
      .section-title {
        font-size: 1.8rem;
      }
      
      .section-subtitle {
        font-size: 1rem;
      }
      
      .album-art {
        height: 180px;
      }
      
      .album-art-large {
        width: 160px;
        height: 160px;
      }
      
      .control-buttons {
        gap: 15px;
      }
      
      .control-btn {
        width: 40px;
        height: 40px;
      }
      
      .play-btn {
        width: 60px;
        height: 60px;
      }
    }
  </style>
</head>
<body>
  <?php
  include 'header.php';
  ?>

  <!-- Hero Section -->
  <section class="song-hero">
    <!-- Floating elements -->
    <div class="floating-element"></div>
    <div class="floating-element"></div>
    <div class="floating-element"></div>
    
    <div class="container hero-content">
      <h1 class="section-title">Trending Songs</h1>
      <p class="section-subtitle">Discover the most viral and popular songs taking the music world by storm</p>
    </div>
  </section>

  <!-- Main Content -->
  <div class="container">
  <!-- Filter Section -->
  <div class="filter-section">
    <div class="filter-header">
      <h3 class="filter-title">Find Your Favorite Songs</h3>
      <div class="search-box">
        <i class="bi bi-search"></i>
        <input type="text" placeholder="Search songs...">
      </div>
    </div>

    <div class="filter-options">
      <!-- Artist Filter -->
      <div class="filter-group">
        <label for="artistFilter">Artist</label>
        <select id="artistFilter">
          <option value="">All Artists</option>
          <?php
          if (mysqli_num_rows($artist_results) > 0) {
            while ($rows = mysqli_fetch_assoc($artist_results)) {
              echo '<option value="' . str_replace(' ', '-', strtolower(htmlspecialchars($rows['name']))) . '">' . htmlspecialchars($rows['name']) . '</option>';
            }
          }
          ?>
        </select>
      </div>

      <!-- Album Filter -->
      <div class="filter-group">
        <label for="albumFilter">Album</label>
        <select id="albumFilter">
          <option value="">All Albums</option>
          <?php
          if (mysqli_num_rows($album_results) > 0) {
            while ($rows = mysqli_fetch_assoc($album_results)) {
              echo '<option value="' . str_replace(' ', '-', strtolower($rows['title'])) . '">' . htmlspecialchars($rows['title']) . '</option>';
            }
          }
          ?>
        </select>
      </div>

      <!-- Genre Filter -->
      <div class="filter-group">
        <label for="genreFilter">Genre</label>
        <select id="genreFilter">
          <option value="">All Genres</option>
          <option value="pop">Pop</option>
          <option value="electronic">Electronic</option>
          <option value="hip-hop">Hip-Hop</option>
          <option value="rock">Rock</option>
          <option value="r&b">R&B</option>
          <option value="jazz">Jazz</option>
          <option value="classical">Classical</option>
        </select>
      </div>

      <!-- Language Filter -->
      <div class="filter-group">
        <label for="languageFilter">Language</label>
        <select id="languageFilter">
          <option value="">All Languages</option>
          <option value="english">English</option>
          <option value="hindi">Hindi</option>
          <option value="urdu">Urdu</option>
          <option value="spanish">Spanish</option>
          <option value="french">French</option>
          <option value="german">German</option>
          <option value="italian">Italian</option>
        </select>
      </div>

      <!-- Year Filter -->
      <div class="filter-group">
        <label for="yearFilter">Release Year</label>
        <div class="year-control">
          <button class="year-btn" id="decrementYear"><i class="bi bi-dash-lg"></i></button>
          <input type="number" id="yearInput" class="year-input" min="1900" max="2025" value="2023" placeholder="Year">
          <button class="year-btn" id="incrementYear"><i class="bi bi-plus-lg"></i></button>
        </div>
      </div>

      <!-- Buttons -->
      <div class="actions">
        <button class="btn btn-primary" id="applyFilters"><i class="bi bi-funnel"></i> Apply Filters</button>
        <button class="btn filter-reset" id="resetFilters"><i class="bi bi-arrow-clockwise"></i> Reset Filters</button>
      </div>
    </div>
  </div>

  <!-- Songs Grid -->
  <div class="row g-4">
    <?php
    if (mysqli_num_rows($result) > 0) {
      while ($rows = mysqli_fetch_assoc($result)) {
        $viralBadge = ($rows['new_flag'] === 'Yes') ? '<span class="trending-badge">NEW</span>' : '';
        echo '
        <div class="fullsongcard col-xl-4 col-lg-6 col-md-6" 
        data-name="' . htmlspecialchars($rows['title']) . '" 
        data-artist="' . str_replace(' ', '-', strtolower($rows['artist'])) . '" 
        data-album="' . str_replace(' ', '-', strtolower($rows['album'])) . '" 
        data-genre="' . strtolower($rows['genre']) . '" 
        data-language="' . strtolower($rows['language']) . '" 
        data-year="' . $rows['year'] . '">
        <div class="song-card" data-bs-toggle="modal" data-bs-target="#playerModal">
            ' . $viralBadge . '
            <div class="album-art">
            <img src="../../admin/uploads/songscover/' . $rows['image'] . '" alt="' . htmlspecialchars($rows['title']) . '">
            <div class="play-overlay">
                <div class="play-icon" onclick="location.href=\'song.php?id=' . $rows['id'] . '\'">
                <i class="bi bi-play-fill"></i>
                </div>
            </div>
            <span class="song-duration">3:20</span>
            </div>
            <div class="song-meta">
            <h4 class="song-title">' . htmlspecialchars($rows['title']) . '</h4>
            <p class="song-artist">' . htmlspecialchars($rows['artist']) . '</p>
            <div class="song-stats">
                <div class="song-plays"><i class="bi bi-play-fill"></i> 2.5B views  <span class="song-genre">' . htmlspecialchars($rows['genre']) . '</span></div>
                <div class="song-likes"><i class="bi bi-heart-fill"></i> 32M likes</div>
            </div>
            </div>
        </div>
        </div>';

      }
    }
    ?>
  </div>
</div>

<?php include 'footer.php'; ?>
<?php include 'auth-modals.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
  const searchInput = document.querySelector('.search-box input');
  const songCards = document.querySelectorAll('.fullsongcard');

  searchInput.addEventListener('keyup', function () {
  const searchValue = this.value.toLowerCase().trim();
  songCards.forEach(card => {
    const title = card.getAttribute('data-name')?.toLowerCase() || '';
    const artist = card.getAttribute('data-artist')?.toLowerCase() || '';

    const matchesSearch = title.includes(searchValue) || artist.includes(searchValue);
    card.style.display = matchesSearch ? '' : 'none';
  });
});

  document.getElementById('applyFilters').addEventListener('click', applyFilters);
  document.getElementById('resetFilters').addEventListener('click', resetFilters);

  function applyFilters() {
    const artist = document.getElementById('artistFilter').value;
    const album = document.getElementById('albumFilter').value;
    const genre = document.getElementById('genreFilter').value;
    const language = document.getElementById('languageFilter').value.toLowerCase();
    const year = document.getElementById('yearInput').value.trim();

    songCards.forEach(card => {
      const matchArtist = !artist || card.getAttribute('data-artist') === artist;
      const matchAlbum = !album || card.getAttribute('data-album') === album;
      const matchGenre = !genre || card.getAttribute('data-genre') === genre;
      const matchLanguage = !language || card.getAttribute('data-language') === language;
      const matchYear = !year || card.getAttribute('data-year') === year;

      card.style.display = (matchArtist && matchAlbum && matchGenre && matchLanguage && matchYear) ? '' : 'none';
    });
  }

  function resetFilters() {
    document.getElementById('artistFilter').value = '';
    document.getElementById('albumFilter').value = '';
    document.getElementById('genreFilter').value = '';
    document.getElementById('languageFilter').value = '';
    document.getElementById('yearInput').value = '';
    applyFilters();
  }

  document.getElementById('incrementYear').addEventListener('click', () => {
    const yearInput = document.getElementById('yearInput');
    let year = parseInt(yearInput.value) || 2023;
    if (year < 2025) yearInput.value = ++year;
  });

  document.getElementById('decrementYear').addEventListener('click', () => {
    const yearInput = document.getElementById('yearInput');
    let year = parseInt(yearInput.value) || 2023;
    if (year > 1900) yearInput.value = --year;
  });

  document.getElementById('yearInput').addEventListener('change', function () {
    let year = parseInt(this.value) || 2023;
    this.value = Math.min(2025, Math.max(1900, year));
  });
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

</body>
</html>