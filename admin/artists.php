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

    $sql = "SELECT * FROM artists";
    $result = mysqli_query($con, $sql);
    ?>




    <!DOCTYPE html>
    <html lang="en">
    <head>
        <title>Artists Management | SOUND Group</title>
        <link rel="icon" type="image/png" href="uploads/icon/favicon.png">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <?php
        include 'head-css.php';
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
            
            
            
            
            
            #wrapper {
                display: flex;
                min-height: 100vh;
            }
            
            /* Sidebar Styles */
        
            
            /* Main Content */
            #content {
                flex: 1;
                margin-left: var(--sidebar-width);
                padding-top: var(--topbar-height);
                min-height: 100vh;
            }
            
            /* Topbar Styles */
        
            
            /* Dashboard Content */
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
            }
            
            .card:hover {
                transform: translateY(-3px);
            }
            
            .card-header {
                border-bottom: 1px solid #e9ecef;
                padding: 20px;
                border-radius: 12px 12px 0 0 !important;
                display: flex;
                align-items: center;
                justify-content: space-between;
            }
            
            .card-header h5 {
                margin-bottom: 0;
                font-weight: 600;
                display: flex;
                align-items: center;
            }
            
            .card-header h5 i {
                margin-right: 10px;
                font-size: 1.2rem;
            }
            
            .card-body {
                padding: 25px;
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
            
            /* Artist info styling */
            .artist-info {
                display: flex;
                align-items: center;
                gap: 15px;
            }
            
            .artist-thumb {
                width: 50px;
                height: 50px;
                border-radius: 50%;
                object-fit: cover;
                flex-shrink: 0;
            }
            
            .artist-details {
                flex: 1;
            }
            
            .artist-name {
                font-weight: 600;
                margin-bottom: 3px;
                color: var(--light);
            }
            
            .artist-meta {
                font-size: 0.85rem;
                color: #6c757d;
                display: flex;
                align-items: center;
                gap: 8px;
            }
            
            .artist-meta .genre-tag {
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
            }
            
            /* Modal styling */
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
                border: 1px solid #e0e0e0;
                padding: 10px 15px;
            }
            
            .form-control:focus, .form-select:focus {
                background: rgba(30, 30, 46, 0.7) !important;
                border-color: var(--primary);
                box-shadow: 0 0 0 0.25rem rgba(64, 93, 230, 0.2);
                color: var(--light);
            }
            
            /* Responsive Adjustments */
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
                
                #topbar {
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
                
                #topbar {
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
            }




            .social-link {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(64, 93, 230, 0.1);
            color: var(--primary);
            font-size: 1.2rem;
            transition: all 0.3s ease;
        }
        
        .social-link:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-3px);
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

        
            
            /* Fix for genre select */
            .modal .form-select {
                color: #212529;
            }
            
            .modal .form-select option {
                color: #212529;
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


    .select2-container {
        z-index: 9999 !important;
    }









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
            
            /* Fix for genre tags in view modal */
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
            
            /* Fix for select2 dropdowns */
            .select2-container--default .select2-selection--multiple {
                background-color: #2a2a3f;
                border: 1px solid rgba(255,255,255,0.1);
                border-radius: 8px;
                min-height: 42px;
            }
            
            .select2-container--default .select2-selection--multiple .select2-selection__choice {
                background: rgba(64, 93, 230, 0.3);
                border: none;
                border-radius: 12px;
                color: #e0e0e0;
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
            
            .error-msg {
    color: red;
    font-size: 0.85rem;
  }

  /* Validation Styles */
.is-invalid {
    border-color: #dc3545 !important;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right calc(0.375em + 0.1875rem) center;
    background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
    padding-right: 2.5rem;
}

.is-invalid:focus {
    box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25);
}

.invalid-feedback {
    display: none;
    width: 100%;
    margin-top: 0.25rem;
    font-size: 0.875em;
    color: #dc3545;
}

.was-validated .form-control:invalid ~ .invalid-feedback,
.was-validated .form-control:invalid ~ .invalid-tooltip,
.form-control.is-invalid ~ .invalid-feedback,
.form-control.is-invalid ~ .invalid-tooltip {
    display: block;
}

/* For Select2 validation */
.select2-container.is-invalid + .invalid-feedback {
    display: block;
}

.select2-selection.is-invalid {
    border-color: #dc3545 !important;
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
            include 'sidebar.php';
            ?>
            
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <div class="topbar mt-4">
                    <div>
                        <h2 class="page-title">Artists</h2>
                        <p class="text-muted mb-0">Manage your artists library</p>
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
                
                <!-- Artists Content -->
                <div class="page-section active" id="artists">
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="bi bi-people-fill"></i> Artist Management</h5>
                            <div class="d-flex">
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addArtistModal">Add New Artist</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-container">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Artist</th>
                                            <th>Country</th>
                                            <th>Biography</th>
                                            <th>Added</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            if (mysqli_num_rows($result) > 0) {
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    // Convert genres into tags
                                                    $genre_tags = '';
                                                    $genres_array = explode(',', $row['genres']);
                                                    foreach ($genres_array as $genre) {
                                                        $genre_tags .= '<span class="genre-tag">' . htmlspecialchars(trim($genre)) . '</span> ';
                                                    }

                                                    echo '<tr>
                                                        <td>
                                                            <div class="artist-info">
                                                                <img src="uploads/artists/' . htmlspecialchars($row['image']) . '" 
                                                                    alt="' . htmlspecialchars($row['name']) . '" 
                                                                    class="artist-thumb">
                                                                <div class="artist-details">
                                                                    <div class="artist-name">' . htmlspecialchars($row['name']) . '</div>
                                                                    <div class="artist-meta">
                                                                        <span>' . htmlspecialchars($row['genres']) . '</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>' . htmlspecialchars($row['country']) . '</td>
                                                        <td>' . htmlspecialchars($row['biography']) . '</td> 
                                                        <td>' . substr(htmlspecialchars($row['date_added']), 0, 10) . '</td> 
                                                        <td><span class="status-badge status-' . strtolower($row['status']) . '">' . ucfirst($row['status']) . '</span></td>
                                                        <td>
                                                            <div class="action-buttons">
                                                                <button class="btn btn-outline view-artist" title="View">
                                                                    <i class="bi bi-eye"></i>
                                                                </button>
                                                                <button class="btn btn-primary edit-artist" title="Edit" data-id="'.$row['id'].'">
    <i class="bi bi-pencil"></i>
</button>
                                                                <a href="crud/delete-artist.php?id=' . $row['id'] . '" onclick="return confirm(\'Are you sure you want to delete this artist?\')">
                                                                    <button class="btn btn-outline" title="Delete">
                                                                        <i class="bi bi-trash"></i>
                                                                    </button>
                                                                </a>

                                                            </div>
                                                        </td>
                                                    </tr>';
                                                }
                                            } else {
                                                echo "<tr><td colspan='7'>No artists found.</td></tr>";
                                            }

                                            mysqli_close($con);
                                            ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        
        <!-- Add Artist Modal -->
<div class="modal fade" id="addArtistModal" tabindex="-1" aria-labelledby="addArtistModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addArtistModalLabel">Add New Artist</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addArtistForm" action="crud/add-artist.php" method="POST" enctype="multipart/form-data" novalidate>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="artistName" class="form-label">Artist Name *</label>
                            <input type="text" class="form-control" id="artistName" name="name" placeholder="Enter artist name" required>
                            <div class="invalid-feedback">Please enter a valid artist name (no special characters)</div>
                        </div>
                    </div>
                    
                    <div class="form-grid mb-3">
                        <div>
                            <label for="country" class="form-label">Country *</label>
                            <input type="text" class="form-control" id="country" name="country" placeholder="Enter Country" required>
                            <div class="invalid-feedback">Please enter a valid country name</div>
                        </div>

                        <div>
                            <label for="language" class="form-label">Language *</label>
                            <select class="form-select" name="language" id="language" required>
                                <option value="" selected disabled>Select language</option>
                                <option value="English">English</option>
                                <option value="Hindi">Hindi</option>
                                <option value="Urdu">Urdu</option>
                                <option value="Spanish">Spanish</option>
                                <option value="French">French</option>
                                <option value="German">German</option>
                                <option value="Italian">Italian</option>
                            </select>
                            <div class="invalid-feedback">Please select a language</div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="genres" class="form-label">Genres *</label>
                        <select class="form-select" name="genres[]" id="genres" multiple="multiple" required>
                            <option value="Pop">Pop</option>
                            <option value="Rock">Rock</option>
                            <option value="Hip-Hop">Hip-Hop</option>
                            <option value="Electronic">Electronic</option>
                            <option value="R&B">R&B</option>
                            <option value="Country">Country</option>
                            <option value="Jazz">Jazz</option>
                            <option value="Classical">Classical</option>
                        </select>
                        <div class="invalid-feedback">Please select at least one genre</div>
                        <small class="text-muted">You can select multiple genres</small>
                    </div>
                    
                    <div class="mb-3">
                        <label for="biography" class="form-label">Biography</label>
                        <textarea class="form-control" id="biography" name="biography" rows="4" placeholder="Enter artist biography"></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="artistImageFile" class="form-label">Artist Image *</label>
                        <input type="file" class="form-control" name="artistImageFile" id="artistImageFile" accept="image/*" required>
                        <div class="invalid-feedback">Please upload an artist image</div>
                        <small class="text-muted">Accepted formats: JPG, PNG, JPEG (Max 2MB)</small>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Artist</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

    <!-- View Artist Modal -->
        <div class="modal fade" id="viewArtistModal" tabindex="-1" aria-labelledby="viewArtistModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewArtistModalLabel">Artist Details</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex align-items-center mb-4">
                            <img src="" alt="Artist" id="viewArtistImage" class="artist-thumb me-4" style="width: 100px; height: 100px;">
                            <div>
                                <h3 id="viewArtistName">Artist Name</h3>
                                <div class="mt-2">
                                    <span class="status-badge" id="viewArtistStatus">Active</span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="user-detail-label">Country</div>
                                <div class="user-detail-value" id="viewArtistCountry">United States</div>
                            </div>
                            <div class="col-md-6">
                                <div class="user-detail-label">Added Date</div>
                                <div class="user-detail-value" id="viewArtistAddedDate">Jun 15, 2023</div>
                            </div>
                        </div>
                        
                        <div class="mt-3">
                            <div class="user-detail-label">Genres</div>
                            <div class="genre-container" id="viewArtistGenres">
                                <!-- Genres will be added here -->
                            </div>
                        </div>
                        
                        <div class="mt-3">
                            <div class="user-detail-label">Biography</div>
                            <div class="user-detail-value mt-2" id="viewArtistBio">
                                Artist biography will appear here...
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Artist Modal -->
        <!-- Edit Artist Modal -->
<div class="modal fade" id="editArtistModal" tabindex="-1" aria-labelledby="editArtistModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editArtistModalLabel">Edit Artist</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editArtistForm" action="crud/update-artist.php" method="POST" enctype="multipart/form-data" novalidate>
                    <input type="hidden" id="editArtistId" name="id">
                    <input type="hidden" name="existing_artist_img" id="editArtisteximg">
                    
                    <div class="d-flex align-items-center mb-4">
                        <img src="" alt="Artist" id="editArtistImage" class="artist-thumb me-4" style="width: 80px; height: 80px;">
                        <div>
                            <h4 id="editArtistName">Artist Name</h4>
                        </div>
                    </div>
                    
                    <div class="form-grid mb-3">
                        <div>
                            <label for="editArtistNameInput" class="form-label">Artist Name *</label>
                            <input type="text" class="form-control" id="editArtistNameInput" name="name" placeholder="Enter artist name" required>
                            <div class="invalid-feedback">Please enter a valid artist name (no special characters)</div>
                        </div>
                        
                        <div>
                            <label for="editCountry" class="form-label">Country *</label>
                            <input type="text" class="form-control" id="editCountry" name="country" placeholder="Enter country" required>
                            <div class="invalid-feedback">Please enter a valid country name</div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="editGenres" class="form-label">Genres *</label>
                        <select class="form-select" id="editGenres" name="genres[]" multiple required>
                            <option value="Pop">Pop</option>
                            <option value="Rock">Rock</option>
                            <option value="Hip-Hop">Hip-Hop</option>
                            <option value="Electronic">Electronic</option>
                            <option value="R&B">R&B</option>
                            <option value="Country">Country</option>
                            <option value="Jazz">Jazz</option>
                            <option value="Classical">Classical</option>
                        </select>
                        <div class="invalid-feedback">Please select at least one genre</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="editBiography" class="form-label">Biography</label>
                        <textarea class="form-control" id="editBiography" name="biography" rows="4" placeholder="Enter artist biography"></textarea>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label">Artist Image</label>
                        <input type="file" class="form-control" name="artistImageFile" id="editArtistImageFile" accept="image/*">
                        <div class="invalid-feedback">Please upload a valid image (JPG, PNG, JPEG, max 2MB)</div>
                        <small class="text-muted">Leave blank to keep current image</small>
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>




            $(document).ready(function() {
                // Initialize Select2 for genre selection
                $('#genres').select2({
                    placeholder: "Select genres",
                    allowClear: true,
                    dropdownParent: $('#addArtistModal')
                });
                
                $('#editGenres').select2({
                    placeholder: "Select genres",
                    allowClear: true,
                    dropdownParent: $('#editArtistModal')
                });
                
                // Search functionality
                $('#artistSearch').on('input', function() {
                    const searchTerm = $(this).val().toLowerCase();
                    $('#artistTableBody tr').each(function() {
                        const artistName = $(this).find('.artist-name').text().toLowerCase();
                        if (artistName.includes(searchTerm)) {
                            $(this).show();
                        } else {
                            $(this).hide();
                        }
                    });
                });
                
                // View artist modal
                $('.view-artist').on('click', function() {
                    const artistId = $(this).data('id');
                    const row = $(this).closest('tr');
                    
                    // Extract artist data from the row
                    const artistName = row.find('.artist-name').text();
                    const artistImage = row.find('.artist-thumb').attr('src');
                    const country = row.find('td:eq(1)').text();
                    const bio = row.find('td:eq(2)').text();
                    const addedDate = row.find('td:eq(3)').text();
                    const status = row.find('.status-badge').text();
                    const statusClass = row.find('.status-badge').attr('class').split(' ')[1];
                    
                    // Extract genres
                    let genresHtml = '';
                    row.find('.genre-tag').each(function() {
                        const genre = $(this).text();
                        genresHtml += `<span class="genre-badge">${genre}</span>`;
                    });
                    
                    // Populate modal
                    $('#viewArtistName').text(artistName);
                    $('#viewArtistImage').attr('src', artistImage);
                    $('#viewArtistCountry').text(country);
                    $('#viewArtistAddedDate').text(addedDate);
                    $('#viewArtistStatus').text(status).attr('class', `status-badge ${statusClass}`);
                    $('#viewArtistGenres').html(genresHtml);
                    $('#viewArtistBio').text(bio);
                    
                    // Show modal
                    $('#viewArtistModal').modal('show');
                });
                
                // Edit artist modal
               $('.edit-artist').on('click', function() {
    const artistId = $(this).data('id');
    const row = $(this).closest('tr');
    
    // Extract artist data from the row
    const artistName = row.find('.artist-name').text();
    const artistImage = row.find('.artist-thumb').attr('src');
    const country = row.find('td:eq(1)').text();
    const bio = row.find('td:eq(2)').text();
    
    // Extract genres
    const genres = [];
    row.find('.genre-tag').each(function() {
        genres.push($(this).text());
    });
    
    // Populate modal
    $('#editArtistId').val(artistId);
    $('#editArtistName').text(artistName);
    $('#editArtistNameInput').val(artistName);
    $('#editArtistImage').attr('src', artistImage);
    $('#editArtisteximg').val(artistImage.split('/').pop()); // Store just the filename
    $('#editCountry').val(country);
    $('#editBiography').val(bio);
    
    // Set genres in Select2
    $('#editGenres').val(genres).trigger('change');
    
    // Show modal
    $('#editArtistModal').modal('show');
});



// Edit Artist Modal Validation
$(document).ready(function() {
    // Initialize Select2 for edit modal genre selection
    $('#editGenres').select2({
        placeholder: "Select genres (required)",
        allowClear: false,
        dropdownParent: $('#editArtistModal'),
        minimumResultsForSearch: Infinity
    });

    // Edit form validation
    $('#editArtistForm').on('submit', function(e) {
        e.preventDefault();
        let isValid = true;

        // Reset validation
        $(this).find('.is-invalid').removeClass('is-invalid');
        $(this).find('.invalid-feedback').hide();

        // Validate Artist Name (no special chars)
        const editName = $('#editArtistNameInput').val().trim();
        const specialChars = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/;
        if (editName === '') {
            $('#editArtistNameInput').addClass('is-invalid');
            $('#editArtistNameInput').next('.invalid-feedback').text('Artist name is required').show();
            isValid = false;
        } else if (specialChars.test(editName)) {
            $('#editArtistNameInput').addClass('is-invalid');
            $('#editArtistNameInput').next('.invalid-feedback').text('Special characters are not allowed').show();
            isValid = false;
        }

        // Validate Country (no special chars)
        const editCountry = $('#editCountry').val().trim();
        if (editCountry === '') {
            $('#editCountry').addClass('is-invalid');
            $('#editCountry').next('.invalid-feedback').text('Country is required').show();
            isValid = false;
        } else if (specialChars.test(editCountry)) {
            $('#editCountry').addClass('is-invalid');
            $('#editCountry').next('.invalid-feedback').text('Special characters are not allowed').show();
            isValid = false;
        }

        // Validate Genres
        if ($('#editGenres').val() === null || $('#editGenres').val().length === 0) {
            $('#editGenres').addClass('is-invalid');
            $('#editGenres').next('.select2-container').addClass('is-invalid');
            $('#editGenres').nextAll('.invalid-feedback').text('Please select at least one genre').show();
            isValid = false;
        }

        // Validate Image if new file is selected
        const editImageFile = $('#editArtistImageFile')[0].files[0];
        if (editImageFile) {
            // Check file type
            const validTypes = ['image/jpeg', 'image/png', 'image/jpg'];
            const maxSize = 2 * 1024 * 1024; // 2MB
            
            if (!validTypes.includes(editImageFile.type)) {
                $('#editArtistImageFile').addClass('is-invalid');
                $('#editArtistImageFile').next('.invalid-feedback').text('Invalid file type. Only JPG, PNG, JPEG allowed.').show();
                isValid = false;
            } else if (editImageFile.size > maxSize) {
                $('#editArtistImageFile').addClass('is-invalid');
                $('#editArtistImageFile').next('.invalid-feedback').text('File too large. Max 2MB allowed.').show();
                isValid = false;
            }
        }

        if (isValid) {
            // If all valid, submit the form
            this.submit();
        } else {
            // Show first error field
            $('.is-invalid').first().focus();
        }
    });

    // Real-time validation for edit modal name and country
    $('#editArtistNameInput, #editCountry').on('input', function() {
        const value = $(this).val().trim();
        const specialChars = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/;
        
        if (value === '') {
            $(this).removeClass('is-invalid');
            $(this).next('.invalid-feedback').hide();
        } else if (specialChars.test(value)) {
            $(this).addClass('is-invalid');
            $(this).next('.invalid-feedback').text('Special characters are not allowed').show();
        } else {
            $(this).removeClass('is-invalid');
            $(this).next('.invalid-feedback').hide();
        }
    });

    // Real-time validation for edit modal genres
    $('#editGenres').on('change', function() {
        if ($(this).val() === null || $(this).val().length === 0) {
            $(this).addClass('is-invalid');
            $(this).next('.select2-container').addClass('is-invalid');
            $(this).nextAll('.invalid-feedback').text('Please select at least one genre').show();
        } else {
            $(this).removeClass('is-invalid');
            $(this).next('.select2-container').removeClass('is-invalid');
            $(this).nextAll('.invalid-feedback').hide();
        }
    });

    // Real-time validation for edit modal image
    $('#editArtistImageFile').on('change', function() {
        const file = this.files[0];
        if (file) {
            const validTypes = ['image/jpeg', 'image/png', 'image/jpg'];
            const maxSize = 2 * 1024 * 1024; // 2MB
            
            if (!validTypes.includes(file.type)) {
                $(this).addClass('is-invalid');
                $(this).next('.invalid-feedback').text('Invalid file type. Only JPG, PNG, JPEG allowed.').show();
            } else if (file.size > maxSize) {
                $(this).addClass('is-invalid');
                $(this).next('.invalid-feedback').text('File too large. Max 2MB allowed.').show();
            } else {
                $(this).removeClass('is-invalid');
                $(this).next('.invalid-feedback').hide();
            }
        } else {
            $(this).removeClass('is-invalid');
            $(this).next('.invalid-feedback').hide();
        }
    });
});


$(document).ready(function() {
    // Initialize Select2 for genre selection
    $('#genres').select2({
        placeholder: "Select genres (required)",
        allowClear: false,
        dropdownParent: $('#addArtistModal'),
        minimumResultsForSearch: Infinity
    });

    // Form validation
    $('#addArtistForm').on('submit', function(e) {
        e.preventDefault();
        let isValid = true;

        // Reset validation
        $(this).find('.is-invalid').removeClass('is-invalid');
        $(this).find('.invalid-feedback').hide();

        // Validate Artist Name (no special chars)
        const name = $('#artistName').val().trim();
        const specialChars = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/;
        if (name === '') {
            $('#artistName').addClass('is-invalid');
            $('#artistName').next('.invalid-feedback').text('Artist name is required').show();
            isValid = false;
        } else if (specialChars.test(name)) {
            $('#artistName').addClass('is-invalid');
            $('#artistName').next('.invalid-feedback').text('Special characters are not allowed').show();
            isValid = false;
        }

        // Validate Country (no special chars)
        const country = $('#country').val().trim();
        if (country === '') {
            $('#country').addClass('is-invalid');
            $('#country').next('.invalid-feedback').text('Country is required').show();
            isValid = false;
        } else if (specialChars.test(country)) {
            $('#country').addClass('is-invalid');
            $('#country').next('.invalid-feedback').text('Special characters are not allowed').show();
            isValid = false;
        }

        // Validate Language
        if ($('#language').val() === null || $('#language').val() === '') {
            $('#language').addClass('is-invalid');
            $('#language').next('.invalid-feedback').text('Please select a language').show();
            isValid = false;
        }

        // Validate Genres
        if ($('#genres').val() === null || $('#genres').val().length === 0) {
            $('#genres').addClass('is-invalid');
            $('#genres').next('.select2-container').addClass('is-invalid');
            $('#genres').nextAll('.invalid-feedback').text('Please select at least one genre').show();
            isValid = false;
        }

        // Validate Image
        const imageFile = $('#artistImageFile')[0].files[0];
        if (!imageFile) {
            $('#artistImageFile').addClass('is-invalid');
            $('#artistImageFile').next('.invalid-feedback').text('Artist image is required').show();
            isValid = false;
        } else {
            // Check file type
            const validTypes = ['image/jpeg', 'image/png', 'image/jpg'];
            const maxSize = 2 * 1024 * 1024; // 2MB
            
            if (!validTypes.includes(imageFile.type)) {
                $('#artistImageFile').addClass('is-invalid');
                $('#artistImageFile').next('.invalid-feedback').text('Invalid file type. Only JPG, PNG, JPEG allowed.').show();
                isValid = false;
            } else if (imageFile.size > maxSize) {
                $('#artistImageFile').addClass('is-invalid');
                $('#artistImageFile').next('.invalid-feedback').text('File too large. Max 2MB allowed.').show();
                isValid = false;
            }
        }

        if (isValid) {
            // If all valid, submit the form
            this.submit();
        } else {
            // Show first error field
            $('.is-invalid').first().focus();
        }
    });

    // Real-time validation for name and country
    $('#artistName, #country').on('input', function() {
        const value = $(this).val().trim();
        const specialChars = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/;
        
        if (value === '') {
            $(this).removeClass('is-invalid');
            $(this).next('.invalid-feedback').hide();
        } else if (specialChars.test(value)) {
            $(this).addClass('is-invalid');
            $(this).next('.invalid-feedback').text('Special characters are not allowed').show();
        } else {
            $(this).removeClass('is-invalid');
            $(this).next('.invalid-feedback').hide();
        }
    });

    // Real-time validation for select fields
    $('#language').on('change', function() {
        if ($(this).val() === null || $(this).val() === '') {
            $(this).addClass('is-invalid');
            $(this).next('.invalid-feedback').text('Please select a language').show();
        } else {
            $(this).removeClass('is-invalid');
            $(this).next('.invalid-feedback').hide();
        }
    });

    $('#genres').on('change', function() {
        if ($(this).val() === null || $(this).val().length === 0) {
            $(this).addClass('is-invalid');
            $(this).next('.select2-container').addClass('is-invalid');
            $(this).nextAll('.invalid-feedback').text('Please select at least one genre').show();
        } else {
            $(this).removeClass('is-invalid');
            $(this).next('.select2-container').removeClass('is-invalid');
            $(this).nextAll('.invalid-feedback').hide();
        }
    });
});
                
                // Toggle dropdown function
                window.toggledropdown = function() {
                    $('.profile-dropdown').toggle();
                };
                
                // Close dropdown when clicking elsewhere
                $(document).on('click', function(e) {
                    if (!$(e.target).closest('.user-menu').length) {
                        $('.profile-dropdown').hide();
                    }
                });
            });
        </script>
    </body>
    </html>