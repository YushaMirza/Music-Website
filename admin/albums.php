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


$sql = "SELECT * FROM albums";
$results = mysqli_query($con, $sql);

$songs_sql = "SELECT * FROM songs";
$song_results = mysqli_query($con, $songs_sql);

$videos_sql = "SELECT * FROM videos";
$video_results = mysqli_query($con, $videos_sql);

$artists_sql = "SELECT * FROM artists";
$artist_results = mysqli_query($con, $artists_sql);

?>






<!DOCTYPE html>
<html lang="en">
<head>
    <title>Albums Management | SOUND Group</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
        
        
        /* Layout */
        #wrapper {
            display: flex;
            min-height: 100vh;
        }
        
        
        
        /* Main Content */
        #content {
            flex: 1;
            margin-left: var(--sidebar-width);
            padding-top: var(--topbar-height);
            min-height: 100vh;
            background: linear-gradient(180deg, #13131f 0%, #1e1e2e 100%);
        }
        
        .page-section {
            padding: 30px;
            display: none;
        }
        
        .page-section.active {
            display: block;
            animation: fadeIn 0.5s ease;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* Card Styles */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.03);
            margin-bottom: 24px;
            transition: transform 0.3s;
            background: rgba(30, 30, 46, 0.5);
            backdrop-filter: blur(10px);
        }
        
        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }
        
        .card-header {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding: 20px;
            border-radius: 12px 12px 0 0 !important;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: rgba(40, 40, 60, 0.8);
        }
        
        .card-header h5 {
            margin-bottom: 0;
            font-weight: 600;
            display: flex;
            align-items: center;
            color: var(--light);
        }
        
        .card-header h5 i {
            margin-right: 10px;
            font-size: 1.2rem;
            color: var(--primary);
        }
        
        .card-body {
            padding: 25px;
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
        
        /* Album info styling */
        .album-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .album-cover {
            width: 60px;
            height: 60px;
            border-radius: 8px;
            object-fit: cover;
            flex-shrink: 0;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        
        .album-details {
            flex: 1;
        }
        
        .album-title {
            font-weight: 600;
            margin-bottom: 3px;
            color: var(--light);
            font-size: 1.05rem;
        }
        
        .album-artist {
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
        
        .status-inactive {
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
            transition: all 0.2s ease;
            background: rgba(255, 255, 255, 0.1);
            border: none;
        }
        
        .action-buttons .btn:hover {
            transform: translateY(-2px);
            background: var(--primary);
            color: white;
        }
        
        .action-buttons .btn.btn-primary {
            background: rgba(64, 93, 230, 0.2);
            color: var(--primary);
        }
        
        .action-buttons .btn.btn-primary:hover {
            background: var(--primary);
            color: white;
        }
        
        /* Modal styling */
        .modal-backdrop.show {
            opacity: 0.8;
        }
        
        .modal-content {
            border-radius: 15px;
            overflow: hidden;
            background: #2a2a3f;
            color: #e0e0e0;
            border: 1px solid rgba(255,255,255,0.1);
        }
        
        .modal-header {
            background: linear-gradient(45deg, #405de6, #833ab4);
            padding: 15px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .modal-title {
            font-weight: 600;
            font-size: 1.25rem;
        }
        
        .modal-body {
            padding: 20px;
        }
        
        .modal-footer {
            padding: 15px 20px;
            background: rgba(40,40,60,0.8);
            border-top: 1px solid rgba(255,255,255,0.1);
        }
        
        /* Genre tags */
        .genre-container {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 8px;
        }
        
        .genre-badge {
            background: rgba(64, 93, 230, 0.2);
            color: #a5b4fc;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
        }
        
        /* Form styling */
        .form-label {
            font-weight: 500;
            color: #bcbcbc;
            margin-bottom: 8px;
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
        
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }
        
        /* Album details in view modal */
        .album-detail-row {
            display: flex;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .detail-label {
            flex: 0 0 30%;
            font-weight: 500;
            color: #6c757d;
        }
        
        .detail-value {
            flex: 1;
            color: var(--light);
        }
        
        /* Track list styling */
        .track-list {
            margin-top: 20px;
        }
        
        .track-item {
            display: flex;
            align-items: center;
            padding: 10px 15px;
            background: rgba(40, 40, 60, 0.5);
            border-radius: 8px;
            margin-bottom: 8px;
            transition: all 0.2s ease;
        }
        
        .track-item:hover {
            background: rgba(64, 93, 230, 0.1);
        }
        
        .track-number {
            width: 30px;
            text-align: center;
            font-weight: 500;
            color: #6c757d;
        }
        
        .track-title {
            flex: 1;
            font-weight: 500;
        }
        
        .track-duration {
            color: #6c757d;
            font-size: 0.9rem;
        }
        
        /* Responsive adjustments */
        @media (max-width: 992px) {
            #sidebar {
                width: 80px;
                text-align: center;
            }
            
            .sidebar-header h3 span {
                display: none;
            }
            
            .nav-link span {
                display: none;
            }
            
            .nav-link i {
                margin-right: 0;
                font-size: 1.4rem;
            }
            
            #content {
                margin-left: 80px;
            }
            
            .topbar {
                left: 80px;
            }
        }
        
        @media (max-width: 768px) {
            #sidebar {
                transform: translateX(-100%);
            }
            
            #sidebar.active {
                transform: translateX(0);
            }
            
            #content {
                margin-left: 0;
            }
            
            .topbar {
                left: 0;
            }
            
            .card-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
            
            .search-bar {
                max-width: 100%;
                width: 100%;
            }
            
            .form-grid {
                grid-template-columns: 1fr;
            }
        }



        .select2-container {
    z-index: 1060 !important; /* Higher than modal's z-index */
}

.select2-dropdown {
    z-index: 1061 !important;
}




.modal-content {
    background-color: #121212; /* Dark background for contrast */
    color: #b4b4b4;
  }

  /* Input, textarea, and select text + placeholder */
  .form-control,
  .form-select,
  textarea {
    background-color: #1f1f1f;
    color: #b4b4b4;
    border: 1px solid #444;
  }

  .form-control::placeholder,
  textarea::placeholder {
    color: #ccc !important; /* Lighter color for visibility */
    opacity: 1;
  }

  .form-select option {
    color: #b4b4b4;
    background-color: #1f1f1f;
  }

  .form-label {
    color: #b4b4b4;
  }


.dropdown-menu{
                transform: translate3d(-35px, -5px, 0px) !important;
        }


        .select2-container--default .select2-selection--multiple {
            background-color: transparent !important;
        }

        .select2-dropdown {
    background-color: #181818 !important;
        }
        
        

    </style>
</head>
<body>
    <?php
  include 'admin-header.php'
  ?>
    
    <div id="wrapper">
        <!-- Sidebar -->
        <?php
        include 'sidebar.php'
        ?>
        
        <script>
document.addEventListener('DOMContentLoaded', function() {
    // Remove active class from all links
    document.querySelectorAll('.nav-link').forEach(link => {
        link.classList.remove('active');
    });
    
    // Add active class to albums link
    const albumsLink = document.querySelector('.nav-link[data-page="albums"]');
    if (albumsLink) {
        albumsLink.classList.add('active');
    }
});
</script>
        
        <!-- Main Content -->
        <div id="content">
            <!-- Topbar -->
            <div class="topbar mt-4">
                <div>
                    <h2 class="page-title">Albums</h2>
                    <p class="text-muted mb-0">Manage your albums library</p>
                </div>
                
                <div class="user-menu admin-usermenu" onclick='toggledropdown()'>
  <div class="dropdown">
    <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
      <div class="user-avatar <?php echo 'guest'; ?>">
        <?php 
            echo 'A';
        ?>
      </div>
      <span class="user-name ms-2">
        <?php echo 'Admin'; ?>
      </span>
    </a>
    <ul class="dropdown-menu dropdown-menu-end profile-dropdown" aria-labelledby="userDropdown">
        <!-- Logged-in user menu -->
        <li><a class="dropdown-item" href="logout.php"><i class="bi bi-box-arrow-right me-2"></i> Sign out</a></li>
    </ul>
  </div>
</div>
            </div>
            
            <!-- Albums Content -->
            <div class="page-section active" id="albums">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="bi bi-journal-album"></i> Album Management</h5>
                        <div class="d-flex">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAlbumModal">
                                <i class="bi bi-plus-lg me-1"></i> Add New Album
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-container">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Album</th>
                                        <th>Artist</th>
                                        <th>Tracks</th>
                                        <th>Year</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        if (mysqli_num_rows($results) > 0) {
                                            while ($rows = mysqli_fetch_assoc($results)) {
                                                $songCount = count(array_filter(array_map('trim', explode(',', $rows['songs']))));
                                                echo '<tr>
                                                    <td>
                                                        <div class="album-info">
                                                            <img src="uploads/albumscover/' . htmlspecialchars($rows['cover_image']) . '" 
                                                                alt="' . $rows['title'] . '" 
                                                                class="album-cover">
                                                            <div class="album-details">
                                                                <div class="album-title">' . $rows['title'] . '</div>
                                                                <div class="album-meta">
                                                                    <span>' . $rows['artist'] . '</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>' . $rows['artist'] . '</td>
                                                    <td>' . $songCount . '</td>
                                                    <td>' . $rows['release_year'] . '</td>
                                                    <td><span class="status-badge status-active">' . $rows['status'] . '</span></td>
                                                    <td>
                                                        <div class="action-buttons">
                                                            <button class="btn btn-outline view-album" data-bs-toggle="modal" data-bs-target="#viewAlbumModal" title="View" data-title="'. $rows['title'] .'"
                data-artist="'.$rows['artist'].'"
                data-year=" '.$rows['release_year'].'"
                data-desc="'.$rows['description'].'"
                data-image="'.$rows['cover_image'].'"
                data-songs="'.htmlspecialchars($rows['songs']).'">
                                                                <i class="bi bi-eye"></i>
                                                            </button>

                                                            <button class="btn btn-primary edit-album" 
                                                                    data-bs-toggle="modal" 
                                                                    data-bs-target="#editAlbumModal"
                                                                    data-id="'.$rows['id'].'"
                                                                    data-title="'.$rows['title'].'"
                                                                    data-artist="'.$rows['artist'].'"
                                                                    data-year="'.$rows['release_year'].'"
                                                                    data-desc="'.$rows['description'].'"
                                                                    data-status="'.$rows['status'].'"
                                                                    data-image="'.$rows['cover_image'].'"
                                                                    title="Edit">
                                                                <i class="bi bi-pencil"></i>
                                                            </button>
                                                            <a href="crud/delete-album.php?id=' . $rows['id'] . '" onclick="return confirm(\'Are you sure you want to delete this album?\')">
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

    <!-- Add Album Modal -->
<div class="modal fade" id="addAlbumModal" tabindex="-1" aria-labelledby="addAlbumModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addAlbumModalLabel">Add New Album</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addAlbumForm" action="crud/add-album.php" method="post" enctype="multipart/form-data" novalidate>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="albumTitle" class="form-label">Album Title *</label>
                            <input type="text" class="form-control" id="albumTitle" name="title" 
                                   placeholder="Enter album title" 
                                   pattern="[a-zA-Z0-9\s]*"
                                   title="Only letters, numbers and spaces allowed"
                                   required>
                            <div class="invalid-feedback">Please enter a valid album title (no special characters)</div>
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
                            <label for="releaseYear" class="form-label">Release Year *</label>
                            <input type="number" class="form-control" name="year" id="releaseYear" 
                                   min="1900" max="2025" 
                                   placeholder="Enter release year" required>
                            <div class="invalid-feedback">Please enter a valid year (1900-2025)</div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" name="desc" id="description" rows="3" 
                                  placeholder="Enter album description"></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="coverImage" class="form-label">Cover Image *</label>
                        <input type="file" name="albumcover" class="form-control" id="coverImage" 
                               accept="image/*" required>
                        <div class="invalid-feedback">Please upload a cover image (JPG/PNG, max 2MB)</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="songs" class="form-label">Songs in Album</label>
                        <select class="form-select" name="songs[]" id="songs" multiple="multiple">
                            <?php
                            mysqli_data_seek($song_results, 0);
                            if (mysqli_num_rows($song_results) > 0) {
                                while ($songs = mysqli_fetch_assoc($song_results)) {
                                    echo '<option value="'.htmlspecialchars($songs['title']).'">'.htmlspecialchars($songs['title']).'</option>';
                                }
                            } else {
                                echo '<option disabled>No songs found</option>';
                            }
                            ?>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="videos" class="form-label">Videos in Album</label>
                        <select class="form-select" name="videos[]" id="videos" multiple="multiple">
                            <?php
                            mysqli_data_seek($video_results, 0);
                            if (mysqli_num_rows($video_results) > 0) {
                                while ($videos = mysqli_fetch_assoc($video_results)) {
                                    echo '<option value="'.htmlspecialchars($videos['title']).'">'.htmlspecialchars($videos['title']).'</option>';
                                }
                            } else {
                                echo '<option disabled>No videos found</option>';
                            }
                            ?>
                        </select>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Create Album</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

    <!-- View Album Modal -->
<div class="modal fade" id="viewAlbumModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Album Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex mb-4">
                    <img id="viewCover" src="" class="album-cover me-4">
                    <div>
                        <h2 id="viewTitle"></h2>
                        <div id="viewArtist"></div>
                        <div id="viewYear"></div>
                    </div>
                </div>
                <h5>Description</h5>
                <p id="viewDesc"></p>
                <h5 class="mt-3">Songs</h5>
                <ul id="viewSongs"></ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<!-- Edit Album Modal -->
<div class="modal fade" id="editAlbumModal" tabindex="-1" aria-labelledby="editAlbumModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editAlbumModalLabel">Edit Album</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editAlbumForm" action="crud/update-album.php" method="post" enctype="multipart/form-data" novalidate>
                    <input type="hidden" id="editAlbumId" name="id">
                    <input type="hidden" id="editExistingCover" name="existing_cover">
                    
                    <div class="d-flex align-items-center mb-4">
                        <img src="" id="editAlbumCover" class="album-cover me-4" style="width: 80px; height: 80px;">
                        <div>
                            <h4 id="editAlbumTitleDisplay">Album Title</h4>
                            <div class="album-meta">
                                <span id="editAlbumArtistDisplay">Artist</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="editAlbumTitleInput" class="form-label">Album Title *</label>
                            <input type="text" class="form-control" id="editAlbumTitleInput" name="title" 
                                   pattern="[a-zA-Z0-9\s]*"
                                   title="Only letters, numbers and spaces allowed"
                                   required>
                            <div class="invalid-feedback">Please enter a valid album title (no special characters)</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="editArtist" class="form-label">Artist *</label>
                            <select class="form-select" id="editArtist" name="artist" required>
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
                            <label for="editReleaseYear" class="form-label">Release Year *</label>
                            <input type="number" class="form-control" id="editReleaseYear" name="year" 
                                   min="1900" max="2025" required>
                            <div class="invalid-feedback">Please enter a valid year (1900-2025)</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="editStatus" class="form-label">Status *</label>
                            <select class="form-select" id="editStatus" name="status" required>
                                <option value="published">Published</option>
                                <option value="pending">Pending Review</option>
                            </select>
                            <div class="invalid-feedback">Please select a status</div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="editDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="editDescription" name="description" rows="3"></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="editCoverImage" class="form-label">Cover Image</label>
                        <input type="file" name="editCoverImage" id="editCoverImage" class="form-control" 
                               accept="image/*">
                        <small class="text-muted">Leave blank to keep current image</small>
                        <div class="invalid-feedback">Please upload a valid image (JPG/PNG, max 2MB)</div>
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>

        document.addEventListener('DOMContentLoaded', function() {
    const editButtons = document.querySelectorAll('.edit-album');
    
    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Get album data from button attributes
            const albumId = this.getAttribute('data-id');
            const albumTitle = this.getAttribute('data-title');
            const albumArtist = this.getAttribute('data-artist');
            const albumDesc = this.getAttribute('data-desc');
            const albumStatus = this.getAttribute('data-status');
            const albumImage = this.getAttribute('data-image');
            const releaseYear = this.getAttribute('data-year');
            
            // Set values in the edit modal
            document.getElementById('editAlbumId').value = albumId;
            document.getElementById('editExistingCover').value = albumImage;
            document.getElementById('editAlbumTitleInput').value = albumTitle;
            document.getElementById('editAlbumTitleDisplay').textContent = albumTitle;
            document.getElementById('editAlbumArtistDisplay').textContent = albumArtist;
            document.getElementById('editDescription').value = albumDesc;
            document.getElementById('editReleaseYear').value = releaseYear;
            document.getElementById('editAlbumCover').src = 'uploads/albumscover/' + albumImage;
            
            // Set dropdown values
            document.getElementById('editArtist').value = albumArtist;
            
            // Properly set status dropdown
            const statusSelect = document.getElementById('editStatus');
            statusSelect.value = albumStatus;
            
            // If using Select2, trigger change
            if (typeof $(statusSelect).select2 === 'function') {
                $(statusSelect).trigger('change');
            }
        });
    });
});
        
        
        
        function toggledropdown() {
            const dropdown = document.querySelector('.dropdown-menu');
            if (dropdown.style.display === 'block') {
                dropdown.style.display = 'none';
            } else {
                dropdown.style.display = 'block';
            }
        }
        
        
        $(document).ready(function() {
            

            $('select').select2('destroy');({
        theme: 'default',
        dropdownParent: $('#editAlbumModal') // Important for modals
    });
    // Initialize all select elements
    $('select').select2({
        theme: 'default',
        dropdownParent: $('#addAlbumModal')
    });

        

document.addEventListener('DOMContentLoaded', function() {
    
    
    // Save changes button for edit modal
    document.getElementById('saveAlbumChanges').addEventListener('click', function() {
        // Show success message
        const successMsg = document.createElement('div');
        successMsg.className = 'alert alert-success position-fixed top-0 end-0 m-4';
        successMsg.style.zIndex = '1100';
        successMsg.style.opacity = '0';
        successMsg.style.transition = 'opacity 0.5s';
        successMsg.innerHTML = '✅ Album updated successfully!';
        document.body.appendChild(successMsg);
        
        // Fade in
        setTimeout(() => {
            successMsg.style.opacity = '1';
        }, 100);
        
        // Close modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('editAlbumModal'));
        modal.hide();
        
        // Remove success message after 3 seconds
        setTimeout(() => {
            successMsg.style.opacity = '0';
            setTimeout(() => successMsg.remove(), 500);
        }, 3000);
    });
});



        // Form validation for adding album
        document.querySelector('.submit').addEventListener('click', function() {
            const albumTitle = document.getElementById('albumTitle').value;
            const artist = document.getElementById('artist').value;
            const releaseYear = document.getElementById('releaseYear').value;
            
            if (!albumTitle || !artist || !releaseYear) {
                alert('Please fill in all required fields');
                return;
            }
            
            // Year validation
            if(releaseYear < 1900 || releaseYear > 2025) {
                alert('Please enter a valid release year between 1900 and 2025');
                return;
            }
            
            // If all validations pass, close the modal and show success message
            const modal = bootstrap.Modal.getInstance(document.getElementById('addAlbumModal'));
            modal.hide();
            
            alert('Album created successfully!');
        });

        // Search functionality
        const searchInput = document.querySelector('.search-bar input');
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('.table tbody tr');
            
            rows.forEach(row => {
                const albumTitle = row.querySelector('.album-title').textContent.toLowerCase();
                if(albumTitle.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        const viewModal = new bootstrap.Modal(document.getElementById('viewAlbumModal'));
        const editModal = new bootstrap.Modal(document.getElementById('editAlbumModal'));

    });
    $(document).ready(function() {
            
            
            const viewButtons = document.querySelectorAll('.view-album');
    
    viewButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Get data from button attributes
            const title = this.getAttribute('data-title');
            const artist = this.getAttribute('data-artist');
            const year = this.getAttribute('data-year');
            const desc = this.getAttribute('data-desc');
            const image = this.getAttribute('data-image');
            const songs = this.getAttribute('data-songs');
            
            // Set data in modal
            document.getElementById('viewTitle').textContent = title;
            document.getElementById('viewArtist').textContent = 'Artist: ' + artist;
            document.getElementById('viewYear').textContent = 'Year: ' + year;
            document.getElementById('viewDesc').textContent = desc;
            document.getElementById('viewCover').src = 'uploads/albumscover/' + image;
            
            // Process songs
            const songsList = document.getElementById('viewSongs');
            songsList.innerHTML = ''; // Clear previous songs
            
            if(songs) {
                const songArray = songs.split(',');
                songArray.forEach((song, index) => {
                    if(song.trim() !== '') {
                        const li = document.createElement('li');
                        li.textContent = `${index + 1}. ${song.trim()}`;
                        songsList.appendChild(li);
                    }
                });
            }
        });
    });




    // Add Album Form Validation
document.getElementById('addAlbumForm').addEventListener('submit', function(e) {
    e.preventDefault();
    let isValid = true;

    // Reset validation
    this.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
    this.querySelectorAll('.invalid-feedback').forEach(el => el.style.display = 'none');

    // Validate required fields
    const requiredFields = [
        { id: 'albumTitle', message: 'Album title is required' },
        { id: 'artist', message: 'Artist is required' },
        { id: 'releaseYear', message: 'Release year is required' }
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
    const albumTitle = document.getElementById('albumTitle');
    if (/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/.test(albumTitle.value)) {
        albumTitle.classList.add('is-invalid');
        albumTitle.nextElementSibling.textContent = 'Special characters are not allowed';
        albumTitle.nextElementSibling.style.display = 'block';
        isValid = false;
    }

    // Validate year range
    const year = document.getElementById('releaseYear');
    if (year.value && (year.value < 1900 || year.value > 2025)) {
        year.classList.add('is-invalid');
        year.nextElementSibling.textContent = 'Please enter a year between 1900-2025';
        year.nextElementSibling.style.display = 'block';
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
        this.submit();
    } else {
        // Focus on first invalid field
        this.querySelector('.is-invalid').focus();
    }
});

// Edit Album Form Validation
document.getElementById('editAlbumForm').addEventListener('submit', function(e) {
    e.preventDefault();
    let isValid = true;

    // Reset validation
    this.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
    this.querySelectorAll('.invalid-feedback').forEach(el => el.style.display = 'none');

    // Validate required fields
    const requiredFields = [
        { id: 'editAlbumTitleInput', message: 'Album title is required' },
        { id: 'editArtist', message: 'Artist is required' },
        { id: 'editReleaseYear', message: 'Release year is required' },
        { id: 'editStatus', message: 'Status is required' }
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
    const albumTitle = document.getElementById('editAlbumTitleInput');
    if (/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/.test(albumTitle.value)) {
        albumTitle.classList.add('is-invalid');
        albumTitle.nextElementSibling.textContent = 'Special characters are not allowed';
        albumTitle.nextElementSibling.style.display = 'block';
        isValid = false;
    }

    // Validate year range
    const year = document.getElementById('editReleaseYear');
    if (year.value && (year.value < 1900 || year.value > 2025)) {
        year.classList.add('is-invalid');
        year.nextElementSibling.textContent = 'Please enter a year between 1900-2025';
        year.nextElementSibling.style.display = 'block';
        isValid = false;
    }

    // Validate cover image if new one is uploaded
    const coverImage = document.getElementById('editCoverImage');
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
        this.submit();
    } else {
        // Focus on first invalid field
        this.querySelector('.is-invalid').focus();
    }
});

// Real-time validation for title fields
document.getElementById('albumTitle').addEventListener('input', function() {
    this.value = this.value.replace(/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/g, '');
});

document.getElementById('editAlbumTitleInput').addEventListener('input', function() {
    this.value = this.value.replace(/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/g, '');
});

// Initialize Select2
$(document).ready(function() {
    $('#songs, #videos').select2({
        placeholder: "Select items",
        dropdownParent: $('#addAlbumModal')
    });
});
    
    
    
    
            
            // Edit album modal
            $(document).on('click', '.edit-album', function() {
                const row = $(this).closest('tr');
                const title = row.data('title');
                const artist = row.data('artist');
                const genres = row.data('genres').split(',');
                const releaseDate = row.data('releaseDate');
                const status = row.data('status');
                const description = row.data('description');
                
                // Update modal content
                $('#editAlbumTitle').text(title);
                $('#editAlbumTitleInput').val(title);
                $('#editArtistSelect').val(artist);
                $('#editAlbumCover').attr('src', 'https://via.placeholder.com/100');
                
                // Set release date
                const dateParts = releaseDate.split(' ');
                const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                const monthIndex = months.indexOf(dateParts[0]);
                const day = parseInt(dateParts[1].replace(',', ''));
                const year = parseInt(dateParts[2]);
                
                const formattedDate = `${year}-${(monthIndex + 1).toString().padStart(2, '0')}-${day.toString().padStart(2, '0')}`;
                $('#editReleaseDate').val(formattedDate);
                
                // Set status
                $('#editStatus').val(status);
                
                // Set genres
                $('#editGenres').val(genres).trigger('change');
                
                // Set description
                $('#editDescription').val(description);
                
                // Show modal
                $('#editAlbumModal').modal('show');
            });


            
        
        });
    </script>
</body>
</html>

