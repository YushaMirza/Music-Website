<?php
include 'connection.php';

session_start();

if(!isset($_SESSION['role']) && $_SESSION['role'] != "admin"){
    header('Location: ../user/Pages/verification/logout.php');
}

$sql_user = "SELECT * FROM user_data WHERE id != 1";
$user_results = mysqli_query($con, $sql_user);

$sql_rev_user = "SELECT * FROM user_data WHERE id != 1 ORDER BY id DESC";
$user_rev_results = mysqli_query($con, $sql_rev_user);

$sql_songs = "SELECT * FROM songs";
$song_results = mysqli_query($con, $sql_songs);

$sql_videos = "SELECT * FROM videos";
$video_results = mysqli_query($con, $sql_videos);

$sql_artists = "SELECT * FROM artists";
$artist_results = mysqli_query($con, $sql_artists);


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $type = isset($_POST['type']) ? trim($_POST['type']) : '';
    $value = isset($_POST['value']) ? trim($_POST['value']) : '';

    // ✅ Check if both fields are filled
    if (!empty($type) && !empty($value)) {
        $query = "INSERT INTO categories (type, value) VALUES ('$type', '$value')";
        $result = mysqli_query($con, $query);

        if ($result) {
            // ✅ Success - Redirect to same page to prevent resubmission
            header("Location: dashboard.php?success=1");
            exit();
        } else {
            echo "<script>alert('Error adding category.');</script>";
        }
    } else {
        // ❌ Fields empty
        echo "<script>alert('Please select category type and enter value.');</script>";
    }
}

?>






<?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
    <div id="successMessage" class="alert-success-msg">
        ✅ Category added successfully!
    </div>

    <script>
        // ✅ Wait 3 seconds, then fade out
        setTimeout(() => {
            const msg = document.getElementById("successMessage");
            if (msg) {
                msg.style.transition = "opacity 1s ease";
                msg.style.opacity = "0";

                // ✅ After fade completes, remove it from layout
                setTimeout(() => {
                    msg.style.display = "none";
                }, 1000);
            }
        }, 3000);

        // ✅ Clean URL (?success=1) after showing message
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.pathname);
        }
    </script>
<?php endif; ?>












<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Dashboard | SOUND Group</title>
  <link rel="icon" type="image/png" href="uploads/icon/favicon.png">
    <?php
    include 'head-css.php';
    ?>

    <style>

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
            margin-right: 25px;
        }

.table tbody td{
    padding: 15px 20px;
    vertical-align: middle;
    background-color: unset;
    color: white;
}

        
        .user-detail-row {
            display: flex;
            padding: 12px 0;
            border-bottom: 1px solid #e9ecef;
        }
        
        .user-detail-row:last-child {
            border-bottom: none;
        }
        
        .user-detail-label {
            width: 160px;
            font-weight: 500;
            color: #6c757d;
        }
        
        .user-detail-value {
            flex: 1;
        }
        
        /* Animations */
        .fade-in {
            opacity: 0;
            animation: fadeIn 0.8s ease forwards;
        }
        
        .delay-1 { animation-delay: 0.2s; }
        .delay-2 { animation-delay: 0.4s; }
        .delay-3 { animation-delay: 0.6s; }
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
            <?php
    include 'topbar.php';
    ?>
            
            <!-- Dashboard Content -->
            <div class="page-section active" id="dashboard">
                <!-- Stats Overview -->
                 <?php
        if(mysqli_num_rows($song_results) <= 10 || mysqli_num_rows($video_results) <= 10 || mysqli_num_rows($artist_results) <= 10 || mysqli_num_rows($user_results) <= 10){
          $users = mysqli_num_rows($user_results);
          $songs = mysqli_num_rows($song_results);
          $videos = mysqli_num_rows($video_results);
          $artists = mysqli_num_rows($artist_results);
        }else if(mysqli_num_rows($song_results) > 10 || mysqli_num_rows($video_results) > 10 || mysqli_num_rows($artist_results) > 10 || mysqli_num_rows($user_results) > 10){
          $users = "10+";
          $songs = "10+";
          $videos = "10+";
          $artists = "10+";
        }else if(mysqli_num_rows($song_results) > 20 || mysqli_num_rows($video_results) > 20 || mysqli_num_rows($artist_results) > 20 || mysqli_num_rows($user_results) > 20){
          $users = "20+";
          $songs = "20+";
          $videos = "20+";
          $artists = "20+";
        }else if(mysqli_num_rows($song_results) > 30 || mysqli_num_rows($video_results) > 30 || mysqli_num_rows($artist_results) > 30 || mysqli_num_rows($user_results) > 30){
          $users = "30+";
          $songs = "30+";
          $videos = "30+";
          $artists = "30+";
        }else if(mysqli_num_rows($song_results) > 40 || mysqli_num_rows($video_results) > 40 || mysqli_num_rows($artist_results) > 40 || mysqli_num_rows($user_results) > 40){
          $users = "40+";
          $songs = "40+";
          $videos = "40+";
          $artists = "40+";
        }else if(mysqli_num_rows($song_results) > 50 || mysqli_num_rows($video_results) > 50 || mysqli_num_rows($artist_results) > 50 || mysqli_num_rows($user_results) > 50){
          $users = "50+";
          $songs = "50+";
          $videos = "50+";
          $artists = "50+";
        }
        ?>
                <div class="row mb-4">
                    <div class="col-md-3 col-sm-6 mb-4 fade-in">
                        <div class="stat-card">
                            <div class="stat-icon users">
                                <i class="bi bi-people"></i>
                            </div>
                            <div class="stat-value"><?php echo $users ?></div>
                            <div class="stat-label">Total Users</div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-4 fade-in delay-1">
                        <div class="stat-card">
                            <div class="stat-icon songs">
                                <i class="bi bi-music-note-beamed"></i>
                            </div>
                            <div class="stat-value"><?php echo $songs ?></div>
                            <div class="stat-label">Songs</div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-4 fade-in delay-2">
                        <div class="stat-card">
                            <div class="stat-icon playlists">
                                <i class="bi bi-collection-play"></i>
                            </div>
                            <div class="stat-value"><?php echo $videos ?></div>
                            <div class="stat-label">Videos</div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-4 fade-in delay-3">
                        <div class="stat-card">
                            <div class="stat-icon revenue">
                                <i class="bi bi-currency-dollar"></i>
                            </div>
                            <div class="stat-value"><?php echo $artists ?></div>
                            <div class="stat-label">Artists</div>
                        </div>
                    </div>
                </div>
                
                <!-- Charts Row -->
                <div class="row mb-4">
                    <div class="col-lg-8 mb-4 fade-in">
                        <div class="card">
                            <div class="card-header">
                                <h5><i class="bi bi-graph-up"></i> Monthly Analytics</h5>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-sm btn-outline">Last Month</button>
                                    <button class="btn btn-sm btn-primary">This Month</button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="chart-container">
                                    <canvas id="analyticsChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 mb-4 fade-in delay-1">
                        <div class="card">
                            <div class="card-header">
                                <h5><i class="bi bi-pie-chart"></i> User Distribution</h5>
                            </div>
                            <div class="card-body">
                                <div class="chart-container">
                                    <canvas id="userChart"></canvas>
                                </div>
                                <div class="mt-4">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <div><span class="d-inline-block me-2" style="width:12px;height:12px;background:#405DE6;border-radius:2px;"></span> Free Users</div>
                                        <div class="fw-medium">65%</div>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <div><span class="d-inline-block me-2" style="width:12px;height:12px;background:#E1306C;border-radius:2px;"></span> Premium Users</div>
                                        <div class="fw-medium">25%</div>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <div><span class="d-inline-block me-2" style="width:12px;height:12px;background:#1DB954;border-radius:2px;"></span> Artists</div>
                                        <div class="fw-medium">8%</div>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div><span class="d-inline-block me-2" style="width:12px;height:12px;background:#FFC107;border-radius:2px;"></span> Admins</div>
                                        <div class="fw-medium">2%</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Recent Users -->
                <div class="row">
                    <div class="col-lg-8 mb-4 fade-in">
                        <div class="card">
                            <div class="card-header">
                                <h5><i class="bi bi-people"></i> Recent Users</h5>
                                <button onclick="location.href='users.php'" class="btn btn-sm btn-outline">View All</button>
                            </div>
                            <div class="card-body">
                                <div class="table-container">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>User</th>
                                                <th>Joined</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (mysqli_num_rows($user_rev_results) > 0) {
          while ($rows = mysqli_fetch_assoc($user_rev_results)) {
            echo '
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="user-avatar-sm" style="background: linear-gradient(45deg, #405DE6, #E1306C);">
                                                    '. strtoupper(substr($rows['name'], 0, 1)) .'
                                                </div>
                                                        <div>
                                                            <div>' . $rows["name"] . '</div>
                                                            <small class="text-muted">' . $rows["email"] . '</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>' . substr($rows["created_at"], 0, 10) . '</td>
                                                <td><span class="status-badge status-active">Active</span></td>
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
                    
                    <!-- Add New Playlist -->
                    <div class="col-lg-4 mb-4 fade-in delay-1">

                        <!-- Quick Stats -->
                        <div class="card mt-4 quick-stats">
                            <div class="card-header">
                                <h5><i class="bi bi-lightning"></i> Quick Stats</h5>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-3">
                                    <div>Active Sessions</div>
                                    <div class="fw-medium">1,248</div>
                                </div>
                                <div class="d-flex justify-content-between mb-3">
                                    <div>Avg. Session Duration</div>
                                    <div class="fw-medium">12m 42s</div>
                                </div>
                                <div class="d-flex justify-content-between mb-3">
                                    <div>Songs Played Today</div>
                                    <div class="fw-medium">42,817</div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <div>New Users Today</div>
                                    <div class="fw-medium">187</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
<script>
    document.querySelectorAll('.view-user').forEach(button => {
            button.addEventListener('click', function() {
                const row = this.closest('tr');
                
                // Extract user data from the table row
                const avatar = row.querySelector('.user-avatar').src;
                const name = row.querySelector('td > div > div:first-child').textContent;
                const email = row.querySelector('td > div > small').textContent;
                const joinDate = row.querySelector('td:nth-child(2)').textContent;
                const status = row.querySelector('.status-badge').textContent;
                const statusClass = row.querySelector('.status-badge').classList.contains('status-active') ? 
                    'status-active' : 'status-pending';
                
                // Update modal content
                document.getElementById('detailUserAvatar').src = avatar;
                document.getElementById('detailUserName').textContent = name;
                document.getElementById('detailUserEmail').textContent = email;
                document.getElementById('detailJoinDate').textContent = joinDate;
                document.getElementById('detailUserStatus').textContent = status;
                document.getElementById('detailUserStatus').className = `status-badge ${statusClass}`;
            });
        });
</script>
    <?php
    include 'js-scripts.php';
    ?>
    
</body>
</html>