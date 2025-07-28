<?php
include '../connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate required fields
    $required = ['title', 'artist', 'year'];
    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            header("Location: ../albums.php?error=" . urlencode("$field is required"));
            exit();
        }
    }

    // Sanitize inputs
    $albumtitle = mysqli_real_escape_string($con, trim($_POST['title']));
    $artist = mysqli_real_escape_string($con, trim($_POST['artist']));
    $year = mysqli_real_escape_string($con, trim($_POST['year']));
    $desc = isset($_POST['desc']) ? mysqli_real_escape_string($con, trim($_POST['desc'])) : '';
    $status = 'published';
    
    // Validate title for special characters
    if (preg_match('/[!@#$%^&*()_+\-=\[\]{};\'\\|,.<>\/?]+/', $albumtitle)) {
        header("Location: ../albums.php?error=" . urlencode("Special characters are not allowed in album title"));
        exit();
    }

    // Validate year format
    if (!preg_match('/^[1-2][0-9]{3}$/', $year) || $year < 1900 || $year > 2025) {
        header("Location: ../albums.php?error=" . urlencode("Invalid year format (1900-2025)"));
        exit();
    }

    // Handle songs and videos
    $songs = isset($_POST['songs']) && is_array($_POST['songs']) ? 
             mysqli_real_escape_string($con, implode(', ', $_POST['songs'])) : '';
    $videos = isset($_POST['videos']) && is_array($_POST['videos']) ? 
              mysqli_real_escape_string($con, implode(', ', $_POST['videos'])) : '';

    // Handle file upload
    if (!isset($_FILES["albumcover"]) || $_FILES["albumcover"]["error"] != UPLOAD_ERR_OK) {
        header("Location: ../albums.php?error=" . urlencode("Album cover is required"));
        exit();
    }

    $target_dir = "../uploads/albumscover/";
    $file = $_FILES["albumcover"];

    // Validate image
    $validTypes = ['image/jpeg', 'image/png'];
    $maxSize = 2 * 1024 * 1024; // 2MB

    if (!in_array($file['type'], $validTypes)) {
        header("Location: ../albums.php?error=" . urlencode("Invalid image type (JPG/PNG only)"));
        exit();
    }

    if ($file['size'] > $maxSize) {
        header("Location: ../albums.php?error=" . urlencode("Image too large (max 2MB)"));
        exit();
    }

    // Generate unique filename
    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = uniqid() . '.' . $ext;
    $target_file = $target_dir . $filename;

    if (!move_uploaded_file($file['tmp_name'], $target_file)) {
        header("Location: ../albums.php?error=" . urlencode("Error uploading cover image"));
        exit();
    }

    // Insert into database
    $sql = "INSERT INTO albums (title, artist, cover_image, release_year, description, status, songs, videos)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "sssissss", 
        $albumtitle, $artist, $filename, $year, $desc, $status, $songs, $videos);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: ../albums.php?success=" . urlencode("Album added successfully"));
    } else {
        // Delete uploaded file if database insert failed
        @unlink($target_file);
        header("Location: ../albums.php?error=" . urlencode("Error adding album: " . mysqli_error($con)));
    }

    mysqli_stmt_close($stmt);
    mysqli_close($con);
} else {
    header("Location: ../albums.php");
}
exit();
?>