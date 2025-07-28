<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        a {
            cursor: pointer;
        }


        .navbar {
      background: rgba(0, 0, 0, 0.8);
      backdrop-filter: blur(10px);
      padding: 15px 12px;
      position: sticky;
      top: 0;
      z-index: 1000;
      box-shadow: 0 2px 15px rgba(0, 0, 0, 0.5);
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
      transition: all 0.4s ease;
    }

    .navbar-scrolled {
      padding: 10px 12px;
      background: rgba(10, 10, 20, 0.95);
    }

     /* temp */
    .container {
      max-width: 100%;
      margin: 0;
    }

    .navbar-brand-container {
        cursor: pointer;
      position: relative;
      display: flex;
      align-items: center;
    }

    .navbar-brand {
      font-size: 28px;
      font-weight: 700;
      color: var(--lighter) !important;
      display: flex;
      align-items: center;
      font-family: 'Montserrat', sans-serif;
      transition: opacity 0.3s ease;
    }

    .navbar-brand i {
      color: var(--primary);
      margin-right: 10px;
    }

    #navbarSearch {
      display: flex;
      align-items: center;
      margin-left: 10px;
    }

    #navbarSearch2 {
      display: none;
      align-items: center;
    }

    #searchbtn2{
    position: static;
    width: 54%;
    margin: 30px 0 0 50%;
    transform: translateX(-50%);
    }



    .navbar-brand.hidden {
      opacity: 0;
      pointer-events: none;
    }
    .search-toggle {
      position: relative;
      z-index: 2;
    }

    #navbarNav{
    justify-items: center;
}

    .loginbtncolor {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        border: none;
        border-radius: 10px;
        transition: all 0.3s;
        Color: var(--mdlight);
    }

    .loginbtncolor:hover {
      transform: translateY(-2px);
      box-shadow: 0 7px 20px rgba(225, 48, 108, 0.4);
    }

      .loginbtnoutline{
        background: transparent;
        border: 1px solid var(--primary);
        color: var(--primary);
        border-radius: 10px;
        transition: all 0.3s;
        flex: 1;
      }

      .loginbtnoutline:hover {
            background: rgba(225, 48, 108, 0.1);
        }

      #loginbtn1 {
        display: block ;
        position: absolute;
        right: 160px;
      }

      #loginbtn2 {
        display: none ;
      }

      #signupbtn {
        display: block ;
        position: absolute;
        right: 250px;
      }

    button.navbar-toggler {
      position: absolute;
      right: 160px ;
      top: 20px;
    }

    .user-name-dd{
      display: none;
    }

    span.user-name-dd{
    color: #b8b8b8;
    text-align: center;
}

.user-menu-divider1{
  display: none;
}

    @media (max-width: 1500px) {
      #loginbtn1 {
        display: block !important;
      }

      #signupbtn {
        position: static;
        margin-top: 21px;
        display: none !important;
      }
    }

    @media (min-width: 1330px) {

      .navbar-nav {
        padding-right: 1vw;
        width: 58vw;
        justify-content: center;
      }
    }

    @media (max-width: 1329px) {
      .navbar-nav {
        width: 55vw;
      }
    }

    @media (max-width: 1300px) AND (min-width: 1200px) {
       #loginbtn1{
         display: none !important;
       }

       .user-menu-divider2{
          display: none !important;
       }

    }

    @media (min-width: 1199px) {
      #navbarSearch2 {
        display: none !important;
      }

      #navbarNav {
        gap: 10px;
      }

    }

    @media (max-width: 1199px) {

      #navbarSearch2 {
        display: none !important;
      }

      #navbarSearch {
        position: absolute !important;
        left: 280px;
        top: 19px;
      }
      #loginbtn1{
            right: 250px !important;
      }
      
    }

    @media (max-width:768px) {
      button.navbar-toggler {
        position: absolute;
        right: 90px;
      }

       .user-name-dd{
        display: block !important;
       }

       .user-menu-divider1{
          display: block !important;
       }
      
      #loginbtn1{
        display : none !important;
      }

      #loginbtn2{
        display : block !important;
        width: 30%;
      }
    }

    @media (max-width: 700px) {
      #navbarSearch {
        display: none !important;
      }

      #navbarSearch2 {
        display: block !important;
        width: 100%;
      }

      #loginbtn2{
        margin-top: 15px;
      }
    }

    @media (max-width: 540px) {
      #loginbtn1 {
        display: none !important;
      }

      #loginbtn2 {
        display: block !important;
      }
    }

    @media (max-width: 500px) {
      button.navbar-toggler {
        height: 45px;
        width: 50px;
        top: 18px !important;
      }

      .navbar-toggler-icon {
        width: 0.9em;
        height: 1em;
        margin-left: -2px;
      }

      .navbar-toggler-icon {
        display: inline-block;
        width: 0.9em;
        height: 1em;
        margin-left: -2px;
      }

      .navbar-brand {
        font-size: 23px;
      }
    }

    @media (max-width: 400px) {
      .logoicon {
        display: none;
      }
    }

    @media (max-width: 370px) {
      .navbar .container {
        padding: 0;
      }
    }

    .nav-link {
      color: var(--light) !important;
      margin-left: 20px;
      font-weight: 500;
      transition: all 0.3s;
      position: relative;
    }

    .nav-link:hover,
    .nav-link.active {
      color: var(--lighter) !important;
    }

    .nav-link::after {
      content: '';
      position: absolute;
      bottom: -5px;
      left: 0;
      width: 0;
      height: 2px;
      background: var(--primary);
      transition: width 0.3s;
    }

    .nav-link:hover::after,
    .nav-link.active::after {
      width: 100%;
    }

    #signupbtn {
      width: 110px;
    }


    .user-menu {
      display: flex;
      align-items: center;
      gap: 15px;
      position: absolute;
      right: 20px;
      top: 20px;
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

    .dropdown-menu {
      background: rgba(30, 30, 46, 0.9);
      backdrop-filter: blur(10px);
      border: 1px solid rgba(255, 255, 255, 0.1);
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    }

    .dropdown-item {
      color: var(--lighter);
      padding: 8px 15px;
    }

    .dropdown-item:hover {
      background: rgba(225, 48, 108, 0.2);
      color: var(--lighter);
    }

    .dropdown-divider {
      border-color: rgba(255, 255, 255, 0.1);
    }

    @media (max-width: 768px) {

      .user-menu {
        gap: 10px;
      }

      .user-name {
        display: none;
      }
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

ul.navbar-nav{
    margin-left: 4vw;
}


    </style>
    <script>
  const isLoggedIn = <?= isset($_SESSION['username']) ? 'true' : 'false' ?>;
</script>

</head>
<body>
    <nav class="navbar userheader navbar-expand-xl navbar-dark">
    <div class="container">
      <a class="navbar-brand" href="home-page.php">
        <i class="bi bi-music-note-beamed logoicon"></i>SOUND Group
      </a>
      
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item"><a class="nav-link" onclick="navigateTo('home')" data-page="home" >Home</a></li>
          <li class="nav-item"><a class="nav-link active songslink" onclick="navigateTo('songs')" data-page="songs" >Songs</a></li>
          <li class="nav-item"><a class="nav-link" onclick="navigateTo('artists')" data-page="artists" >Artists</a></li>
          <li class="nav-item"><a class="nav-link" onclick="navigateTo('videos')" data-page="videos" >Videos</a></li>
          <li class="nav-item"><a class="nav-link" onclick="navigateTo('albums')" data-page="albums" >Albums</a></li>
          <li class="nav-item"><a class="nav-link" onclick="navigateTo('favorites')" data-page="favorites" >Favourites</a></li>
        </ul>

        <?php if(isset($_SESSION['username'])): ?>
                <!-- Show nothing here when logged in -->
            <?php else: ?>
        <button class="btn loginbtncolor" id="loginbtn2" data-bs-toggle="modal" data-bs-target="#loginModal" >Login</button>
        <button class="btn loginbtnoutline" id="signupbtn" data-bs-toggle="modal" data-bs-target="#signupModal">Sign
          Up</button>
          <?php endif; ?>
      </div>

      <?php if(isset($_SESSION['username'])): ?>
            <!-- Hide login button when logged in -->
        <?php else: ?>
      <button class="btn loginbtncolor" id="loginbtn1" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
          <?php endif; ?>

      <button class="navbar-toggler navbar-toggler-admin" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
    </div>
    </div>


    <div class="user-menu userprofile-menu">
  <div class="dropdown">
    <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
      <div class="user-avatar <?php echo isset($_SESSION['username']) ? '' : 'guest'; ?>">
        <?php 
          if(isset($_SESSION['username'])) {
            // First letter of username for logged-in users
            echo strtoupper(substr($_SESSION['username'], 0, 1)); 
          } else {
            // 'G' for Guest users
            echo 'G';
          }
        ?>
      </div>
      <span class="user-name ms-2">
        <?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Guest'; ?>
      </span>
    </a>
    <ul class="dropdown-menu dropdown-menu-end userdropdown" aria-labelledby="userDropdown">
      <?php if(isset($_SESSION['username'])): ?>
        <!-- Logged-in user menu -->
         <span class="user-name-dd ms-2">
        <?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Guest'; ?>
      </span>
      <li><hr class="dropdown-divider user-menu-divider1"></li>
      <li><a class="dropdown-item" href="../Profile_Pages/contact.php" onclick="navigateTo('contact')" data-page="contact" ><i class="bi bi-envelope-fill me-2"></i> Contact</a></li>
      <li><hr class="dropdown-divider user-menu-divider2"></li>
        <li><a class="dropdown-item" href="verification/logout.php"><i class="bi bi-box-arrow-right me-2"></i> Sign out</a></li>
      <?php else: ?>
        <!-- Guest user menu -->
        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#loginModal"><i class="bi bi-box-arrow-in-right me-2"></i> Login</a></li>
        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#signupModal"><i class="bi bi-person-plus me-2"></i> Sign Up</a></li>
      <?php endif; ?>
    </ul>
  </div>
</div>


<div class="user-menu user-menu-admin d-none">
  <div class="dropdown">
    <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
      <div class="user-avatar <?php echo  'guest'; ?>">
        <?php 
            echo 'A';
        ?>
      </div>
      <span class="user-name user-name-admin ms-2">
        <?php echo  'Admin'; ?>
      </span>
    </a>
    <ul class="dropdown-menu dropdown-menu-end profile-dropdown" aria-labelledby="userDropdown">
        <!-- Logged-in user menu -->
        <li><a class="dropdown-item" href="logout.php"><i class="bi bi-box-arrow-right me-2"></i> Sign out</a></li>
    </ul>
  </div>
</div>
  </nav>
  <script>


  document.addEventListener("DOMContentLoaded", function () {
    const pageMap = {
  'songs-page.php': 'songs',
  'song.php': 'songs',
  'videos-page.php': 'videos',
  'video.php': 'videos',
  'albums-page.php': 'albums',
  'album.php': 'albums',
  'artists-page.php': 'artists',
  'artist.php': 'artists',
  'search-page.php': 'search',
  'home-page.php': 'home',
  'favorites.php': 'favorites',
  'contact.php': 'contact'
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
});
  </script>
</body>
</html>