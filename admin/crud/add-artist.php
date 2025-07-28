<?php
include '../connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize inputs
    $name = mysqli_real_escape_string($con, trim($_POST['name']));
    $country = mysqli_real_escape_string($con, trim($_POST['country']));
    $language = mysqli_real_escape_string($con, $_POST['language']);
    $biography = mysqli_real_escape_string($con, trim($_POST['biography']));
    
    // Validate genres (ensure at least one is selected)
    $genres = [];
    if (isset($_POST['genres']) && is_array($_POST['genres'])) {
        $genres = array_map(function($genre) use ($con) {
            return mysqli_real_escape_string($con, trim($genre));
        }, $_POST['genres']);
    }
    
    if (empty($genres)) {
        header("Location: ../artists.php?error=Please select at least one genre");
        exit();
    }
    
    $genres_str = implode(', ', $genres);
    $status = 'active';
    
    // Validate file upload
    if (!isset($_FILES["artistImageFile"]) || $_FILES["artistImageFile"]["error"] != UPLOAD_ERR_OK) {
        header("Location: ../artists.php?error=Please upload a valid artist image");
        exit();
    }
    
    // Check file type and size
    $allowed_types = ['image/jpeg', 'image/png', 'image/jpg'];
    $max_size = 2 * 1024 * 1024; // 2MB
    $file_type = $_FILES["artistImageFile"]["type"];
    $file_size = $_FILES["artistImageFile"]["size"];
    
    if (!in_array($file_type, $allowed_types)) {
        header("Location: ../artists.php?error=Invalid file type. Only JPG, PNG, JPEG allowed.");
        exit();
    }
    
    if ($file_size > $max_size) {
        header("Location: ../artists.php?error=File too large. Max 2MB allowed.");
        exit();
    }
    
    // Handle file upload
    $target_dir = "../uploads/artists/";
    $filename = uniqid() . '_' . basename($_FILES["artistImageFile"]["name"]);
    $target_file = $target_dir . $filename;
    
    if (!move_uploaded_file($_FILES["artistImageFile"]["tmp_name"], $target_file)) {
        header("Location: ../artists.php?error=Error uploading file");
        exit();
    }
    
    // Insert into database
    $sql = "INSERT INTO artists (name, country, language, genres, biography, image, status)
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "sssssss", $name, $country, $language, $genres_str, $biography, $filename, $status);
    
    if (mysqli_stmt_execute($stmt)) {
        header("Location: ../artists.php?success=Artist added successfully");
    } else {
        // Delete the uploaded file if database insert failed
        @unlink($target_file);
        header("Location: ../artists.php?error=Error adding artist: " . mysqli_error($con));
    }
    
    mysqli_stmt_close($stmt);
    mysqli_close($con);
} else {
    header("Location: ../artists.php?error=Invalid request method");
}
?>