<?php
session_start();
include '../connection.php';

$sql_artists = "SELECT * FROM artists";
$results = mysqli_query($con, $sql_artists);
?>





<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Browse Artists | SOUND Group</title>
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
    .artists-hero {
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

    .artists-hero::before {
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


    /* Artist Cards */
    .artist-card {
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

    .artist-card::before {
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

    .artist-card:hover {
      transform: translateY(-15px);
      box-shadow: 0 15px 40px rgba(225, 48, 108, 0.4);
      background: rgba(40, 40, 60, 0.7);
    }

    .artist-card:hover::before {
      opacity: 1;
    }

    .artist-avatar {
      width: 180px;
      height: 180px;
      border-radius: 50%;
      object-fit: cover;
      border: 3px solid transparent;
      margin: 0 auto 25px;
      transition: all 0.4s;
      position: relative;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
      background: linear-gradient(white, white) padding-box,
                  var(--gradient) border-box;
    }

    .artist-card:hover .artist-avatar {
      transform: scale(1.08);
      box-shadow: 0 15px 35px rgba(225, 48, 108, 0.5);
    }

    .artist-name {
      font-size: 1.5rem;
      font-weight: 700;
      margin-bottom: 8px;
      font-family: 'Montserrat', sans-serif;
      position: relative;
      display: inline-block;
    }

    .artist-name::after {
      content: '';
      position: absolute;
      bottom: -5px;
      left: 50%;
      transform: translateX(-50%);
      width: 40px;
      height: 3px;
      background: var(--primary);
      border-radius: 2px;
      opacity: 0;
      transition: opacity 0.3s;
    }

    .artist-card:hover .artist-name::after {
      opacity: 1;
    }

    .artist-genre {
      font-size: 1rem;
      color: var(--light);
      margin-bottom: 15px;
    }

    .artist-stats {
      display: flex;
      justify-content: center;
      gap: 20px;
      margin-top: 15px;
      font-size: 0.9rem;
      color: var(--light);
    }

    .artist-stat {
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .stat-value {
      font-size: 1.3rem;
      font-weight: 700;
      color: var(--lighter);
      margin-bottom: 3px;
    }

    .artist-badge {
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
    }

    .artist-card:hover .artist-badge {
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

    .actions{
    align-content: center;
    margin-left: 2rem;
    margin-top: .5rem;
}

    .filter-reset {
            background: transparent;
            border: 1px solid var(--light);
            color: var(--light);
        }
        
        .filter-reset:hover {
            background: rgba(255, 255, 255, 0.1);
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

        select#languageFilter {
                width: 9rem;
        }

        @media (max-width: 500px){
          
          #applyFilter{
            margin-bottom: 10px !important;
          }
        }

    /* Category Header */
    .category-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin: 50px 0 30px;
      padding-bottom: 15px;
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
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
      
      .artist-avatar {
        width: 150px;
        height: 150px;
      }
    }

    @media (max-width: 768px) {
      .artists-hero {
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
      
      .artist-avatar {
        width: 130px;
        height: 130px;
      }
      
      .artist-name {
        font-size: 1.3rem;
      }
    }



    .row{
      margin-bottom: 2rem;
    }
  </style>
</head>
<body>
  <!-- Navbar -->
  <?php
  include 'header.php'
  ?>

  <!-- Hero Section -->
  <section class="artists-hero">
    <!-- Floating elements -->
    <div class="floating-element"></div>
    <div class="floating-element"></div>
    <div class="floating-element"></div>
    
    <div class="container hero-content">
      <h1 class="section-title">Discover Amazing Artists</h1>
      <p class="section-subtitle">Explore the most talented musicians and creators trending on Instagram. Find your next favorite artist and connect with their music.</p>
    </div>
  </section>

  <!-- Main Content -->
  <div class="container">
    <!-- Filter Section -->
    <div class="filter-section">
      <div class="filter-header">
        <h3 class="filter-title">Find Your Favorite Artists</h3>
        
        <div class="search-box">
          <i class="bi bi-search"></i>
          <input type="text" placeholder="Search artists...">
        </div>
      </div>
      
      <div class="filter-options">

          <div class="filter-group">
        <label for="artistFilter">Artist</label>
        <select id="artistFilter">
          <option value="">All Artists</option>
          <?php
          $artist_name = mysqli_query($con, "SELECT * FROM artists");
          
          if (mysqli_num_rows($artist_name) > 0) {
            while ($rows = mysqli_fetch_assoc($artist_name)) {
              echo '<option value="' . strtolower($rows['name']) . '">' . htmlspecialchars($rows['name']) . '</option>';
            }
          }
          ?>
        </select>
      </div>

      
      <div class="filter-group">
        <label for="countryFilter">Country</label>
        <select id="countryFilter">
          <option value="">All Countries</option>
          <?php
          $artist_country = mysqli_query($con, "SELECT * FROM artists");
          
          if (mysqli_num_rows($artist_country) > 0) {
            while ($rows = mysqli_fetch_assoc($artist_country)) {
              echo '<option value="' . strtolower($rows['country']) . '">' . htmlspecialchars($rows['country']) . '</option>';
            }
          }
          ?>
        </select>
      </div>

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
          <?php
          $artist_lang = mysqli_query($con, "SELECT * FROM artists");
          
          if (mysqli_num_rows($artist_lang) > 0) {
            while ($rows = mysqli_fetch_assoc($artist_lang)) {
          echo '<option value="'. $rows['language'] .'">'. $rows['language'] .'</option>';
            }
          }
          ?>
        </select>
      </div>


      <!-- Buttons -->
      <div class="actions">
        <button class="btn btn-primary me-2" id="applyFilters"><i class="bi bi-funnel"></i> Apply Filters</button>
        <button class="btn filter-reset" id="resetFilters"><i class="bi bi-arrow-clockwise"></i> Reset Filters</button>
      </div> 

      </div>
    </div>

    <!-- Top Artists -->
    <div class="category-header">
      <h3 class="category-title">Browse Artists</h3>
    </div>

    <div class="row g-4">
      <?php
      $artist_results_display = mysqli_query($con, "SELECT * FROM artists");
      
         if (mysqli_num_rows($artist_results_display) > 0) {
           while ($artist = mysqli_fetch_assoc($artist_results_display)) {
            echo '
                <div class="col-xl-3 col-lg-4 col-md-6 artist-card-container" id="artist-card" onclick=location.href="artist.php?artist=' . $artist['id'] . '">
            <div class="artist-card"
                data-name="' . strtolower($artist['name']) .'"
                data-genre="' . strtolower($artist['genres']) .'"
                data-country="' . strtolower($artist['country']) .'"
                data-language="' . strtolower($artist['language']) .'"
                onclick=`location.href="artist.php"`>
              <img src="../../admin/uploads/artists/' . $artist['image'] .'" alt="' . $artist['name'] .' Cover" class="artist-avatar"><br>
              <h4 class="artist-name">' . $artist['name'] .'</h4>
              <p class="artist-genre">' . str_replace(',', ' • ', $artist['genres']) .'</p>
              <p>' . $artist['language'] .'</p>
              <div class="artist-stats">
                <div class="artist-stat">
                  <span class="stat-value">55M</span>
                  <span>Followers</span>
                </div>
              </div>
            </div>
          </div>

              ';
             }
           }
        ?>
    </div>
  </div>

  <!-- Footer -->
  <?php
  include 'footer.php'
  ?>

  <?php
  include 'auth-modals.php'
  ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
     document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.querySelector('.search-box input');
    const artistFilter = document.getElementById('artistFilter');
    const genreFilter = document.getElementById('genreFilter');
    const countryFilter = document.getElementById('countryFilter');
    const languageFilter = document.getElementById('languageFilter');
    const resetBtn = document.getElementById('resetFilters');
    const applyBtn = document.getElementById('applyFilters');
    const artistCards = document.querySelectorAll('.artist-card-container');

    function filterArtists() {
      const searchTerm = searchInput.value.toLowerCase().trim();
      const artistVal = artistFilter.value.toLowerCase();
      const genreVal = genreFilter.value.toLowerCase();
      const countryVal = countryFilter.value.toLowerCase();
      const languageVal = languageFilter.value.toLowerCase();

      let visibleCount = 0;

      artistCards.forEach(card => {
        const cardEl = card.querySelector('.artist-card');
        const name = cardEl.dataset.name || '';
        const genre = cardEl.dataset.genre || '';
        const country = cardEl.dataset.country || '';
        const language = cardEl.dataset.language || '';

        const matchSearch = !searchTerm || name.includes(searchTerm);
        const matchArtist = !artistVal || name.includes(artistVal);
        const matchGenre = !genreVal || genre.includes(genreVal);
        const matchCountry = !countryVal || country.includes(countryVal);
        const matchLanguage = !languageVal || language.includes(languageVal);

        const isVisible = matchSearch && matchArtist && matchGenre && matchCountry && matchLanguage;
        card.style.display = isVisible ? '' : 'none';
        if (isVisible) visibleCount++;
      });

      const noResults = document.getElementById('noResults');
      if (visibleCount === 0 && !noResults) {
        const container = document.querySelector('.row.g-4');
        container.insertAdjacentHTML('beforeend', `
          <div class="col-12 no-results" id="noResults">
            <i class="bi bi-music-note-beamed"></i>
            <h3>No artists found</h3>
            <p>Try adjusting your filters or search</p>
          </div>
        `);
      } else if (visibleCount > 0 && noResults) {
        noResults.remove();
      }
    }

    function resetArtistFilters() {
      searchInput.value = '';
      artistFilter.value = '';
      genreFilter.value = '';
      countryFilter.value = '';
      languageFilter.value = '';

      artistCards.forEach(card => card.style.display = '');
      const noResults = document.getElementById('noResults');
      if (noResults) noResults.remove();
    }

    // Events
    searchInput.addEventListener('input', filterArtists);
    applyBtn.addEventListener('click', filterArtists);
    resetBtn.addEventListener('click', resetArtistFilters);
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