<?php

include 'connection.php';

session_start();

if(!isset($_SESSION['role']) && $_SESSION['role'] != "admin"){
    header('Location: ../user/Pages/verification/logout.php');
}

$sql = "SELECT * FROM user_data WHERE id != 1";
$results = mysqli_query($con, $sql);

?>







<!DOCTYPE html>
<html lang="en">
<head>
    <title>Users Management | SOUND Group</title>
  <link rel="icon" type="image/png" href="uploads/icon/favicon.png">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <?php
    include 'head-css.php';
    ?>
    <style>
        

        #wrapper {
            display: flex;
            min-height: 100vh;
        }
        
        /* Sidebar Styles */
       
        
        /* Main Content */
        #content {
            width: calc(100% - 250px);
            margin-left: 250px;
            padding: 25px;
            transition: all 0.3s ease;
        }
        
        
        
        /* Card Styling */
        .card {
            background: rgba(30, 30, 46, 0.6);
            backdrop-filter: blur(12px);
            border-radius: 15px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.3);
            margin-bottom: 30px;
            transition: all 0.3s ease;
            overflow: hidden;
        }
        
        .card-header {
            background: rgba(0, 0, 0, 0.15);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding: 18px 25px;
            font-weight: 600;
            font-size: 18px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .card-header h5 {
            margin: 0;
            font-weight: 600;
            color: var(--lighter);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .card-header h5 i {
            color: var(--primary);
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
        .form-control:focus, .form-select:focus {
            background: #fff !important;
            border-color: var(--primary);
            box-shadow: 0 0 0 0.25rem rgba(64, 93, 230, 0.2);
        }
        
        /* Table styling - Songs-like design */
        .table-container {
            overflow-x: auto;
        }
        
        .table {
            margin-bottom: 0;
            border-collapse: separate;
            border-spacing: 0;
            width: 100%;
            color: var(--lighter);
        }
        
        .table thead {
            position: sticky;
            top: 0;
            z-index: 10;
            /* background: rgba(30, 30, 46, 0.9); */
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
        
        /* User info styling - Songs-like */
        .user-info-row {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .user-avatar-sm {
            width: 45px;
            height: 45px;
            border-radius: 6px;
            object-fit: cover;
            flex-shrink: 0;
            background: linear-gradient(45deg, var(--primary), var(--secondary));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 18px;
        }
        
        .user-details {
            flex: 1;
        }
        
        .user-name-row {
            font-weight: 600;
            margin-bottom: 3px;
            color: var(--lighter);
        }
        
        .user-meta {
            font-size: 0.85rem;
            color: var(--light);
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .user-meta .role-tag {
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
            color: #4d7cff;
        }
        
        .status-pending {
            background: rgba(255, 193, 7, 0.1);
            color: #ffc107;
        }
        
        .status-inactive {
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545;
        }
        
        /* Action buttons - Songs-like */
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
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: var(--light);
            transition: all 0.2s ease;
        }
        
        .action-buttons .btn:hover {
            background: rgba(225, 48, 108, 0.2);
            transform: translateY(-2px);
        }
        
        .action-buttons .btn-primary {
            background: rgba(64, 93, 230, 0.2);
            color: var(--primary);
            border: 1px solid rgba(64, 93, 230, 0.3);
        }
        
        .action-buttons .btn-primary:hover {
            background: rgba(64, 93, 230, 0.3);
        }
        
        /* Modal Styling - Dashboard-like */
        .modal-content {
            background: rgba(30, 30, 46, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            color: var(--lighter);
            box-shadow: 0 20px 30px rgba(0, 0, 0, 0.3);
        }
        
        .modal-header {
            background: linear-gradient(45deg, var(--primary), var(--secondary));
            color: white;
            border-radius: 15px 15px 0 0 !important;
            border-bottom: none;
            padding: 20px;
        }
        
        .modal-title {
            font-weight: 600;
            font-size: 1.5rem;
        }
        
        .btn-close {
            filter: invert(1);
        }
        
        .modal-body {
            padding: 25px;
        }
        
        .modal-footer {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding: 15px 25px;
        }
        
        .user-detail-label {
            color: var(--light);
            font-weight: 500;
            margin-bottom: 5px;
            font-size: 0.9rem;
        }
        
        .user-detail-value {
            font-size: 1.1rem;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .last-login {
            font-size: 0.9rem;
            color: var(--light);
        }
        
        /* Responsive adjustments */
        @media (max-width: 992px) {
            #sidebar {
                width: 80px;
            }
            
            #sidebar .nav-link span {
                display: none;
            }
            
            #sidebar .sidebar-header h3 span {
                display: none;
            }
            
            #content {
                width: calc(100% - 80px);
                margin-left: 80px;
            }
        }
        
        @media (max-width: 768px) {
            #sidebar {
                width: 0;
            }
            
            #content {
                width: 100%;
                margin-left: 0;
            }
            
            .topbar {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
            
            .card-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
            
            .search-bar {
                max-width: 100%;
            }
            
            .action-buttons {
                flex-wrap: wrap;
            }
        }
        
        /* Animation for success message */
        .alert-success-msg {
            position: fixed;
            top: 20px;
            right: 20px;
            background: linear-gradient(45deg, #1DB954, #0d8a3d);
            color: white;
            padding: 15px 25px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            z-index: 1050;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .fade-in {
            animation: fadeIn 0.5s ease-out forwards;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        ul.dropdown-menu.dropdown-menu-end.profile-dropdown {
    top: -7rem !important;
    right: -1.5rem !important;
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
            <div class="topbar">
                <div>
                    <h2 class="page-title">Users</h2>
                    <p class="text-muted mb-0">Manage user accounts and permissions</p>
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
            
            <!-- Users Content -->
            <div class="page-section active" id="users">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="bi bi-people"></i> User Management</h5>
                        <div class="d-flex">
                            <!-- Removed Add New User button -->
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-container">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>User</th>
                                        <th>Email</th>
                                        <th>Joined</th>
                                        <th>Phone</th>
                                        <th>Address</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    if (mysqli_num_rows($results) > 0) {
                                            while ($rows = mysqli_fetch_assoc($results)) {
                                                echo '<tr>
                                        <td>
                                            <div class="user-info-row">
                                                <div class="user-avatar-sm" style="background: linear-gradient(45deg, #405DE6, #E1306C);">
                                                    '. strtoupper(substr($rows['name'], 0, 1)) .'
                                                </div>
                                                <div class="user-details">
                                                    <div class="user-name-row">' . $rows['name'] . '</div>
                                                    <div class="user-meta">
                                                        <span>ID: ' . $rows['id'] . '</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>' . $rows['email'] . '</td>
                                        <td>' . substr($rows['created_at'], 0, 10) . '</td>
                                        <td>' . $rows['phone'] . '</td>
                                        <td>' . $rows['address'] . '</td>
                                        <td>
                                            <div class="action-buttons">
                                                <button class="btn btn-outline" title="View" data-bs-toggle="modal" data-bs-target="#viewUserModal">
                                                    <i class="bi bi-eye"></i>
                                                </button>
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

    <!-- View User Modal - Dashboard Style -->
    <div class="modal fade" id="viewUserModal" tabindex="-1" aria-labelledby="viewUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewUserModalLabel">User Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex align-items-center mb-4">
                        <div class="user-avatar-sm" style="width: 80px; height: 80px; background: linear-gradient(45deg, #405DE6, #E1306C); font-size: 32px;">
                            MC
                        </div>
                        <div class="ms-4">
                            <h3>Michael Chen</h3>
                            <div class="text-muted">michael@example.com</div>
                            <div class="mt-2">
                                <span class="status-badge status-active">Active</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="user-detail-label">Account ID</div>
                            <div class="user-detail-value">MC-245</div>
                            
                            <div class="user-detail-label">Account Created</div>
                            <div class="user-detail-value">June 10, 2023</div>
                            
                            <div class="user-detail-label">Last Login</div>
                            <div class="user-detail-value">Today at 3:45 PM</div>
                        </div>
                        <div class="col-md-6">
                            <div class="user-detail-label">Subscription Plan</div>
                            <div class="user-detail-value">Premium (Annual)</div>
                            
                            <div class="user-detail-label">Playlists</div>
                            <div class="user-detail-value">12 playlists</div>
                            
                            <div class="user-detail-label">Total Plays</div>
                            <div class="user-detail-value">1,245 plays</div>
                        </div>
                    </div>
                    
                    <div class="user-detail-label mt-3">Favorite Genres</div>
                    <div class="d-flex gap-2">
                        <span class="badge" style="background: rgba(64, 93, 230, 0.1); color: var(--primary);">Pop</span>
                        <span class="badge" style="background: rgba(64, 93, 230, 0.1); color: var(--primary);">Rock</span>
                        <span class="badge" style="background: rgba(64, 93, 230, 0.1); color: var(--primary);">Electronic</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    
    
    <?php
    include 'js-scripts.php';
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Set active navigation item
        document.querySelector('.nav-link.active').classList.remove('active');
        document.querySelector('.nav-link[data-page="users"]').classList.add('active');
        
        function toggledropdown() {
            const dropdown = document.querySelector('.dropdown-menu');
            if (dropdown.style.display === 'block') {
                dropdown.style.display = 'none';
            } else {
                dropdown.style.display = 'block';
            }
        }

        // Save changes button functionality
        document.getElementById('saveChangesBtn').addEventListener('click', function() {
            // Show success message
            const successMsg = document.createElement('div');
            successMsg.className = 'alert-success-msg fade-in';
            successMsg.innerHTML = '✅ User status updated successfully!';
            document.body.appendChild(successMsg);
            
            // Close modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('editUserModal'));
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
        
        // Populate modals with user data
        const viewButtons = document.querySelectorAll('[data-bs-target="#viewUserModal"]');
        viewButtons.forEach(button => {
            button.addEventListener('click', function() {
                const row = this.closest('tr');
                const name = row.querySelector('.user-name-row').textContent;
                const email = row.cells[1].textContent;
                const role = row.cells[2].textContent;
                const joinDate = row.cells[3].textContent;
                const status = row.querySelector('.status-badge').textContent;
                const initials = row.querySelector('.user-avatar-sm').textContent;
                
                // Update modal content
                const viewModal = document.querySelector('#viewUserModal');
                viewModal.querySelector('.modal-title').textContent = `${name} Details`;
                viewModal.querySelector('h3').textContent = name;
                viewModal.querySelector('.text-muted').textContent = email;
                viewModal.querySelector('.status-badge').textContent = status;
                viewModal.querySelector('.status-badge').className = `status-badge status-${status.toLowerCase()}`;
                viewModal.querySelector('.user-avatar-sm').textContent = initials;
                
                // Set user details
                viewModal.querySelector('.user-detail-value:nth-child(2)').textContent = role;
                viewModal.querySelector('.user-detail-value:nth-child(4)').textContent = joinDate;
            });
        });
        
        
    </script>
</body>
</html>