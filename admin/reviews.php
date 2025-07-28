<?php

session_start();

if(!isset($_SESSION['role']) && $_SESSION['role'] != "admin"){
    header('Location: ../user/Pages/verification/logout.php');
}

include 'connection.php';

$sql = "SELECT * FROM ratings";
$results = mysqli_query($con, $sql);

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <title>Reviews Management | SOUND Group</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
  <link rel="icon" type="image/png" href="uploads/icon/favicon.png">
    <?php
    include 'head-css.php';
    ?>
    <style>
        
        
        #wrapper {
            display: flex;
            min-height: 100vh;
        }
        
        /* Main Content */
        #content {
            width: 100%;
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
            color: #333;
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
            color: var(--lighter);
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
        
        /* User info styling */
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
        
        /* Rating stars */
        .rating-stars {
            display: flex;
            gap: 2px;
        }
        
        .rating-stars .bi-star-fill {
            color: #ffc107;
        }
        
        .rating-stars .bi-star {
            color: rgba(255, 255, 255, 0.2);
        }
        
        /* Review text */
        .review-text {
            line-height: 1.6;
            max-height: 3.2em;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            transition: all 0.3s ease;
        }
        
        .review-text.expanded {
            max-height: none;
            -webkit-line-clamp: unset;
        }
        
        .read-more-btn {
            background: none;
            border: none;
            color: var(--primary);
            padding: 0;
            margin-top: 5px;
            cursor: pointer;
            font-size: 0.9rem;
            display: inline-block;
        }
        
        /* Status badges */
        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
            display: inline-block;
        }
        
        .status-published {
            background: rgba(29, 185, 84, 0.1);
            color: var(--success);
        }
        
        .status-pending {
            background: rgba(255, 193, 7, 0.1);
            color: #ffc107;
        }
        
        .status-hidden {
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
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
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
        
        /* Stats cards */
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: rgba(30, 30, 46, 0.6);
            backdrop-filter: blur(12px);
            border-radius: 15px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            padding: 20px;
            display: flex;
            flex-direction: column;
        }
        
        .stat-value {
            font-size: 2.5rem;
            font-weight: 700;
            margin: 10px 0;
            color: var(--lighter);
        }
        
        .stat-label {
            color: var(--light);
            font-size: 0.95rem;
        }
        
        .stat-trend {
            display: flex;
            align-items: center;
            gap: 5px;
            margin-top: 10px;
            font-size: 0.9rem;
        }
        
        .trend-up {
            color: var(--success);
        }
        
        .trend-down {
            color: #ff4d4d;
        }



        .dropdown-menu{
                transform: translate3d(-35px, -5px, 0px) !important;
        }
    </style>
</head>
<body>
    <?php
  include 'admin-header.php'
  ?>
    
    <div id="wrapper">

    <?php
        include 'sidebar.php';
        ?>
        <!-- Main Content -->
        <div id="content">
            <!-- Topbar -->
            <div class="topbar">
                <div>
                    <h2 class="page-title">Reviews</h2>
                    <p class="text-muted mb-0">Manage user reviews and ratings</p>
                </div>
                
                <div class="user-menu" onclick='toggledropdown()'>
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
            
            
            <!-- Reviews Content -->
            <div class="card">
                <div class="card-header">
                    <h5><i class="bi bi-star"></i> User Reviews</h5>
                </div>
                <div class="card-body">
                    <div class="table-container">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Rating</th>
                                    <th>Review</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
if (mysqli_num_rows($results) > 0) {
    while ($rows = mysqli_fetch_assoc($results)) {
        $user_id = $rows['user_id'];

        // Get user's name from user_data table
        $user_sql = "SELECT name FROM user_data WHERE id = $user_id";
        $user_result = mysqli_query($con, $user_sql);
        $user = mysqli_fetch_assoc($user_result);
        $user_name = $user ? $user['name'] : 'Unknown';

        if ($rows['rating'] == 5) {
    $stars = '<i class="bi bi-star-fill"></i>
              <i class="bi bi-star-fill"></i>
              <i class="bi bi-star-fill"></i>
              <i class="bi bi-star-fill"></i>
              <i class="bi bi-star-fill"></i>';
} else if ($rows['rating'] == 4) {
    $stars = '<i class="bi bi-star-fill"></i>
              <i class="bi bi-star-fill"></i>
              <i class="bi bi-star-fill"></i>
              <i class="bi bi-star-fill"></i>';
} else if ($rows['rating'] == 3) {
    $stars = '<i class="bi bi-star-fill"></i>
              <i class="bi bi-star-fill"></i>
              <i class="bi bi-star-fill"></i>';
} else if ($rows['rating'] == 2) {
    $stars = '<i class="bi bi-star-fill"></i>
              <i class="bi bi-star-fill"></i>';
} else if ($rows['rating'] == 1) {
    $stars = '<i class="bi bi-star-fill"></i>';
} else {
    $stars = 'No Star Rating';
}


        echo '<tr>
            <td>
                <div class="user-info-row">
                    <div class="user-avatar-sm" style="background: linear-gradient(45deg, #405DE6, #E1306C);">
                        ' . strtoupper(substr($user_name, 0, 1)) . '
                    </div>
                    <div class="user-details">
                        <div class="user-name-row">' . htmlspecialchars($user_name) . '</div>
                        <div class="user-meta">
                            <span>' . $rows['user_id'] . '</span>
                        </div>
                    </div>
                </div>
            </td>
            <td>' . $rows['item_name'] . '</td>
            <td>' . $rows['item_type'] . '</td>
            <td>
                <div class="rating-stars">
                    ' . $stars . '
                </div>
            </td>
            <td>
                <div class="review-text">
                    ' . $rows['review'] . '
                </div>
            </td>
            <td>' . substr($rows['created_at'], 0, 10) . '</td>
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



        // Read more functionality
        document.querySelectorAll('.read-more-btn').forEach(button => {
            button.addEventListener('click', function() {
                const reviewText = this.previousElementSibling;
                reviewText.classList.toggle('expanded');
                
                if (reviewText.classList.contains('expanded')) {
                    this.textContent = 'Show less';
                } else {
                    this.textContent = 'Read more';
                }
            });
        });
        
        // Approve button functionality
        document.querySelectorAll('.btn-primary[title="Approve"]').forEach(button => {
            button.addEventListener('click', function() {
                const row = this.closest('tr');
                const statusBadge = row.querySelector('.status-badge');
                
                // Change status to published
                statusBadge.textContent = 'Published';
                statusBadge.className = 'status-badge status-published';
                
                // Remove approve button
                this.remove();
                
                // Show success message
                const successMsg = document.createElement('div');
                successMsg.className = 'alert-success-msg fade-in';
                successMsg.innerHTML = '✅ Review approved successfully!';
                document.body.appendChild(successMsg);
                
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
        
        // Toggle visibility functionality
        document.querySelectorAll('.btn-outline[title="Hide"], .btn-outline[title="Show"]').forEach(button => {
            button.addEventListener('click', function() {
                const row = this.closest('tr');
                const statusBadge = row.querySelector('.status-badge');
                const icon = this.querySelector('i');
                
                if (this.title === 'Hide') {
                    statusBadge.textContent = 'Hidden';
                    statusBadge.className = 'status-badge status-hidden';
                    this.title = 'Show';
                    icon.className = 'bi bi-eye';
                } else {
                    statusBadge.textContent = 'Published';
                    statusBadge.className = 'status-badge status-published';
                    this.title = 'Hide';
                    icon.className = 'bi bi-eye-slash';
                }
            });
        });
        
        // Delete functionality
        document.querySelectorAll('.btn-outline[title="Delete"]').forEach(button => {
            button.addEventListener('click', function() {
                if (confirm('Are you sure you want to delete this review? This action cannot be undone.')) {
                    const row = this.closest('tr');
                    row.style.opacity = '0.5';
                    
                    setTimeout(() => {
                        row.remove();
                        
                        // Show success message
                        const successMsg = document.createElement('div');
                        successMsg.className = 'alert-success-msg fade-in';
                        successMsg.innerHTML = '🗑️ Review deleted successfully!';
                        document.body.appendChild(successMsg);
                        
                        // Remove success message after 3 seconds
                        setTimeout(() => {
                            successMsg.style.transition = 'opacity 1s ease';
                            successMsg.style.opacity = '0';
                            
                            // Remove after fade completes
                            setTimeout(() => {
                                successMsg.remove();
                            }, 1000);
                        }, 3000);
                    }, 300);
                }
            });
        });

        document.querySelector('.nav-link.active').classList.remove('active');
        document.querySelector('.nav-link[data-page="reviews"]').classList.add('active');
        
        
    </script>
</body>
</html>