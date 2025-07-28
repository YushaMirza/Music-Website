<?php
include '../connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate required fields
    $required = ['video_id', 'title', 'artist', 'genre', 'year', 'status', 'videoLink'];
    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            header("Location: ../videos.php?error=" . urlencode("$field is required"));
            exit();
        }
    }

    // Sanitize inputs
    $id = filter_input(INPUT_POST, 'video_id', FILTER_VALIDATE_INT);
    $existingimg = mysqli_real_escape_string($con, trim($_POST['existing_video_img']));
    $title = mysqli_real_escape_string($con, trim($_POST['title']));
    $artist = mysqli_real_escape_string($con, trim($_POST['artist']));
    $album = isset($_POST['album']) ? mysqli_real_escape_string($con, trim($_POST['album'])) : '';
    $genre = mysqli_real_escape_string($con, trim($_POST['genre']));
    $lang = isset($_POST['language']) ? mysqli_real_escape_string($con, trim($_POST['language'])) : '';
    $year = mysqli_real_escape_string($con, trim($_POST['year']));
    $desc = isset($_POST['description']) ? mysqli_real_escape_string($con, trim($_POST['description'])) : '';
    $status = mysqli_real_escape_string($con, trim($_POST['status']));
    $link = mysqli_real_escape_string($con, trim($_POST['videoLink']));

    // Validate title for special characters
    if (preg_match('/[!@#$%^&*()_+\-=\[\]{};\'\\|,.<>\/?]+/', $title)) {
        header("Location: ../videos.php?error=" . urlencode("Special characters are not allowed in video title"));
        exit();
    }

    // Validate year format
    if (!preg_match('/^[1-2][0-9]{3}$/', $year) || $year < 1900 || $year > 2025) {
        header("Location: ../videos.php?error=" . urlencode("Invalid year format (1900-2025)"));
        exit();
    }

    // Validate YouTube URL
    if (!preg_match('/^(https?\:\/\/)?(www\.)?(youtube\.com|youtu\.?be)\/.+$/', $link)) {
        header("Location: ../videos.php?error=" . urlencode("Invalid YouTube URL"));
        exit();
    }

    // Handle file upload
    $cover_image = $existingimg;
    if (!empty($_FILES['videocover']['name']) && $_FILES['videocover']['size'] > 0) {
        $target_dir = "../uploads/videoscover/";
        $file = $_FILES['videocover'];

        // Validate image
        $validTypes = ['image/jpeg', 'image/png'];
        $maxSize = 2 * 1024 * 1024; // 2MB

        if (!in_array($file['type'], $validTypes)) {
            header("Location: ../videos.php?error=" . urlencode("Invalid image type (JPG/PNG only)"));
            exit();
        }

        if ($file['size'] > $maxSize) {
            header("Location: ../videos.php?error=" . urlencode("Image too large (max 2MB)"));
            exit();
        }

        // Generate unique filename
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid() . '.' . $ext;
        $target_file = $target_dir . $filename;

        if (move_uploaded_file($file['tmp_name'], $target_file)) {
            // Delete old image if it exists and is different from new one
            if (!empty($existingimg) && $existingimg !== $filename && file_exists($target_dir . $existingimg)) {
                @unlink($target_dir . $existingimg);
            }
            $cover_image = $filename;
        } else {
            header("Location: ../videos.php?error=" . urlencode("Error uploading cover image"));
            exit();
        }
    }

    // Update database
    $sql = "UPDATE videos SET 
            title = ?,
            artist = ?,
            album = ?,
            year = ?,
            genre = ?,
            language = ?,
            image = ?,
            link = ?,
            status = ?,
            description = ?
            WHERE id = ?";

    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "ssssssssssi", 
        $title, $artist, $album, $year, $genre, $lang, $cover_image, $link, $status, $desc, $id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: ../videos.php?success=" . urlencode("Video updated successfully"));
    } else {
        header("Location: ../videos.php?error=" . urlencode("Error updating video: " . mysqli_error($con)));
    }

    mysqli_stmt_close($stmt);
    mysqli_close($con);
} else {
    header("Location: ../videos.php");
}
exit();
?>