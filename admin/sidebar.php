<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div id="sidebar">
            <div class="sidebar-header">
                <h3><i class="bi bi-music-note-beamed"></i> <span>SOUNDGroup</span></h3>
            </div>
            
            <ul class="nav flex-column mt-4">
                <li class="nav-item">
                    <a class="nav-link dashboardlink" onclick="navigateTo('dashboard')" data-page="dashboard">
                        <i class="bi bi-speedometer2"></i> <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" onclick="navigateTo('users')" data-page="users">
                        <i class="bi bi-people"></i> <span>Users</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" onclick="navigateTo('artists')" data-page="artists">
                        <i class="bi bi-mic"></i> <span>Artists</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" onclick="navigateTo('songs')" data-page="songs">
                        <i class="bi bi-music-note-list"></i> <span>Songs</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" onclick="navigateTo('albums')" data-page="albums">
                        <i class="bi bi-collection-play"></i> <span>Albums</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" onclick="navigateTo('videos')" data-page="videos">
                        <i class="bi bi-camera-video"></i> <span>Videos</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" onclick="navigateTo('reviews')" data-page="reviews">
                        <i class="bi bi-tags"></i> <span>Reviews</span>
                    </a>
                </li>
                
                <li class="nav-divider"></li>
                
                <li class="nav-divider"></li>
                
                <li class="nav-item">
                    <a class="nav-link" href="logout.php" data-page="logout">
                        <i class="bi bi-box-arrow-right"></i> <span>Logout</span>
                    </a>
                </li>
            </ul>
        </div>
        <script>
            navLinks.forEach(link => {
  if (link.dataset.page === currentPage) {
    link.classList.add('active');
  } else {
    link.classList.remove('active');
  }
  });






    const pageMap = {
  'dashboard.php': 'dashboard',
  'users.php': 'users',
  'artists.php': 'artists',
  'songs.php': 'songs',
  'albums.php': 'albums',
  'videos.php': 'videos',
  'reviews.php': 'reviews'
};

const currentFile = window.location.pathname.split('/').pop();
const currentPage = pageMap[currentFile] || ''; // fallback

const navLinks = document.querySelectorAll('.nav-link[data-page]');

navLinks.forEach(link => {
  if (link.dataset.page === currentPage) {
    link.classList.add('active');
  } else {
    link.classList.remove('active');
  }
  });

  function navigateTo(page) {

    // Logged in? Redirect based on selected page
    switch (page) {
      case 'dashboard':
        window.location.href = 'dashboard.php';
        break;
      case 'users':
        window.location.href = 'users.php';
        break;
      case 'artists':
        window.location.href = 'artists.php';
        break;
      case 'songs':
        window.location.href = 'songs.php';
        break;
      case 'albums':
        window.location.href = 'albums.php';
        break;
      case 'videos':
        window.location.href = 'videos.php';
        break;
        case 'reviews':
        window.location.href = 'reviews.php';
        break;
        default:
        alert("Page Not Found");
    }
  }
        </script>
</body>
</html>