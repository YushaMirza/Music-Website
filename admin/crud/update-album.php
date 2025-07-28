<?php
include '../connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate required fields
    $required = ['id', 'title', 'artist', 'year', 'status'];
    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            header("Location: ../albums.php?error=" . urlencode("$field is required"));
            exit();
        }
    }

    // Sanitize inputs
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $title = mysqli_real_escape_string($con, trim($_POST['title']));
    $artist = mysqli_real_escape_string($con, trim($_POST['artist']));
    $year = mysqli_real_escape_string($con, trim($_POST['year']));
    $description = isset($_POST['description']) ? mysqli_real_escape_string($con, trim($_POST['description'])) : '';
    $status = mysqli_real_escape_string($con, trim($_POST['status']));
    $existing_cover = mysqli_real_escape_string($con, trim($_POST['existing_cover']));

    // Validate title for special characters
    if (preg_match('/[!@#$%^&*()_+\-=\[\]{};\'\\|,.<>\/?]+/', $title)) {
        header("Location: ../albums.php?error=" . urlencode("Special characters are not allowed in album title"));
        exit();
    }

    // Validate year format
    if (!preg_match('/^[1-2][0-9]{3}$/', $year) || $year < 1900 || $year > 2025) {
        header("Location: ../albums.php?error=" . urlencode("Invalid year format (1900-2025)"));
        exit();
    }

    // Handle file upload if new one is provided
    $cover_image = $existing_cover;
    if (!empty($_FILES['editCoverImage']['name'])) {
        $target_dir = "../uploads/albumscover/";
        $file = $_FILES['editCoverImage'];
        
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

        if (move_uploaded_file($file['tmp_name'], $target_file)) {
            // Delete old image if it exists
            if (!empty($existing_cover) && file_exists($target_dir . $existing_cover)) {
                @unlink($target_dir . $existing_cover);
            }
            $cover_image = $filename;
        } else {
            header("Location: ../albums.php?error=" . urlencode("Error uploading cover image"));
            exit();
        }
    }

    // Update database
    $sql = "UPDATE albums SET 
            title = ?,
            artist = ?,
            release_year = ?,
            description = ?,
            status = ?,
            cover_image = ?
            WHERE id = ?";

    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "ssisssi", 
        $title, $artist, $year, $description, $status, $cover_image, $id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: ../albums.php?success=" . urlencode("Album updated successfully"));
    } else {
        header("Location: ../albums.php?error=" . urlencode("Error updating album: " . mysqli_error($con)));
    }

    mysqli_stmt_close($stmt);
    mysqli_close($con);
} else {
    header("Location: ../albums.php");
}
exit();
?>