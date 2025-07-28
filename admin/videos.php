<?php
include 'connection.php';

session_start();

if(!isset($_SESSION['role']) && $_SESSION['role'] != "admin"){
    header('Location: ../user/Pages/verification/logout.php');
}

if (isset($_GET['success'])) {
    echo '<div class="alert alert-success">' . htmlspecialchars($_GET['success']) . '</div>';
}
if (isset($_GET['error'])) {
    echo '<div class="alert alert-danger">' . htmlspecialchars($_GET['error']) . '</div>';
}

$sql_artists = "SELECT name FROM artists";
$artist_results = mysqli_query($con, $sql_artists);

$sql_albums = "SELECT title FROM albums";
$album_results = mysqli_query($con, $sql_albums);

$sqlvideo = "SELECT s.*, a.image as artist_image 
            FROM videos s 
            LEFT JOIN artists a ON s.artist = a.name";
$results = mysqli_query($con, $sqlvideo);
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <title>Videos Management | SOUND Group</title>
  <link rel="icon" type="image/png" href="uploads/icon/favicon.png">
    <?php
    include 'head-css.php'
    ?>

    <style>

.alert {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 9999;
    padding: 15px;
    border-radius: 8px;
    animation: slideIn 0.5s forwards, fadeOut 0.5s 3s forwards;
}

.alert-success {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.alert-danger {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

@keyframes slideIn {
    from { transform: translateX(100%); }
    to { transform: translateX(0); }
}

@keyframes fadeOut {
    from { opacity: 1; }
    to { opacity: 0; }
}



        
        .card-body {
            padding: 0;
        }
        
        /* Search bar */
        .search-bar {
            position: relative;
            flex: 1;
            max-width: 350px;
        }
        
        .search-bar i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            z-index: 1;
        }
        
        .search-bar .form-control {
            padding-left: 40px;
            border-radius: 30px;
            background: #f8f9fa;
            border: 1px solid #eaeaea;
        }
        
        /* Table styling */
        .table-container {
            overflow-x: auto;
        }
        
        .table {
            margin-bottom: 0;
            border-collapse: separate;
            border-spacing: 0;
            width: 100%;
        }
        
        .table thead {
            position: sticky;
            top: 0;
            z-index: 10;
                background: rgba(30, 30, 46, 0.9);
        }
        
        .table thead th {
            background: rgba(30, 30, 46, 0.9);
            color: var(--light);
            font-weight: 600;
            border-top: none;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding: 15px 20px;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .table tbody td {
            padding: 15px 20px;
            vertical-align: middle;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 0.95rem;
            background: rgba(40, 40, 60, 0.5);
            color: #bcbcbc !important;
        }
        
        .table tbody tr {
            transition: all 0.2s ease;
        }
        
        .table tbody tr:hover {
            background-color: rgba(64, 93, 230, 0.1);
            transform: translateY(-1px);
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        
        .table tbody tr:last-child td {
            border-bottom: none;
        }
        
        /* Video info styling */
        .video-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .video-thumb {
            width: 80px;
            height: 45px;
            border-radius: 6px;
            overflow: hidden;
            position: relative;
            flex-shrink: 0;
        }
        
        .video-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .video-thumb .play-icon {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            background: rgba(0,0,0,0.5);
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s;
        }
        
        .video-thumb:hover .play-icon {
            opacity: 1;
        }
        
        .video-details {
            flex: 1;
        }
        
        .video-title {
            font-weight: 600;
            margin-bottom: 3px;
            color: var(--light);
        }
        
        .video-meta {
            font-size: 0.85rem;
            color: #6c757d;
        }
        
        /* Status badges */
        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
            display: inline-block;
        }
        
        .status-active {
            background: rgba(64, 93, 230, 0.1);
            color: var(--primary);
        }
        
        .status-draft {
            background: rgba(255, 193, 7, 0.1);
            color: #c79100;
        }
        
        .status-pending {
            background: rgba(108, 117, 125, 0.1);
            color: #6c757d;
        }
        
        /* Action buttons */
        .action-buttons {
            display: flex;
            gap: 8px;
        }
        
        .action-buttons .btn {
            width: 34px;
            height: 34px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            border-radius: 8px;
        }
        
        /* Views count */
        .views-count {
            font-weight: 600;
            color: #495057;
        }





        .modal-header {
            background: linear-gradient(45deg, var(--primary), var(--secondary));
            color: white;
            border-radius: 0 !important;
        }
        
        .modal-title {
            font-weight: 600;
        }
        
        .modal-footer {
            border-top: 1px solid #eaeaea;
        }
        
        /* Form styling */
        .form-label {
            font-weight: 500;
            color: #495057;
        }
        
        .form-control, .form-select {
            border-radius: 8px;
            border: 1px solid rgba(255,255,255,0.1);
            padding: 10px 15px;
            background: rgba(30, 30, 46, 0.5);
            color: var(--light);
        }
        
        .form-control:focus, .form-select:focus {
            background: rgba(30, 30, 46, 0.7) !important;
            border-color: var(--primary);
            box-shadow: 0 0 0 0.25rem rgba(64, 93, 230, 0.2);
            color: var(--light);
        }
        
        /* Preview container */
        .preview-container {
            border: 2px dashed #dee2e6;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            margin-bottom: 20px;
            background-color: #f8f9fa;
        }
        
        .preview-container img {
            max-width: 100%;
            max-height: 200px;
            margin-bottom: 15px;
        }
        
        .preview-container .bi {
            font-size: 3rem;
            color: #6c757d;
            margin-bottom: 10px;
        }
        
        .preview-container p {
            margin-bottom: 0;
            color: #6c757d;
        }



        ul.dropdown-menu.dropdown-menu-end.profile-dropdown {
    top: -7.5rem !important;
    right: -2rem !important;
}


.modal-content {
    background-color: #121212; /* Dark background */
    color: #b4b4b4; /* Default text color */
  }

  .form-label,
  .form-control::placeholder,
  .form-select,
  .form-select option,
  textarea::placeholder {
    color: #b4b4b4 !important;
  }

  .form-control,
  .form-select,
  textarea {
    background-color: #1e1e1e;
    border: 1px solid #444;
    color: #b4b4b4;
  }

  .form-control:focus,
  .form-select:focus,
  textarea:focus {
    border-color: #777;
    background-color: #2a2a2a;
    color: #b4b4b4;
  }




    </style>
</head>
<body>

<?php
  include 'admin-header.php'
  ?>


    <div id="wrapper">
        <div id="sidebar">
            <div class="sidebar-header">
                <h3><i class="bi bi-music-note-beamed"></i> <span>SOUNDGroup</span></h3>
            </div>
            
            <ul class="nav flex-column mt-4">
                <li class="nav-item">
                    <a class="nav-link dashboardlink " href="dashboard.php" data-page="dashboard">
                        <i class="bi bi-speedometer2"></i> <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="users.php" data-page="users">
                        <i class="bi bi-people"></i> <span>Users</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="artists.php" data-page="artists">
                        <i class="bi bi-mic"></i> <span>Artists</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="songs.php" data-page="songs">
                        <i class="bi bi-music-note-list"></i> <span>Songs</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="albums.php" data-page="albums">
                        <i class="bi bi-collection-play"></i> <span>Albums</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="videos.php" data-page="videos">
                        <i class="bi bi-camera-video"></i> <span>Videos</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="reviews.php" data-page="reviews">
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
        
        <!-- Main Content -->
        <div id="content">
            <!-- Topbar -->
            <div class="topbar">
                <div>
                    <h2 class="page-title">Videos</h2>
                    <p class="text-muted mb-0">Manage music videos</p>
                </div>
                
                <div class="user-menu admin-usermenu" onclick='toggledropdown()'>
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="user-avatar <?php echo  'guest'; ?>">
                        <?php 
                            echo 'A';
                        ?>
                    </div>
                    <span class="user-name ms-2">
                        <?php echo  'Admin'; ?>
                    </span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end profile-dropdown" aria-labelledby="userDropdown">
                        <!-- Logged-in user menu -->
                        <li><a class="dropdown-item" href="logout.php"><i class="bi bi-box-arrow-right me-2"></i> Sign out</a></li>
                    </ul>
                </div>
                </div>
            </div>
            
            <!-- Videos Content -->
            <div class="page-section active" id="videos">
                <div class="card">
                    <div class="card-header">
                        <h5>Video Management</h5>
                        <div class="d-flex">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadVideoModal">Upload New Video</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-container">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Video</th>
                                        <th>Artist</th>
                                        <th>Album</th>
                                        <th>Language</th>
                                        <th>Added</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        if (mysqli_num_rows($results) > 0) {
                                            while ($rows = mysqli_fetch_assoc($results)) {
                                                echo '<tr  data-id="'.$rows['id'].'"
              data-title="'.htmlspecialchars($rows['title']).'"
      data-artist="'.htmlspecialchars($rows['artist']).'"
      data-artist-image="uploads/artists/'.htmlspecialchars($rows['artist_image']).'"
      data-thumb="uploads/videoscover/'.htmlspecialchars($rows['image']).'"
      data-album="'.htmlspecialchars($rows['album']).'"
      data-language="'.htmlspecialchars($rows['language']).'"
      data-date="'.substr($rows['date_added'], 0, 10).'"
      data-status="'.$rows['status'].'"
      data-genre="'.$rows['genre'].'"
      data-year="'.$rows['year'].'"
      data-description="'.htmlspecialchars($rows['description']).'"
      data-videolink="'.htmlspecialchars($rows['link']).'">
                                        <td>
                                            <div class="video-info">
                                                <div class="video-thumb">
                                                    <img src="uploads/videoscover/' . htmlspecialchars($rows['image']) . '" alt="' . $rows['title'] . '">
                                                </div>
                                                <div class="video-details">
                                                    <div class="video-title">' . $rows['title'] . '</div>
                                                    <div class="video-meta">' . $rows['genre'] . ' • ' . $rows['year'] . '</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="uploads/artists/' . htmlspecialchars($rows['artist_image']) . '" 
                                                     alt="' . $rows['artist'] . '" 
                                                     class="rounded-circle me-2" 
                                                     style="width: 30px; height: 30px; object-fit: cover;">
                                                <span>' . $rows['artist'] . '</span>
                                            </div>
                                        </td>
                                        <td>' . htmlspecialchars($rows['album']) . '</td>
                                                    <td>' . htmlspecialchars($rows['language']) . '</td>
                                                    <td>' . substr($rows['date_added'], 0, 10) . '</td>
                                        <td><span class="status-badge status-active">' . $rows['status'] . '</span></td>
                                        <td>
                                            <div class="action-buttons">
                                                <button class="btn btn-outline view-video" title="View">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                                <button class="btn btn-primary edit-video" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <a href="crud/delete-video.php?id=' . $rows['id'] . '" onclick="return confirm(\'Are you sure you want to delete this video?\')">
                                                                <button class="btn btn-outline" title="Delete">
                                                                    <i class="bi bi-trash"></i>
                                                                </button>
                                                            </a>
                                            </div>
                                        </td>
                                    </tr>';
                                   }
                                  }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Upload Video Modal -->
<div class="modal fade" id="uploadVideoModal" tabindex="-1" aria-labelledby="uploadVideoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadVideoModalLabel">Upload New Video</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="uploadVideoForm" action="crud/add-video.php" method="post" enctype="multipart/form-data" novalidate>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="videoTitle" class="form-label">Video Title *</label>
                            <input type="text" class="form-control" id="videoTitle" name="title" 
                                   placeholder="Enter video title" 
                                   pattern="[a-zA-Z0-9\s]*"
                                   title="Only letters, numbers and spaces allowed"
                                   required>
                            <div class="invalid-feedback">Please enter a valid video title (no special characters)</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="artist" class="form-label">Artist *</label>
                            <select class="form-select" name="artist" id="artist" required>
                                <option value="" disabled selected>Select artist</option>
                                <?php
                                mysqli_data_seek($artist_results, 0);
                                if (mysqli_num_rows($artist_results) > 0) {
                                    while ($artist = mysqli_fetch_assoc($artist_results)) {
                                        echo '<option value="'.htmlspecialchars($artist['name']).'">'.htmlspecialchars($artist['name']).'</option>';
                                    }
                                } else {
                                    echo '<option disabled>No artists found</option>';
                                }
                                ?>
                            </select>
                            <div class="invalid-feedback">Please select an artist</div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="videoAlbum" class="form-label">Album</label>
                            <select class="form-select" name="album" id="album">
                                <option value="" selected>Select album (optional)</option>
                                <?php
                                mysqli_data_seek($album_results, 0);
                                if (mysqli_num_rows($album_results) > 0) {
                                    while ($album = mysqli_fetch_assoc($album_results)) {
                                        echo '<option value="'.htmlspecialchars($album['title']).'">'.htmlspecialchars($album['title']).'</option>';
                                    }
                                } else {
                                    echo '<option disabled>No albums found</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="videoGenre" class="form-label">Genre *</label>
                            <select class="form-select" name="genre" id="videoGenre" required>
                                <option value="" disabled selected>Select genre</option>
                                <option>Pop</option>
                                <option>Electronic</option>
                                <option>Hip-Hop</option>
                                <option>Rock</option>
                                <option>R&B</option>
                                <option>Jazz</option>
                                <option>Classical</option>
                            </select>
                            <div class="invalid-feedback">Please select a genre</div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="videoLanguage" class="form-label">Language</label>
                            <select class="form-select" name="language" id="videoLanguage">
                                <option value="" selected>Select language</option>
                                <option>English</option>
                                <option>Hindi</option>
                                <option>Urdu</option>
                                <option>Spanish</option>
                                <option>French</option>
                                <option>German</option>
                                <option>Italian</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="year" class="form-label">Release Year *</label>
                            <input type="number" class="form-control" name="year" id="year" 
                                   placeholder="1995" min="1900" max="2025" required>
                            <div class="invalid-feedback">Please enter a valid year (1900-2025)</div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="newflag" class="form-label">New Icon</label>
                            <select class="form-select" name="newflag" id="newflag" required>
                                <option value="" disabled selected>Select Option</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                            <div class="invalid-feedback">Please select an option</div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" name="description" id="description" rows="3" 
                                  placeholder="Enter video description"></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="coverImage" class="form-label">Cover Image *</label>
                        <input type="file" name="videocover" class="form-control" id="coverImage" 
                               accept="image/*" required>
                        <div class="invalid-feedback">Please upload a cover image (JPG/PNG, max 2MB)</div>
                    </div>
                    
                    <div class="mb-3" id="youtubeUrlSection">
                        <label for="youtubeUrl" class="form-label">YouTube URL *</label>
                        <input type="url" class="form-control" name="videoLink" id="youtubeUrl" 
                               placeholder="https://www.youtube.com/watch?v=..." required>
                        <div class="invalid-feedback">Please enter a valid YouTube URL</div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Upload Video</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


    <div class="modal fade" id="viewVideoModal" tabindex="-1" aria-labelledby="viewVideoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewVideoModalLabel">Video Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex align-items-center mb-4">
                    <div class="video-thumb me-4" style="width: 200px; height: 120px;">
                        <img src="" id="viewVideoThumb" alt="Video Thumbnail" style="width: 100%; height: 100%; object-fit: cover;">
                        <div class="play-icon">
                            <i class="bi bi-play-fill"></i>
                        </div>
                    </div>
                    <div>
                        <h3 id="viewVideoTitle" class="video-detail-title">Video Title</h3>
                        <div class="d-flex align-items-center mt-2">
                            <img src="" id="viewArtistImage" alt="Artist" class="rounded-circle me-2" style="width: 40px; height: 40px;">
                            <span id="viewArtistName">Artist Name</span>
                        </div>
                        <div class="mt-3">
                            <span class="status-badge" id="viewVideoStatus">Published</span>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="user-detail-label">Genre</div>
                        <div class="user-detail-value" id="viewVideoGenre">Rock</div>
                        
                        <div class="user-detail-label">Release Year</div>
                        <div class="user-detail-value" id="viewVideoYear">2013</div>
                        
                        <div class="user-detail-label">Added Date</div>
                        <div class="user-detail-value" id="viewVideoAdded">Jun 15, 2023</div>
                    </div>
                    <div class="col-md-6">
                        <div class="user-detail-label">Album</div>
                        <div class="user-detail-value" id="viewVideoAlbum">AM</div>
                        
                        <div class="user-detail-label">Language</div>
                        <div class="user-detail-value" id="viewVideoLanguage">English</div>
                    </div>
                </div>
                
                <div class="user-detail-label mt-3">Description</div>
                <div class="user-detail-value" id="viewVideoDescription">
                    The official music video for this song has become one of the most popular music videos on YouTube. 
                    Directed by a renowned filmmaker, the video features stunning visuals and a compelling storyline.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<!-- Edit Video Modal -->
<div class="modal fade" id="editVideoModal" tabindex="-1" aria-labelledby="editVideoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editVideoModalLabel">Edit Video</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editVideoForm" action="crud/update-video.php" method="post" enctype="multipart/form-data" novalidate>
                    <input type="hidden" name="video_id" id="editVideoId">
                    <input type="hidden" name="existing_video_img" id="editVideoeximg">
                    
                    <div class="d-flex align-items-center mb-4">
                        <div class="video-thumb me-3" style="width: 100px; height: 60px;">
                            <img src="" id="editVideoThumb" alt="Video Thumbnail" style="width: 100%; height: 100%; object-fit: cover;">
                            <div class="play-icon">
                                <i class="bi bi-play-fill"></i>
                            </div>
                        </div>
                        <div>
                            <h4 id="editVideoTitle">Video Title</h4>
                            <div class="video-meta" id="editVideoMeta">Rock • 2013</div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="editVideoTitleInput" class="form-label">Video Title *</label>
                            <input type="text" class="form-control" name="title" id="editVideoTitleInput" 
                                   placeholder="Enter video title" 
                                   pattern="[a-zA-Z0-9\s]*"
                                   title="Only letters, numbers and spaces allowed"
                                   required>
                            <div class="invalid-feedback">Please enter a valid video title (no special characters)</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="editVideoArtist" class="form-label">Artist *</label>
                            <select class="form-select" name="artist" id="editVideoArtist" required>
                                <option value="" disabled>Select artist</option>
                                <?php
                                mysqli_data_seek($artist_results, 0);
                                while ($artist = mysqli_fetch_assoc($artist_results)) {
                                    echo '<option value="'.htmlspecialchars($artist['name']).'">'.htmlspecialchars($artist['name']).'</option>';
                                }
                                ?>
                            </select>
                            <div class="invalid-feedback">Please select an artist</div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="editVideoAlbum" class="form-label">Album</label>
                            <select class="form-select" name="album" id="editVideoAlbum">
                                <option value="">Select album (optional)</option>
                                <?php
                                mysqli_data_seek($album_results, 0);
                                while ($album = mysqli_fetch_assoc($album_results)) {
                                    echo '<option value="'.htmlspecialchars($album['title']).'">'.htmlspecialchars($album['title']).'</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="editVideoGenre" class="form-label">Genre *</label>
                            <select class="form-select" name="genre" id="editVideoGenre" required>
                                <option value="" disabled>Select genre</option>
                                <option>Pop</option>
                                <option>Electronic</option>
                                <option>Hip-Hop</option>
                                <option>Rock</option>
                                <option>R&B</option>
                                <option>Jazz</option>
                                <option>Classical</option>
                            </select>
                            <div class="invalid-feedback">Please select a genre</div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="editVideoLanguage" class="form-label">Language</label>
                            <select class="form-select" name="language" id="editVideoLanguage">
                                <option value="" disabled>Select language</option>
                                <option>English</option>
                                <option>Hindi</option>
                                <option>Urdu</option>
                                <option>Spanish</option>
                                <option>French</option>
                                <option>German</option>
                                <option>Italian</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="editVideoYear" class="form-label">Release Year *</label>
                            <input type="number" class="form-control" name="year" id="editVideoYear" 
                                   placeholder="1995" min="1900" max="2025" required>
                            <div class="invalid-feedback">Please enter a valid year (1900-2025)</div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="editVideoDescription" class="form-label">Description</label>
                        <textarea class="form-control" name="description" id="editVideoDescription" rows="3" 
                                  placeholder="Enter video description"></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="editVideoStatus" class="form-label">Status *</label>
                        <select class="form-select" name="status" id="editVideoStatus" required>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                            <option value="Pending">Pending</option>
                        </select>
                        <div class="invalid-feedback">Please select a status</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="editVideoCover" class="form-label">Change Cover Image</label>
                        <input type="file" class="form-control" name="videocover" id="editVideoCover" 
                               accept="image/*">
                        <small class="text-muted">Leave blank to keep current image</small>
                        <div class="invalid-feedback">Please upload a valid image (JPG/PNG, max 2MB)</div>
                    </div>
                    
                    <div class="mb-3" id="editYoutubeUrlSection">
                        <label for="editYoutubeUrl" class="form-label">YouTube URL *</label>
                        <input type="url" class="form-control" name="videoLink" id="editYoutubeUrl" 
                               placeholder="https://www.youtube.com/watch?v=..." required>
                        <div class="invalid-feedback">Please enter a valid YouTube URL</div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
    
    
    
    
    <?php
    include 'js-scripts.php';
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
function toggledropdown() {
    const dropdown = document.querySelector('.dropdown-menu');
    if (dropdown.style.display === 'block') {
        dropdown.style.display = 'none';
    } else {
        dropdown.style.display = 'block';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // Event delegation for view buttons
    document.addEventListener('click', function(e) {
        if (e.target.closest('.view-video')) {
            const row = e.target.closest('tr');
            const data = row.dataset;
            
            // Populate view modal
            document.getElementById('viewVideoTitle').textContent = data.title;
            document.getElementById('viewArtistName').textContent = data.artist;
            document.getElementById('viewArtistImage').src = data.artistImage;
            document.getElementById('viewVideoThumb').src = data.thumb;
            document.getElementById('viewVideoAdded').textContent = data.date;
            document.getElementById('viewVideoStatus').textContent = data.status;
            document.getElementById('viewVideoGenre').textContent = data.genre;
            document.getElementById('viewVideoYear').textContent = data.year;
            document.getElementById('viewVideoAlbum').textContent = data.album;
            document.getElementById('viewVideoLanguage').textContent = data.language;
            document.getElementById('viewVideoDescription').textContent = data.description;
            
            // Show view modal
            new bootstrap.Modal(document.getElementById('viewVideoModal')).show();
        }
        
        // Event delegation for edit buttons
        if (e.target.closest('.edit-video')) {
            const row = e.target.closest('tr');
            const data = row.dataset;
            
            // Populate edit modal with row data
            document.getElementById('editVideoId').value = data.id;
            document.getElementById('editVideoTitle').textContent = data.title;
            document.getElementById('editVideoTitleInput').value = data.title;
            document.getElementById('editVideoThumb').src = data.thumb;
            document.getElementById('editVideoMeta').textContent = `${data.genre} • ${data.year}`;
            const videoId = data.id;
            const videoimg = data.thumb.replace(/^.*[\\/]/, "");
            
            // Set select values PROPERLY
            document.getElementById('editVideoId').value = videoId;
            document.getElementById('editVideoeximg').value = videoimg;
            
            // Set artist
            const artistSelect = document.getElementById('editVideoArtist');
            for (let i = 0; i < artistSelect.options.length; i++) {
                if (artistSelect.options[i].value === data.artist) {
                    artistSelect.selectedIndex = i;
                    break;
                }
            }
            
            // Set status
            const statusSelect = document.getElementById('editVideoStatus');
            for (let i = 0; i < statusSelect.options.length; i++) {
                if (statusSelect.options[i].value === data.status) {
                    statusSelect.selectedIndex = i;
                    break;
                }
            }

            // Set album
            const albumSelect = document.getElementById('editVideoAlbum');
            for (let i = 0; i < albumSelect.options.length; i++) {
                if (albumSelect.options[i].value === data.album) {
                    albumSelect.selectedIndex = i;
                    break;
                }
            }
            
            // Set other fields
            document.getElementById('editVideoGenre').value = data.genre;
            document.getElementById('editVideoLanguage').value = data.language;
            document.getElementById('editVideoYear').value = data.year;
            document.getElementById('editVideoDescription').value = data.description;
            
            // Set YouTube URL from data attribute
            document.getElementById('editYoutubeUrl').value = row.dataset.videolink || '';
            
            // Show edit modal
            new bootstrap.Modal(document.getElementById('editVideoModal')).show();
        }
    });

    // Handle cover image preview in edit modal
    document.getElementById('editVideoCover').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('editVideoThumb').src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    });

    // Add Video Form Validation
    document.getElementById('uploadVideoForm').addEventListener('submit', function(e) {
        e.preventDefault();
        let isValid = true;

        // Reset validation
        this.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        this.querySelectorAll('.invalid-feedback').forEach(el => el.style.display = 'none');

        // Validate required fields
        const requiredFields = [
            { id: 'videoTitle', message: 'Video title is required' },
            { id: 'artist', message: 'Artist is required' },
            { id: 'videoGenre', message: 'Genre is required' },
            { id: 'year', message: 'Release year is required' },
            { id: 'newflag', message: 'New flag is required' },
            { id: 'youtubeUrl', message: 'YouTube URL is required' }
        ];

        requiredFields.forEach(field => {
            const element = document.getElementById(field.id);
            if (!element.value) {
                element.classList.add('is-invalid');
                element.nextElementSibling.textContent = field.message;
                element.nextElementSibling.style.display = 'block';
                isValid = false;
            }
        });

        // Validate title for special characters
        const videoTitle = document.getElementById('videoTitle');
        if (/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/.test(videoTitle.value)) {
            videoTitle.classList.add('is-invalid');
            videoTitle.nextElementSibling.textContent = 'Special characters are not allowed';
            videoTitle.nextElementSibling.style.display = 'block';
            isValid = false;
        }

        // Validate year range
        const year = document.getElementById('year');
        if (year.value && (year.value < 1900 || year.value > 2025)) {
            year.classList.add('is-invalid');
            year.nextElementSibling.textContent = 'Please enter a year between 1900-2025';
            year.nextElementSibling.style.display = 'block';
            isValid = false;
        }

        // Validate YouTube URL
        const youtubeUrl = document.getElementById('youtubeUrl');
        if (youtubeUrl.value && !youtubeUrl.value.match(/^(https?\:\/\/)?(www\.)?(youtube\.com|youtu\.?be)\/.+$/)) {
            youtubeUrl.classList.add('is-invalid');
            youtubeUrl.nextElementSibling.textContent = 'Please enter a valid YouTube URL';
            youtubeUrl.nextElementSibling.style.display = 'block';
            isValid = false;
        }

        // Validate cover image
        const coverImage = document.getElementById('coverImage');
        if (!coverImage.files.length) {
            coverImage.classList.add('is-invalid');
            coverImage.nextElementSibling.style.display = 'block';
            isValid = false;
        } else {
            const file = coverImage.files[0];
            const validTypes = ['image/jpeg', 'image/png'];
            const maxSize = 2 * 1024 * 1024; // 2MB
            
            if (!validTypes.includes(file.type)) {
                coverImage.classList.add('is-invalid');
                coverImage.nextElementSibling.textContent = 'Only JPG/PNG images allowed';
                coverImage.nextElementSibling.style.display = 'block';
                isValid = false;
            } else if (file.size > maxSize) {
                coverImage.classList.add('is-invalid');
                coverImage.nextElementSibling.textContent = 'Image must be less than 2MB';
                coverImage.nextElementSibling.style.display = 'block';
                isValid = false;
            }
        }

        if (isValid) {
            // Create FormData object to handle file upload
            const formData = new FormData(this);
            
            // Submit form via AJAX for better feedback
            fetch(this.action, {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (response.redirected) {
                    window.location.href = response.url;
                } else {
                    return response.text();
                }
            })
            .then(data => {
                if (data) {
                    // Handle response if not redirected
                    window.location.href = 'videos.php?success=Video+added+successfully';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error submitting form');
            });
        } else {
            // Focus on first invalid field
            this.querySelector('.is-invalid').focus();
        }
    });

    // Edit Video Form Validation
    document.getElementById('editVideoForm').addEventListener('submit', function(e) {
        e.preventDefault();
        let isValid = true;

        // Reset validation
        this.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        this.querySelectorAll('.invalid-feedback').forEach(el => el.style.display = 'none');

        // Validate required fields
        const requiredFields = [
            { id: 'editVideoTitleInput', message: 'Video title is required' },
            { id: 'editVideoArtist', message: 'Artist is required' },
            { id: 'editVideoGenre', message: 'Genre is required' },
            { id: 'editVideoYear', message: 'Release year is required' },
            { id: 'editVideoStatus', message: 'Status is required' },
            { id: 'editYoutubeUrl', message: 'YouTube URL is required' }
        ];

        requiredFields.forEach(field => {
            const element = document.getElementById(field.id);
            if (!element.value) {
                element.classList.add('is-invalid');
                element.nextElementSibling.textContent = field.message;
                element.nextElementSibling.style.display = 'block';
                isValid = false;
            }
        });

        // Validate title for special characters
        const videoTitle = document.getElementById('editVideoTitleInput');
        if (/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/.test(videoTitle.value)) {
            videoTitle.classList.add('is-invalid');
            videoTitle.nextElementSibling.textContent = 'Special characters are not allowed';
            videoTitle.nextElementSibling.style.display = 'block';
            isValid = false;
        }

        // Validate year range
        const year = document.getElementById('editVideoYear');
        if (year.value && (year.value < 1900 || year.value > 2025)) {
            year.classList.add('is-invalid');
            year.nextElementSibling.textContent = 'Please enter a year between 1900-2025';
            year.nextElementSibling.style.display = 'block';
            isValid = false;
        }

        // Validate YouTube URL
        const youtubeUrl = document.getElementById('editYoutubeUrl');
        if (youtubeUrl.value && !youtubeUrl.value.match(/^(https?\:\/\/)?(www\.)?(youtube\.com|youtu\.?be)\/.+$/)) {
            youtubeUrl.classList.add('is-invalid');
            youtubeUrl.nextElementSibling.textContent = 'Please enter a valid YouTube URL';
            youtubeUrl.nextElementSibling.style.display = 'block';
            isValid = false;
        }

        // Validate cover image if new one is uploaded
        const coverImage = document.getElementById('editVideoCover');
        if (coverImage.files.length) {
            const file = coverImage.files[0];
            const validTypes = ['image/jpeg', 'image/png'];
            const maxSize = 2 * 1024 * 1024; // 2MB
            
            if (!validTypes.includes(file.type)) {
                coverImage.classList.add('is-invalid');
                coverImage.nextElementSibling.textContent = 'Only JPG/PNG images allowed';
                coverImage.nextElementSibling.style.display = 'block';
                isValid = false;
            } else if (file.size > maxSize) {
                coverImage.classList.add('is-invalid');
                coverImage.nextElementSibling.textContent = 'Image must be less than 2MB';
                coverImage.nextElementSibling.style.display = 'block';
                isValid = false;
            }
        }

        if (isValid) {
            // Create FormData object to handle file upload
            const formData = new FormData(this);
            
            // Submit form via AJAX for better feedback
            fetch(this.action, {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (response.redirected) {
                    window.location.href = response.url;
                } else {
                    return response.text();
                }
            })
            .then(data => {
                if (data) {
                    // Handle response if not redirected
                    window.location.href = 'videos.php?success=Video+updated+successfully';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error submitting form');
            });
        } else {
            // Focus on first invalid field
            this.querySelector('.is-invalid').focus();
        }
    });

    // Real-time validation for title fields
    document.getElementById('videoTitle').addEventListener('input', function() {
        this.value = this.value.replace(/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/g, '');
    });

    document.getElementById('editVideoTitleInput').addEventListener('input', function() {
        this.value = this.value.replace(/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/g, '');
    });

    // Thumbnail preview for upload form
    document.getElementById('coverImage').addEventListener('change', function(e) {
        const preview = document.getElementById('thumbnailPreview');
        const file = e.target.files[0];
        
        if (file) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                if (!preview) {
                    // Create preview container if it doesn't exist
                    const newPreview = document.createElement('div');
                    newPreview.id = 'thumbnailPreview';
                    newPreview.innerHTML = `<img src="${e.target.result}" alt="Thumbnail Preview" class="img-fluid">`;
                    e.target.insertAdjacentElement('afterend', newPreview);
                } else {
                    preview.innerHTML = `<img src="${e.target.result}" alt="Thumbnail Preview" class="img-fluid">`;
                }
            }
            
            reader.readAsDataURL(file);
        }
    });
});

    </script>
</body>
</html>