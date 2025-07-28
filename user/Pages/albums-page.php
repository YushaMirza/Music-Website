<?php
session_start();

include '../connection.php';


$sql_albums = "SELECT * FROM albums";
$results = mysqli_query($con, $sql_albums);

$album_rows = [];
if ($results && mysqli_num_rows($results) > 0) {
  while ($row = mysqli_fetch_assoc($results)) {
    $album_rows[] = $row;
  }
}

?>





<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Browse Albums | SOUND Group</title>
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

   

    /* Hero Section */
    .albums-hero {
      background: linear-gradient(135deg, #0f0c29, #302b63, #24243e);
      padding: 120px 0 80px;
      text-align: center;
      position: relative;
      overflow: hidden;
      margin-bottom: 50px;
    }

    .hero-content {
      position: relative;
      z-index: 2;
    }

    .albums-hero::before {
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
      background: var(--gradient);
      -webkit-background-clip: text;
      background-clip: text;
      -webkit-text-fill-color: transparent;
      display: inline-block;
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


    /* Album Cards */
    .album-card {
      text-align: center;
      transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      padding: 25px 20px;
      border-radius: 20px;
      background: rgba(30, 30, 46, 0.6);
      backdrop-filter: blur(10px);
      border: 1px solid rgba(255, 255, 255, 0.08);
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
      height: 100%;
      position: relative;
      overflow: hidden;
    }

    .album-card::before {
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

    .album-card:hover {
      transform: translateY(-15px);
      box-shadow: 0 15px 40px rgba(225, 48, 108, 0.4);
      background: rgba(40, 40, 60, 0.7);
    }

    .album-card:hover::before {
      opacity: 1;
    }

    .album-cover {
      width: 100%;
      aspect-ratio: 1/1;
      border-radius: 12px;
      object-fit: cover;
      margin: 0 auto 20px;
      transition: all 0.4s;
      position: relative;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
      background: linear-gradient(white, white) padding-box,
                  var(--gradient) border-box;
      border: 3px solid transparent;
    }

    .album-card:hover .album-cover {
      transform: scale(1.05);
      box-shadow: 0 15px 35px rgba(225, 48, 108, 0.5);
    }

    .album-title {
      font-size: 1.4rem;
      font-weight: 700;
      margin-bottom: 8px;
      font-family: 'Montserrat', sans-serif;
      position: relative;
      display: inline-block;
      text-align: left;
      width: 100%;
    }

    .album-title::after {
      content: '';
      position: absolute;
      bottom: -5px;
      left: 0;
      width: 40px;
      height: 3px;
      background: var(--primary);
      border-radius: 2px;
      opacity: 0;
      transition: opacity 0.3s;
    }

    .album-card:hover .album-title::after {
      opacity: 1;
    }

    .album-artist {
      font-size: 1rem;
      color: var(--light);
      margin-bottom: 15px;
      text-align: left;
      width: 100%;
    }

    .album-info {
      display: flex;
      justify-content: space-between;
      width: 100%;
      margin-top: 15px;
      font-size: 0.9rem;
      color: var(--light);
      text-align: left;
    }

    .album-stat {
      display: flex;
      flex-direction: column;
    }

    .stat-value {
      font-size: 1.1rem;
      font-weight: 700;
      color: var(--lighter);
      margin-bottom: 3px;
    }

    .album-badge {
      background: var(--gradient);
      color: white;
      padding: 5px 15px;
      border-radius: 50px;
      font-size: 0.8rem;
      font-weight: 700;
      display: inline-block;
      margin-top: 20px;
      box-shadow: 0 4px 15px rgba(225, 48, 108, 0.3);
      transition: transform 0.3s;
      position: absolute;
      top: 15px;
      right: 15px;
      z-index: 2;
    }

    .album-card:hover .album-badge {
      transform: translateY(-3px);
    }

    /* Sorting & Filtering */
    .filter-section {
      background: rgba(30, 30, 46, 0.7);
      backdrop-filter: blur(10px);
      border-radius: 15px;
      padding: 25px;
      margin-bottom: 40px;
      border: 1px solid rgba(255, 255, 255, 0.1);
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
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
            font-size: .9rem;
        }

        button#resetFilters {
            height: 3rem;
            margin: auto;
            font-size: .9rem;
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
            width: 13rem
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
            margin-left: 4rem;
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
      width: 150px;
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

    /* Category Header */
    .category-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin: 50px 0 30px;
      padding-bottom: 15px;
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
      padding: 0 12px
    }

    .category-title {
      font-size: 1.8rem;
      font-weight: 700;
      color: var(--lighter);
      font-family: 'Montserrat', sans-serif;
      position: relative;
      display: inline-block;
    }

    .category-title::after {
      content: '';
      position: absolute;
      bottom: -15px;
      left: 0;
      width: 50px;
      height: 4px;
      background: var(--primary);
      border-radius: 2px;
    }

    .view-all {
      color: var(--primary);
      text-decoration: none;
      font-weight: 600;
      display: flex;
      align-items: center;
      gap: 5px;
      transition: all 0.3s;
    }

    .view-all:hover {
      gap: 8px;
      text-decoration: underline;
    }

   

    /* Responsive */
    @media (max-width: 992px) {
      .section-title {
        font-size: 2.8rem;
      }
    }

    @media (max-width: 768px) {
      .albums-hero {
        padding: 100px 0 60px;
      }
      
      .section-title {
        font-size: 2.3rem;
      }
      
      .filter-header {
        flex-direction: column;
        align-items: flex-start;
      }
      
      .search-box {
        max-width: 100%;
      }
      
      .category-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 15px;
      }
    }

    @media (max-width: 576px) {
      .section-title {
        font-size: 2rem;
      }
      
      .album-title {
        font-size: 1.3rem;
      }
    }

    .row{
      margin-bottom: 2rem;
    }
    
    .album-container {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
      gap: 30px;
      padding: 20px;
    }

    .container{
        padding: 0px;
    }
    
    .album-meta {
      display: flex;
      justify-content: space-between;
      width: 100%;
      margin-top: 10px;
    }
    
    .album-tracks {
      text-align: left;
      width: 100%;
      margin-top: 15px;
      font-size: 0.9rem;
      color: var(--light);
      list-style: none;
      padding: 0;
    }
    
    .album-tracks li {
      padding: 5px 0;
      border-bottom: 1px solid rgba(255, 255, 255, 0.05);
      display: flex;
      justify-content: space-between;
    }
    
    .track-number {
      color: var(--primary);
      margin-right: 10px;
      font-weight: 600;
    }
    
    .play-button {
      background: var(--gradient);
      border: none;
      color: white;
      border-radius: 50%;
      width: 40px;
      height: 40px;
      display: flex;
      align-items: center;
      justify-content: center;
      position: absolute;
      bottom: 100px;
      right: 25px;
      opacity: 0;
      transform: translateY(10px);
      transition: all 0.3s ease;
      z-index: 3;
    }
    
    .album-card:hover .play-button {
      opacity: 1;
      transform: translateY(0);
    }
    
    .rating {
      color: gold;
      margin-top: 5px;
      font-size: 0.9rem;
    }




    /* Rating Section */
.rating-section {
  margin-top: 20px;
  padding: 15px;
  background: rgba(30, 30, 46, 0.5);
  border-radius: 12px;
  border: 1px solid rgba(255, 255, 255, 0.1);
}

.rating-section h4 {
  margin-bottom: 10px;
  font-family: 'Montserrat', sans-serif;
}

.rating-stars {
  display: flex;
  gap: 10px;
  margin-bottom: 15px;
}

.rating-stars i {
  font-size: 24px;
  color: var(--light);
  cursor: pointer;
  transition: all 0.2s;
}

.rating-stars i.active {
  color: gold;
}

.submit-rating {
  background: var(--gradient);
  color: white;
  border: none;
  padding: 8px 20px;
  border-radius: 50px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s;
}

.submit-rating:hover {
  transform: translateY(-2px);
  box-shadow: 0 5px 15px rgba(225, 48, 108, 0.3);
}

.rating-message {
  margin-top: 10px;
  font-size: 14px;
  color: var(--primary);
  min-height: 20px;
}
  </style>
</head>
<body>
  <?php
  include 'header.php';
  ?>

  <!-- Hero Section -->
  <section class="albums-hero">
    <!-- Floating elements -->
    <div class="floating-element"></div>
    <div class="floating-element"></div>
    <div class="floating-element"></div>
    
    <div class="container hero-content">
      <h1 class="section-title">Discover Amazing Albums</h1>
      <p class="section-subtitle">Explore the latest and greatest albums from your favorite artists. Find your next musical journey among these incredible collections.</p>
    </div>
  </section>

  <!-- Main Content -->
  <div class="container">
    <!-- Filter Section -->
    <div class="filter-section">
      <div class="filter-header">
        <h3 class="filter-title">Find Your Favorite Albums</h3>
        
        <div class="search-box">
          <i class="bi bi-search"></i>
          <input type="text" placeholder="Search albums..." id="albumSearch">
        </div>
      </div>
      
      <div class="filter-options">

        <div class="filter-group">
        <label for="albumFilter">Album</label>
        <select id="albumFilter">
  <option value="">All Albums</option>
  <?php
  foreach ($album_rows as $row) {
    echo '<option value="' . str_replace(' ', '-', strtolower(htmlspecialchars($row['title']))) . '">' . htmlspecialchars($row['title']) . '</option>';
  }
  ?>
</select>

      </div>

        <div class="filter-group">
        <label for="artistFilter">Artist</label>
<select id="artistFilter">
  <option value="">All Artists</option>
  <?php
  $artist = mysqli_query($con, "SELECT * FROM albums");
  if (mysqli_num_rows($artist) > 0) {
    while ($rows = mysqli_fetch_assoc($artist)) {
      $artistName = htmlspecialchars($rows['artist']);
      if (!empty($artistName)) {
        echo '<option value="' . strtolower($artistName) . '">' . $artistName . '</option>';
      }
    }
  }
  ?>
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

    <!-- Top Albums -->
    <div class="category-header">
      <h3 class="category-title">Browse Albums</h3>
      <a href="#" class="view-all">View All <i class="bi bi-arrow-right"></i></a>
    </div>

    <div class="album-container">
<?php
foreach ($album_rows as $row) {
    $songsArray = array_filter(array_map('trim', explode(',', $row['songs'])));
    $songCount = count($songsArray);

    // Count videos
    $videosArray = array_filter(array_map('trim', explode(',', $row['videos'])));
    $videoCount = count($videosArray);

    // Total tracks
    $trackCount = $songCount + $videoCount;
  echo '
    <div class="album-card"
      data-title="'. strtolower(htmlspecialchars($row['title'])) .'"
  data-name="'. htmlspecialchars($row['title']) .'"
  data-artist="'. strtolower($row['artist']) .'"
  data-year="'. $row['release_year'] .'">
      <img src="../../admin/uploads/albumscover/' . $row['cover_image'] . '" alt="Album Cover" class="album-cover">
      <h4 class="album-title">' . htmlspecialchars($row['title']) . '</h4>
      <p class="album-artist">' . htmlspecialchars($row['artist']) . '</p>
      <div class="album-meta">
        <div class="album-stat">
          <span class="stat-value">' . $row['release_year'] . '</span>
          <span>Release</span>
        </div>
        <div class="album-stat">
          <span class="stat-value">' . $trackCount . '</span>
          <span>Tracks</span>
        </div>
      </div>
      <button class="play-button" onclick=location.href="album.php?album=' . $row['id'] . '">
        <i class="bi bi-play-fill"></i>
      </button>
    </div>
  ';
}
?>
</div>


  <?php
  include 'footer.php';
  ?>

  <?php
  include 'auth-modals.php';
  ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener("DOMContentLoaded", function () {
  const searchInput = document.getElementById("albumSearch");
  const albumFilter = document.getElementById("albumFilter");
  const artistFilter = document.getElementById("artistFilter");
  const yearInput = document.getElementById("yearInput");
  const applyBtn = document.getElementById("applyFilters");
  const resetBtn = document.getElementById("resetFilters");
  const albumCards = document.querySelectorAll(".album-card");

  function applyFilters() {
    const searchVal = searchInput.value.toLowerCase().trim();
    const selectedAlbum = albumFilter.value.toLowerCase();
    const selectedArtist = artistFilter.value.toLowerCase();
    const selectedYear = yearInput.value;

    albumCards.forEach(card => {
      const title = card.dataset.title.toLowerCase();
      const artist = card.dataset.artist.toLowerCase();
      const year = card.dataset.year;

      // Simple checks
      const matchesSearch = !searchVal || title.includes(searchVal) || artist.includes(searchVal);
      const matchesAlbum = !selectedAlbum || title === selectedAlbum;
      const matchesArtist = !selectedArtist || artist === selectedArtist;
      const matchesYear = !selectedYear || year == selectedYear;

      // Show or hide card
      if (matchesSearch && matchesAlbum && matchesArtist && matchesYear) {
        card.style.display = "";
      } else {
        card.style.display = "none";
      }
    });
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

  // Apply filters on button click and live search
  applyBtn.addEventListener("click", applyFilters);
  searchInput.addEventListener("input", applyFilters);

  // Reset filters
  resetBtn.addEventListener("click", () => {
    searchInput.value = "";
    albumFilter.value = "";
    artistFilter.value = "";
    yearInput.value = "";
    albumCards.forEach(card => card.style.display = "");
  });

  // Play button alert
  
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