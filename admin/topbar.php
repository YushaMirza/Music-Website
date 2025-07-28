<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="topbar">
     <div>
       <h2 class="page-title">Dashboard Overview</h2>
       <p class="text-muted mb-0 page-subtitle">Welcome back, Administrator. Here's what's happening today.</p>
     </div>
                
      <div class="d-flex align-items-center gap-4">
                    
   <div class="user-menu admin-usermenu">
  <div class="dropdown">
    <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
      <div class="user-avatar <?php echo  'guest'; ?>">
        <?php 
            echo 'A';
        ?>
      </div>
      <span class="user-name admin-username ms-2">
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
            </div>
</body>
</html>