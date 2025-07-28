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

    $sqlsong = "SELECT s.*, a.image as artist_image 
                FROM songs s 
                LEFT JOIN artists a ON s.artist = a.name";
    $results = mysqli_query($con, $sqlsong);
    ?>




    <!DOCTYPE html>
    <html lang="en">
    <head>
        <title>Songs Management | SOUND Group</title>
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
            
            /* Table styling - ENHANCED */
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
            
            /* Song info styling */
            .song-info {
                display: flex;
                align-items: center;
                gap: 15px;
            }
            
            .song-info img{
                width: 3rem;
            }
            
            .song-thumb {
                width: 45px;
                height: 45px;
                border-radius: 6px;
                background: linear-gradient(45deg, var(--primary), var(--secondary));
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                font-weight: 600;
                font-size: 18px;
                flex-shrink: 0;
            }
            
            .song-details {
                flex: 1;
            }
            
            .song-title {
                font-weight: 600;
                margin-bottom: 3px;
                color: var(--light);
            }
            
            .song-meta {
                font-size: 0.85rem;
                color: #6c757d;
                display: flex;
                align-items: center;
                gap: 8px;
            }
            
            .song-meta .genre-tag {
                background: rgba(64, 93, 230, 0.1);
                color: var(--primary);
                padding: 2px 8px;
                border-radius: 12px;
                font-size: 0.75rem;
                font-weight: 500;
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
            
            /* Plays count */
            .plays-count {
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
            
            /* Gradient boxes for songs */
            .gradient-box {
                width: 40px;
                height: 40px;
                border-radius: 6px;
                display: inline-block;
                margin-right: 15px;
            }
            
            .gradient-1 {
                background: linear-gradient(45deg, #405DE6, #E1306C);
            }
            
            .gradient-2 {
                background: linear-gradient(45deg, #1DB954, #191414);
            }
            
            .gradient-3 {
                background: linear-gradient(45deg, #FF0000, #282828);
            }

            .user-detail-label {
            color: #6c757d;
            font-weight: 500;
            font-size: 0.9rem;
            margin-top: 15px;
        }
        
        .user-detail-value {
            font-size: 1.1rem;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        }
        
        audio {
            border-radius: 10px;
            background: rgba(0,0,0,0.05);
            padding: 10px;
        }
            
            
            
            
            .image-source-toggle {
                display: flex;
                gap: 15px;
                margin-bottom: 15px;
            }
            
            .image-source-toggle .btn {
                flex: 1;
                border-radius: 8px;
                padding: 8px 12px;
                text-align: center;
                background: #f8f9fa;
                border: 1px solid #e0e0e0;
                transition: all 0.3s ease;
            }
            
            .image-source-toggle .btn.active {
                background: var(--primary);
                color: white;
                border-color: var(--primary);
            }
            
            .image-input-section {
                display: none;
            }
            
            .image-input-section.active {
                display: block;
                animation: fadeIn 0.3s ease;
            }
            
            /* Fix for genre select */
            .modal .form-select {
                    background-color: #1f1f1f;
                color: var(--light);
            }
            
            .modal .form-select option {
                color: var(--light);
            }
            
            /* Adjustments for form layout */
            .form-grid {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 20px;
            }
            
            @media (max-width: 768px) {
                .form-grid {
                    grid-template-columns: 1fr;
                }
            }

            ul.dropdown-menu.dropdown-menu-end.profile-dropdown {
        top: -7rem !important;
        right: -1.5rem !important;
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

.modal {
    z-index: 1060;
}

select.form-select option:checked {
    background-color: var(--primary);
    color: white;
}


        </style>
    </head>
    <body>

    <?php
  include 'admin-header.php'
  ?>
    
        <div id="wrapper">
            <?php
            include 'sidebar.php'
            ?>
            
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <div class="topbar">
                    <div>
                        <h2 class="page-title">Songs</h2>
                        <p class="text-muted mb-0">Manage your music library</p>
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
                
                <!-- Songs Content -->
                <div class="page-section active" id="songs">
                    <div class="card">
                        <div class="card-header">
                            <h5>Song Management</h5>
                            <div class="d-flex">
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSongModal">Add New Song</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-container">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Song</th>
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
                                            echo '<tr data-id="'.$rows['id'].'"
      data-title="'.htmlspecialchars($rows['title']).'"
      data-artist="'.htmlspecialchars($rows['artist']).'"
      data-album="'.htmlspecialchars($rows['album']).'"
      data-language="'.htmlspecialchars($rows['language']).'"
      data-status="'.$rows['status'].'"
      data-genre="'.$rows['genre'].'"
      data-year="'.$rows['year'].'"
      data-description="'.htmlspecialchars($rows['description']).'"
      data-cover="uploads/songscover/'.$rows['image'].'">
                                                        <td>
                                                            <div class="song-info">
                                                                <img class="song-thumb" src="uploads/songscover/' . $rows['image'] . '" alt="' . $rows['title'] . '">
                                                                <div class="song-details">
                                                                    <div class="song-title">' . $rows['title'] . '</div>
                                                                    <div class="song-meta">
                                                                        <span class="genre-tag">' . $rows['genre'] . '</span>
                                                                        <span>' . substr($rows['date_added'], 0, 4) . '</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <img src="uploads/artists/' . htmlspecialchars($rows['artist_image']) . '" 
                                                                    alt="' . htmlspecialchars($rows['artist']) . '" 
                                                                    class="rounded-circle me-2" 
                                                                    style="width: 30px; height: 30px; object-fit: cover;">
                                                                <span>' . htmlspecialchars($rows['artist']) . '</span>
                                                            </div>
                                                        </td>
                                                        <td>' . htmlspecialchars($rows['album']) . '</td>
                                                        <td>' . htmlspecialchars($rows['language']) . '</td>
                                                        <td>' . substr($rows['date_added'], 0, 10) . '</td>
                                                        <td><span class="status-badge status-active">' . $rows['status'] . '</span></td>
                                                        <td>
                                                            <div class="action-buttons">
                                                                <button class="btn btn-outline" title="View">
                                                                    <i class="bi bi-eye"></i>
                                                                </button>
                                                                <button class="btn btn-primary editbutton" title="Edit" data-id="' . $rows['id'] . '">
    <i class="bi bi-pencil"></i>
</button>
                                                                <a href="crud/delete-song.php?id=' . $rows['id'] . '" onclick="return confirm(\'Are you sure you want to delete this song?\')">
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


        <!-- Add Song Modal -->
<div class="modal fade" id="addSongModal" tabindex="-1" aria-labelledby="addSongModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addSongModalLabel">Add New Song</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addSongForm" action="crud/add-song.php" method="post" enctype="multipart/form-data" novalidate>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="songTitle" class="form-label">Song Title *</label>
                            <input type="text" class="form-control" id="songTitle" pattern="[a-zA-Z0-9\s]*" 
       title="Special characters are not allowed" name="title" placeholder="Enter song title" required>
                            <div class="invalid-feedback">Please enter a valid song title</div>
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
                            <label for="album" class="form-label">Album</label>
                            <select class="form-select" name="album" id="album">
                                <option value="" selected>Select album (optional)</option>
                                <?php
                                mysqli_data_seek($album_results, 0);
                                if (mysqli_num_rows($album_results) > 0) {
                                    while ($album = mysqli_fetch_assoc($album_results)) {
                                        echo '<option value="'.htmlspecialchars($album['title']).'">'.htmlspecialchars($album['title']).'</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="genre" class="form-label">Genre *</label>
                            <select class="form-select" name="genre" id="genre" required>
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
                            <label for="language" class="form-label">Language</label>
                            <select class="form-select" name="language" id="language">
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
                            <input type="text" class="form-control relyear" name="year" id="year" placeholder="1995" pattern="[1-2][0-9]{3}" required>
                            <div class="invalid-feedback">Please enter a valid year (1900-2025)</div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="newflag" class="form-label">New Icon</label>
                            <select class="form-select" name="newflag" id="newflag">
                                <option value="No" selected>No</option>
                                <option value="Yes">Yes</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" name="description" id="description" rows="3" placeholder="Enter song description"></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="coverImage" class="form-label">Cover Image *</label>
                        <input type="file" name="songcover" class="form-control" id="coverImage" accept="image/*" required>
                        <div class="invalid-feedback">Please upload a cover image (JPG, PNG, max 2MB)</div>
                    </div>
                    <div class="mb-3">
                        <label for="audioFile" class="form-label">Song File *</label>
                        <input type="file" name="songfile" class="form-control" id="audioFile" accept="audio/*" required>
                        <div class="invalid-feedback">Please upload an audio file (MP3, WAV, max 10MB)</div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Song</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

        <!-- View Song Modal -->
    <div class="modal fade" id="viewSongModal" tabindex="-1" aria-labelledby="viewSongModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewSongModalLabel">Song Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex align-items-center mb-4">
                        <div class="song-thumb" id="viewSongThumb" style="width: 80px; height: 80px; font-size: 28px; background: linear-gradient(45deg, #405DE6, #E1306C);">
                            HB
                        </div>
                        <div class="ms-4">
                            <h3 id="viewSongTitle">Honey Blonde</h3>
                            <div class="text-muted" id="viewSongArtist">Joe Jonas</div>
                            <div class="mt-2">
                                <span class="status-badge status-active" id="viewSongStatus">Published</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="user-detail-label">Album</div>
                            <div class="user-detail-value" id="viewSongAlbum">Honey Blonde</div>
                            
                            <div class="user-detail-label">Genre</div>
                            <div class="user-detail-value" id="viewSongGenre">Pop</div>
                            
                            <div class="user-detail-label">Release Year</div>
                            <div class="user-detail-value" id="viewSongYear">2023</div>
                        </div>
                        <div class="col-md-6">
                            <div class="user-detail-label">Duration</div>
                            <div class="user-detail-value" id="viewSongDuration">3:25</div>
                            
                            <div class="user-detail-label">Plays</div>
                            <div class="user-detail-value" id="viewSongPlays">245K</div>
                            
                            <div class="user-detail-label">Added Date</div>
                            <div class="user-detail-value" id="viewSongAdded">Jun 15, 2023</div>
                        </div>
                    </div>
                    
                    <div class="user-detail-label mt-3">Description</div>
                    <div class="user-detail-value" id="viewSongDescription">
                        Catchy pop song with melodic hooks and upbeat rhythm. Perfect for summer playlists.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Song Modal -->
<div class="modal fade" id="editSongModal" tabindex="-1" aria-labelledby="editSongModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSongModalLabel">Edit Song</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editSongForm" action="crud/update-song.php" method="post" enctype="multipart/form-data" novalidate>
                    <input type="hidden" name="id" id="editSongId">
                    <input type="hidden" name="existing_cover" id="editSongExistingCover">
                    <input type="hidden" name="existing_audio" id="editSongExistingAudio">
                    
                    <div class="d-flex align-items-center mb-4">
                        <img src="" alt="Song Cover" id="editSongCurrentCover" class="song-thumb me-3" style="width: 80px; height: 80px;">
                        <div>
                            <h4 id="editSongTitle">Song Title</h4>
                            <div class="text-muted" id="editSongArtist">Artist Name</div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="editSongTitleInput" class="form-label">Song Title *</label>
                            <input type="text" class="form-control" id="editSongTitleInput" pattern="[a-zA-Z0-9\s]*" 
       title="Special characters are not allowed" name="title" placeholder="Enter song title" required>
                            <div class="invalid-feedback">Please enter a valid song title</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="editArtist" class="form-label">Artist *</label>
                            <select class="form-select" name="artist" id="editArtist" required>
                                <option value="" disabled selected>Select artist</option>
                                <?php
                                mysqli_data_seek($artist_results, 0);
                                if (mysqli_num_rows($artist_results) > 0) {
                                    while ($artist = mysqli_fetch_assoc($artist_results)) {
                                        echo '<option value="'.htmlspecialchars($artist['name']).'">'.htmlspecialchars($artist['name']).'</option>';
                                    }
                                }
                                ?>
                            </select>
                            <div class="invalid-feedback">Please select an artist</div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="editAlbum" class="form-label">Album</label>
                            <select class="form-select" name="album" id="editAlbum">
                                <option value="" selected>Select album (optional)</option>
                                <?php
                                mysqli_data_seek($album_results, 0);
                                if (mysqli_num_rows($album_results) > 0) {
                                    while ($album = mysqli_fetch_assoc($album_results)) {
                                        echo '<option value="'.htmlspecialchars($album['title']).'">'.htmlspecialchars($album['title']).'</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="editGenre" class="form-label">Genre *</label>
                            <select class="form-select" name="genre" id="editGenre" required>
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
                            <label for="editLanguage" class="form-label">Language</label>
                            <select class="form-select" name="language" id="editLanguage">
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
                            <label for="editYear" class="form-label">Release Year *</label>
                            <input type="text" class="form-control" name="year" id="editYear" placeholder="2023" pattern="[1-2][0-9]{3}" required>
                            <div class="invalid-feedback">Please enter a valid year (1900-2025)</div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="editNewFlag" class="form-label">New Icon</label>
                            <select class="form-select" name="newflag" id="editNewFlag">
                                <option value="No">No</option>
                                <option value="Yes">Yes</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="editStatus" class="form-label">Status *</label>
                            <select class="form-select" name="status" id="editStatus" required>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                            <div class="invalid-feedback">Please select a status</div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="editDescription" class="form-label">Description</label>
                        <textarea class="form-control" name="description" id="editDescription" rows="3" placeholder="Enter song description"></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="editCoverImage" class="form-label">Cover Image</label>
                        <input type="file" class="form-control" name="songcover" id="editCoverImage" accept="image/*">
                        <small class="text-muted">Leave blank to keep current image</small>
                        <div class="invalid-feedback">Please upload a valid image (JPG, PNG, max 2MB)</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="editAudioFile" class="form-label">Audio File</label>
                        <input type="file" class="form-control" name="songfile" id="editAudioFile" accept="audio/*">
                        <small class="text-muted">Leave blank to keep current file</small>
                        <div class="invalid-feedback">Please upload a valid audio file (MP3, WAV, max 10MB)</div>
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
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>

            function validateNoSpecialChars(inputElement, fieldName) {
    const specialChars = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/;
    if (specialChars.test(inputElement.value)) {
        inputElement.classList.add('is-invalid');
        inputElement.nextElementSibling.textContent = `Special characters are not allowed in ${fieldName}`;
        inputElement.nextElementSibling.style.display = 'block';
        return false;
    }
    return true;
}

            function toggledropdown() {
                const dropdown = document.querySelector('.dropdown-menu');
                if (dropdown.style.display === 'block') {
                    dropdown.style.display = 'none';
                } else {
                    dropdown.style.display = 'block';
                }
            }

    document.addEventListener('DOMContentLoaded', function() {
            // View buttons
            const viewButtons = document.querySelectorAll('.btn-outline[title="View"]');
            viewButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const row = this.closest('tr');
                    
                    // Extract song data from the table row
                    const songTitle = row.querySelector('.song-title').textContent;
                    const songThumbImg = row.querySelector('.song-thumb').getAttribute('src');
                    const songBg = row.querySelector('.song-thumb').style.background;
                    const songArtist = row.cells[1].querySelector('span').textContent;
                    const album = row.cells[2].textContent;
                    const duration = row.cells[2].textContent;
                    const plays = row.cells[3].textContent;
                    const added = row.cells[4].textContent;
                    const status = row.querySelector('.status-badge').textContent;
                    const statusClass = row.querySelector('.status-badge').classList.contains('status-active') ? 
                        'status-active' : row.querySelector('.status-badge').classList.contains('status-pending') ? 
                        'status-pending' : 'status-draft';
                    const genre = row.querySelector('.genre-tag').textContent;
                    
                    // Update view modal content
                    document.getElementById('viewSongAlbum').textContent = album;
                    document.getElementById('viewSongTitle').textContent = songTitle;
                    document.getElementById('viewSongThumb').innerHTML = `<img src="${songThumbImg}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">`;
                    document.getElementById('viewSongThumb').style.background = songBg;
                    document.getElementById('viewSongArtist').textContent = songArtist;
                    document.getElementById('viewSongStatus').textContent = status;
                    document.getElementById('viewSongStatus').className = `status-badge ${statusClass}`;
                    document.getElementById('viewSongDuration').textContent = duration;
                    document.getElementById('viewSongPlays').textContent = plays;
                    document.getElementById('viewSongAdded').textContent = added;
                    document.getElementById('viewSongGenre').textContent = genre;
                    document.getElementById('viewSongYear').textContent = "2023";
                    
                    // Show the modal
                    const viewModal = new bootstrap.Modal(document.getElementById('viewSongModal'));
                    viewModal.show();
                });
            });
            

// This should be your event listener setup
document.addEventListener('click', function(e) {
    if (e.target.closest('.editbutton')) {
        const row = e.target.closest('tr');
        const data = row.dataset;
        
        // Populate edit modal
        document.getElementById('editSongId').value = data.id;
        document.getElementById('editSongTitleInput').value = data.title;
        document.getElementById('editSongTitle').textContent = data.title;
        document.getElementById('editSongArtist').textContent = data.artist;
        document.getElementById('editSongCurrentCover').src = data.cover;
        
        // Set select values
        document.getElementById('editArtist').value = data.artist;
        document.getElementById('editGenre').value = data.genre;
        document.getElementById('editLanguage').value = data.language;
        document.getElementById('editYear').value = data.year;
        document.getElementById('editDescription').value = data.description;
        
        // Set album dropdown
        const albumSelect = document.getElementById('editAlbum');
        for (let i = 0; i < albumSelect.options.length; i++) {
            if (albumSelect.options[i].value === data.album) {
                albumSelect.selectedIndex = i;
                break;
            }
        }
        
        // Set status dropdown
        const statusSelect = document.getElementById('editStatus');
        for (let i = 0; i < statusSelect.options.length; i++) {
            // Normalize both values to lowercase for comparison
            if (statusSelect.options[i].value.toLowerCase() === data.status.toLowerCase()) {
                statusSelect.selectedIndex = i;
                break;
            }
        }
        
        // Set existing cover file name
        const coverFilename = data.cover.split('/').pop();
        document.getElementById('editSongExistingCover').value = coverFilename;
        
        // Show modal
        new bootstrap.Modal(document.getElementById('editSongModal')).show();
    }
});
            
            // Save changes button
            document.getElementById('saveSongChangesBtn').addEventListener('click', function() {
                // Show success message
                const successMsg = document.createElement('div');
                successMsg.className = 'alert-success-msg fade-in';
                successMsg.innerHTML = '✅ Song updated successfully!';
                document.body.appendChild(successMsg);
                
                // Close modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('editSongModal'));
                modal.hide();
                
                // Remove success message after 3 seconds
                setTimeout(() => {
                    successMsg.style.transition = 'opacity 1s ease';
                    successMsg.style.opacity = '0';
                    
                    // Remove after fade completes
                    setTimeout(() => {
                        successMsg.remove();
                    }, 1000);
                }, 3000);
            });
        });

        // Add Song Form Validation
document.getElementById('addSongForm').addEventListener('submit', function(e) {
    e.preventDefault();
    let isValid = true;
const titleValid = validateNoSpecialChars(document.getElementById('songTitle'), 'title');
if (!titleValid) isValid = false;
    // Reset validation
    this.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
    this.querySelectorAll('.invalid-feedback').forEach(el => el.style.display = 'none');

    // Validate required fields
    const requiredFields = [
        { id: 'songTitle', message: 'Song title is required' },
        { id: 'artist', message: 'Artist is required' },
        { id: 'genre', message: 'Genre is required' },
        { id: 'year', message: 'Release year is required' }
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

    // Validate year format
    const year = document.getElementById('year');
    if (year.value && !/^[1-2][0-9]{3}$/.test(year.value)) {
        year.classList.add('is-invalid');
        year.nextElementSibling.textContent = 'Please enter a valid year (1900-2025)';
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

    // Validate audio file
    const audioFile = document.getElementById('audioFile');
    if (!audioFile.files.length) {
        audioFile.classList.add('is-invalid');
        audioFile.nextElementSibling.style.display = 'block';
        isValid = false;
    } else {
        const file = audioFile.files[0];
        const validTypes = ['audio/mpeg', 'audio/wav', 'audio/mp3'];
        const maxSize = 10 * 1024 * 1024; // 10MB
        
        if (!validTypes.includes(file.type)) {
            audioFile.classList.add('is-invalid');
            audioFile.nextElementSibling.textContent = 'Only MP3/WAV files allowed';
            audioFile.nextElementSibling.style.display = 'block';
            isValid = false;
        } else if (file.size > maxSize) {
            audioFile.classList.add('is-invalid');
            audioFile.nextElementSibling.textContent = 'Audio must be less than 10MB';
            audioFile.nextElementSibling.style.display = 'block';
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

document.getElementById('songTitle').addEventListener('input', function() {
    this.value = this.value.replace(/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/g, '');
});

document.getElementById('editSongTitleInput').addEventListener('input', function() {
    this.value = this.value.replace(/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/g, '');
});

// Edit Song Form Validation
document.getElementById('editSongForm').addEventListener('submit', function(e) {
    e.preventDefault();
    let isValid = true;
const editTitleValid = validateNoSpecialChars(document.getElementById('editSongTitleInput'), 'title');
if (!editTitleValid) isValid = false;
    // Reset validation
    this.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
    this.querySelectorAll('.invalid-feedback').forEach(el => el.style.display = 'none');

    // Validate required fields
    const requiredFields = [
        { id: 'editSongTitleInput', message: 'Song title is required' },
        { id: 'editArtist', message: 'Artist is required' },
        { id: 'editGenre', message: 'Genre is required' },
        { id: 'editYear', message: 'Release year is required' },
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

    // Validate year format
    const year = document.getElementById('editYear');
    if (year.value && !/^[1-2][0-9]{3}$/.test(year.value)) {
        year.classList.add('is-invalid');
        year.nextElementSibling.textContent = 'Please enter a valid year (1900-2025)';
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

    // Validate audio file if new one is uploaded
    const audioFile = document.getElementById('editAudioFile');
    if (audioFile.files.length) {
        const file = audioFile.files[0];
        const validTypes = ['audio/mpeg', 'audio/wav', 'audio/mp3'];
        const maxSize = 10 * 1024 * 1024; // 10MB
        
        if (!validTypes.includes(file.type)) {
            audioFile.classList.add('is-invalid');
            audioFile.nextElementSibling.textContent = 'Only MP3/WAV files allowed';
            audioFile.nextElementSibling.style.display = 'block';
            isValid = false;
        } else if (file.size > maxSize) {
            audioFile.classList.add('is-invalid');
            audioFile.nextElementSibling.textContent = 'Audio must be less than 10MB';
            audioFile.nextElementSibling.style.display = 'block';
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

// Real-time validation for year fields
document.getElementById('year').addEventListener('input', function() {
    if (!/^[1-2][0-9]{0,3}$/.test(this.value)) {
        this.value = this.value.slice(0, -1);
    }
});

document.getElementById('editYear').addEventListener('input', function() {
    if (!/^[1-2][0-9]{0,3}$/.test(this.value)) {
        this.value = this.value.slice(0, -1);
    }
});



            
            document.querySelector('.nav-link.active').classList.remove('active');
            document.querySelector('.nav-link[data-page="songs"]').classList.add('active');

            // Basic form validation
            document.querySelector('.submit').addEventListener('click', function() {
                const title = document.getElementById('songTitle').value;
                const artist = document.getElementById('artist').value;
                const duration = document.getElementById('duration').value;
                const year = document.getElementById('relyear').value;
                
                if (!title || !artist || !duration) {
                    alert('Please fill in all required fields');
                    return;
                }
                
                // Duration pattern validation
                if(year > "2025" || year < "1900"){
                    alert('Please enter a valid year between 1900 and 2025');
                    return;
                }
                
                // If all validations pass, close the modal and show success message
                const modal = bootstrap.Modal.getInstance(document.getElementById('addSongModal'));
                modal.hide();
                
                alert('Song added successfully!');
            });


        </script>
    </body>
    </html>