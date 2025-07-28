<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --primary: #E1306C;
            --secondary: #405DE6;
            --dark: #0f0f1a;
            --darker: #0a0a12;
            --medium: #171727;
            --light: #a0a0b0;
            --lighter: #f0f0ff;
            --sidebar-width: 260px;
            --card-radius: 16px;
            --transition: all 0.3s ease;
            --glass-bg: rgba(25, 25, 40, 0.6);
            --glass-border: rgba(255, 255, 255, 0.08);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, var(--darker) 0%, #1a1a2e 100%);
            color: var(--lighter);
            min-height: 100vh;
            overflow-x: hidden;
            background-attachment: fixed;
            line-height: 1.6;
        }

        #loginbtn1{
            display: none !important;
        }
        #loginbtn2{
            display: none !important;
        }

        .userheader{
            display: none;
        }

        .userprofile-menu{
                display: none !important;
                    z-index: 1111;
            }
            .admin-usermenu{
      display: block !important;
                z-index: 1111111 !important;
    }
    .admin-username{
        display: block !important;
    }

    .user-name-admin{
        display: block !important;
    }

        @media (max-width: 800px){
            .userheader{
                display: block;
            }

            #sidebar{
                display: none !important;
            }

            .admin-usermenu{
                display: none !important; 
            }

            

            .user-menu-admin{
                display: block !important;
            }

            .user-name-admin{
                display: block !important;
            }

            button.navbar-toggler-admin {
        right: 175px !important;
    }
        }

        @media (max-width: 600px){
            .user-name-admin{
                display: none !important;
            }

            .user-menu{
                z-index: 1111111 !important;
                width: 4rem !important;
            }

            button.navbar-toggler-admin {
        right: 100px !important;
    }
        }
        
        /* Sidebar - Glass Morphism */
        #sidebar {
            width: var(--sidebar-width);
            background: rgba(15, 15, 25, 0.75);
            backdrop-filter: blur(12px);
            border-right: 1px solid var(--glass-border);
            position: fixed;
            height: 100vh;
            z-index: 1000;
            transition: var(--transition);
            overflow-y: auto;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.3);
        }
        
        .sidebar-header {
            padding: 25px 20px;
            border-bottom: 1px solid var(--glass-border);
        }
        
        .sidebar-header h3 {
            font-size: 26px;
            font-weight: 700;
            color: var(--lighter);
            margin: 0;
            font-family: 'Montserrat', sans-serif;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .sidebar-header h3 i {
            color: var(--primary);
            background: rgba(225, 48, 108, 0.15);
            width: 40px;
            height: 40px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 15px rgba(225, 48, 108, 0.25);
        }
        
        .nav-link {
            color: var(--light);
            padding: 14px 25px;
            font-weight: 500;
            transition: var(--transition);
            border-left: 3px solid transparent;
            display: flex;
            align-items: center;
            gap: 15px;
            margin: 5px 15px;
            border-radius: 10px;
        }
        
        .nav-link:hover, .nav-link.active {
            color: var(--lighter);
            background: rgba(225, 48, 108, 0.15);
            border-left-color: var(--primary);
            transform: translateX(5px);
        }
        
        .nav-link i {
            font-size: 20px;
            width: 24px;
            text-align: center;
        }
        
        .nav-divider {
            height: 1px;
            background: var(--glass-border);
            margin: 15px 25px;
        }

        @media (max-width: 800px) {
    #sidebar {
        position: relative;
        width: 100%;
        height: auto;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        border-right: none;
        border-bottom: 1px solid var(--glass-border);
    }

    .nav {
        flex-direction: row;
        flex-wrap: wrap;
        margin: 10px 15px;
        gap: 10px;
    }

    .nav-item {
        margin: 0;
        justify-items: center !important;
    }

    .nav-link {
        padding: 10px 14px;
        margin: 0;
        border-left: none;
        border-radius: 8px;
    }

    .nav-link:hover, .nav-link.active {
        transform: none;
        border-left: none;
        background: rgba(225, 48, 108, 0.15);
    }
}

        
        /* Main Content */
        #content {
            width: calc(100% - var(--sidebar-width));
            margin-left: var(--sidebar-width);
            padding: 25px;
            transition: var(--transition);
        }
        
        /* Topbar with Glass Morphism */
        .topbar {
            background: var(--glass-bg);
            backdrop-filter: blur(12px);
            border-radius: var(--card-radius);
            padding: 20px 30px;
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.25);
            border: 1px solid var(--glass-border);
        }
        
        .page-title {
            font-size: 28px;
            font-weight: 700;
            margin: 0;
            font-family: 'Montserrat', sans-serif;
            position: relative;
            display: inline-block;
            background: linear-gradient(90deg, var(--primary) 0%, var(--secondary) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.5px;
        }
        
        .user-menu {
    display: flex;
    align-items: center;
    width: 9rem ;
    gap: 15px;
    position: relative;
    background-color: #4d496433;
    border-radius: 22px 10px 10px 22px;    
    }

    .user-avatar {
    width: 50px;
    height: 50px;
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
    font-size: 18px;
    font-weight: 500;
    color: var(--lighter);
}

.user-name:not(.logged-in) {
    opacity: 0.8;
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
    ul.dropdown-menu.dropdown-menu-end.show {
    top: -4rem !important;
    right: 1rem !important;
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
        
        .user-info {
            text-align: right;
        }
        
        .user-name {
            font-weight: 600;
            color: var(--lighter);
            font-size: 16px;
        }
        
        .user-role {
            color: var(--primary);
            font-size: 13px;
            font-weight: 500;
        }
        
        /* Cards with Glass Morphism */
        .card {
            background: var(--glass-bg);
            backdrop-filter: blur(12px);
            border-radius: var(--card-radius);
            border: 1px solid var(--glass-border);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.3);
            margin-bottom: 30px;
            transition: var(--transition);
            overflow: hidden;
        }
        
        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4);
        }
        
        .card-header {
            background: rgba(0, 0, 0, 0.15);
            border-bottom: 1px solid var(--glass-border);
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
            padding: 25px;
            color: #c4c4c4;
        }
        
        /* Stats Cards */
        .stat-card {
            text-align: center;
            padding: 25px 15px;
            border-radius: var(--card-radius);
            background: var(--glass-bg);
            backdrop-filter: blur(12px);
            border: 1px solid var(--glass-border);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            transition: var(--transition);
            height: 100%;
            position: relative;
            overflow: hidden;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.3);
        }
        
        .stat-card::before {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.05);
        }
        
        .stat-value {
            font-size: 36px;
            font-weight: 700;
            margin: 15px 0 5px;
            font-family: 'Montserrat', sans-serif;
            background: linear-gradient(90deg, var(--lighter) 0%, #a0a0ff 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .stat-label {
            color: #d0d0e0; /* Improved contrast */
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 500;
        }
        
        .stat-icon {
            width: 65px;
            height: 65px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            font-size: 28px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        
        .stat-icon.users {
            background: linear-gradient(135deg, rgba(64, 93, 230, 0.25) 0%, rgba(64, 93, 230, 0.1) 100%);
            color: #6c8cff;
        }
        
        .stat-icon.songs {
            background: linear-gradient(135deg, rgba(225, 48, 108, 0.25) 0%, rgba(225, 48, 108, 0.1) 100%);
            color: #ff6b9d;
        }
        
        .stat-icon.playlists {
            background: linear-gradient(135deg, rgba(40, 167, 69, 0.25) 0%, rgba(40, 167, 69, 0.1) 100%);
            color: #4ade80;
        }
        
        .stat-icon.revenue {
            background: linear-gradient(135deg, rgba(255, 193, 7, 0.25) 0%, rgba(255, 193, 7, 0.1) 100%);
            color: #ffd43b;
        }
        
        /* Charts */
        .chart-container {
            position: relative;
            height: 320px;
            width: 100%;
        }
        
        /* Tables */
        .table-container {
            overflow-x: auto;
            border-radius: 12px;
        }
        
        .table {
            color: var(--lighter);
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }
        
        .table thead th {
            background: rgba(225, 48, 108, 0.15);
            border-bottom: 1px solid var(--glass-border);
            font-weight: 600;
            padding: 16px 20px;
            position: sticky;
            top: 0;
            backdrop-filter: blur(10px);
        }
        
        .table tbody tr {
            border-bottom: 1px solid var(--glass-border);
            transition: var(--transition);
        }
        
        .table tbody tr:last-child {
            border-bottom: none;
        }
        
        .table tbody tr:hover {
            background: rgba(255, 255, 255, 0.05);
        }
        
        .table tbody td {
            padding: 15px 20px;
            vertical-align: middle;
        }
        
        .status-badge {
            padding: 6px 14px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 500;
            display: inline-block;
        }
        
        .status-active {
            background: rgba(40, 167, 69, 0.15);
            color: #4ade80;
        }
        
        .status-pending {
            background: rgba(255, 193, 7, 0.15);
            color: #ffd43b;
        }
        
        .status-inactive {
            background: rgba(108, 117, 125, 0.15);
            color: #a0a0b0;
        }
        
        /* Buttons */
        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            border: none;
            border-radius: 10px;
            padding: 10px 22px;
            font-weight: 500;
            transition: var(--transition);
            box-shadow: 0 5px 15px rgba(225, 48, 108, 0.3);
        }
        
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(225, 48, 108, 0.4);
        }
        
        .btn-outline {
            background: transparent;
            border: 1px solid var(--primary);
            color: var(--primary);
            border-radius: 10px;
            padding: 8px 18px;
            font-weight: 500;
            transition: var(--transition);
        }
        
        .btn-outline:hover {
            background: rgba(225, 48, 108, 0.15);
            transform: translateY(-3px);
        }
        
        .btn-sm {
            padding: 6px 14px;
            font-size: 13px;
        }
        
        /* Forms */
        .form-control, .form-select {
            background: rgba(30, 30, 46, 0.4);
            border: 1px solid var(--glass-border);
            color: var(--lighter);
            padding: 12px 16px;
            border-radius: 10px;
            transition: var(--transition);
            backdrop-filter: blur(5px);
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.25rem rgba(225, 48, 108, 0.25);
            background: rgba(30, 30, 46, 0.5);
            color: var(--lighter);
        }
        
        .form-label {
            font-weight: 500;
            color: var(--light);
            margin-bottom: 8px;
        }
        
        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .fade-in {
            animation: fadeIn 0.6s ease-out forwards;
        }
        
        .delay-1 { animation-delay: 0.1s; }
        .delay-2 { animation-delay: 0.2s; }
        .delay-3 { animation-delay: 0.3s; }
        .delay-4 { animation-delay: 0.4s; }
        
        /* Responsive Design */
        @media (max-width: 992px) {
            #sidebar {
                width: 80px;
                overflow: hidden;
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
            
            .sidebar-header h3 {
                justify-content: center;
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
            
            .user-menu {
                justify-content: space-between;
            }
        }
        
        /* Notification badge */
        .notification-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: var(--primary);
            color: white;
            border-radius: 50%;
            width: 22px;
            height: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 600;
            box-shadow: 0 3px 8px rgba(225, 48, 108, 0.4);
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
        
        .search-bar input:focus {
            background: #fff ;
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(225, 48, 108, 0.25);
        }
        /* Notification dropdown */
        .notification-dropdown {
            position: relative;
        }
        
        .notification-menu {
            position: absolute;
            top: 100%;
            right: 0;
            width: 350px;
            background: var(--glass-bg);
            backdrop-filter: blur(12px);
            border: 1px solid var(--glass-border);
            border-radius: var(--card-radius);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            z-index: 1000;
            display: none;
            max-height: 400px;
            overflow-y: auto;
        }
        
        .notification-header {
            padding: 15px 20px;
            border-bottom: 1px solid var(--glass-border);
            font-weight: 600;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .notification-item {
            padding: 15px 20px;
            border-bottom: 1px solid var(--glass-border);
            transition: var(--transition);
            cursor: pointer;
        }
        
        .notification-item:hover {
            background: rgba(255, 255, 255, 0.05);
        }
        
        .notification-item:last-child {
            border-bottom: none;
        }
        
        .notification-title {
            font-weight: 500;
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .notification-time {
            font-size: 12px;
            color: var(--light);
            margin-top: 5px;
        }
        
        /* Modals */
        .modal-content {
            background: var(--glass-bg);
            backdrop-filter: blur(12px);
            border: 1px solid var(--glass-border);
            border-radius: var(--card-radius);
            color: var(--lighter);
        }
        
        .modal-header {
            border-bottom: 1px solid var(--glass-border);
        }
        
        .modal-footer {
            border-top: 1px solid var(--glass-border);
        }
        
        .user-detail-row {
            display: flex;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--glass-border);
        }
        
        .user-detail-label {
            font-weight: 500;
            width: 120px;
            color: var(--light);
        }
        
        .user-detail-value {
            flex: 1;
            color: var(--lighter); /* Brighter text */
        }
        
        /* Text contrast improvements */
        .text-muted {
            color: #b0b0c0 !important; /* Brighter muted text */
        }
        
        .quick-stats .fw-medium {
            color: var(--lighter); /* Brighter text for quick stats */
        }
        
        /* User action buttons */
        .action-buttons .btn {
            padding: 5px 10px;
        }
        
        /* Graph visibility */
        canvas {
            display: block !important;
        }



        .alert-success-msg {
    background-color: #d1e7dd;
    color: #0f5132;
    border: 1px solid #badbcc;
    padding: 12px 18px;
    border-radius: 10px;
    font-weight: 500;
    margin-bottom: 20px;
    font-size: 16px;
    animation: fadeInSlideDown 0.5s ease-in-out;
}

/* Optional: smooth animation */
@keyframes fadeInSlideDown {
    0% {
        opacity: 0;
        transform: translateY(-10px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}

button#loginbtn1{
    display: none !important;
}
button#loginbtn2{
    display: none !important;
}
    </style>
</head>
<body>
    
</body>
</html>