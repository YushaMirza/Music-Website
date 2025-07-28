<?php
include '../connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate required fields
    $required = ['title', 'artist', 'genre', 'year', 'newflag', 'videoLink'];
    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            header("Location: ../videos.php?error=" . urlencode("$field is required"));
            exit();
        }
    }

    // Sanitize inputs
    $videotitle = mysqli_real_escape_string($con, trim($_POST['title']));
    $artist = mysqli_real_escape_string($con, trim($_POST['artist']));
    $album = isset($_POST['album']) ? mysqli_real_escape_string($con, trim($_POST['album'])) : '';
    $year = mysqli_real_escape_string($con, trim($_POST['year']));
    $genre = mysqli_real_escape_string($con, trim($_POST['genre']));
    $lang = isset($_POST['language']) ? mysqli_real_escape_string($con, trim($_POST['language'])) : '';
    $new = mysqli_real_escape_string($con, trim($_POST['newflag']));
    $desc = isset($_POST['description']) ? mysqli_real_escape_string($con, trim($_POST['description'])) : '';
    $videolink = mysqli_real_escape_string($con, trim($_POST['videoLink']));
    $status = 'published';

    // Validate title for special characters
    if (preg_match('/[!@#$%^&*()_+\-=\[\]{};\'\\|,.<>\/?]+/', $videotitle)) {
        header("Location: ../videos.php?error=" . urlencode("Special characters are not allowed in video title"));
        exit();
    }

    // Validate year format
    if (!preg_match('/^[1-2][0-9]{3}$/', $year) || $year < 1900 || $year > 2025) {
        header("Location: ../videos.php?error=" . urlencode("Invalid year format (1900-2025)"));
        exit();
    }

    // Validate YouTube URL
    if (!preg_match('/^(https?\:\/\/)?(www\.)?(youtube\.com|youtu\.?be)\/.+$/', $videolink)) {
        header("Location: ../videos.php?error=" . urlencode("Invalid YouTube URL"));
        exit();
    }

    // Handle file upload
    if (!isset($_FILES["videocover"]) || $_FILES["videocover"]["error"] != UPLOAD_ERR_OK) {
        header("Location: ../videos.php?error=" . urlencode("Video cover is required"));
        exit();
    }

    $target_dir = "../uploads/videoscover/";
    $file = $_FILES["videocover"];

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

    if (!move_uploaded_file($file['tmp_name'], $target_file)) {
        header("Location: ../videos.php?error=" . urlencode("Error uploading cover image"));
        exit();
    }

    // Insert into database
    $sql = "INSERT INTO videos (title, artist, album, year, genre, language, image, new_flag, type, link, status, description)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'video', ?, ?, ?)";

    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "sssssssssss", 
        $videotitle, $artist, $album, $year, $genre, $lang, $filename, $new, $videolink, $status, $desc);

    if (mysqli_stmt_execute($stmt)) {
        // Update artist's videos if needed
        if (!empty($artist)) {
            $artist_query = mysqli_query($con, "SELECT videos FROM artists WHERE name = '$artist'");
            if ($artist_query && mysqli_num_rows($artist_query) > 0) {
                $artist_row = mysqli_fetch_assoc($artist_query);
                $existing_videos = $artist_row['videos'];
                $updated_videos = !empty($existing_videos) ? $existing_videos . ',' . $videotitle : $videotitle;
                mysqli_query($con, "UPDATE artists SET videos = '$updated_videos' WHERE name = '$artist'");
            }
        }

        // Update album's videos if needed
        if (!empty($album)) {
            $album_query = mysqli_query($con, "SELECT videos FROM albums WHERE title = '$album'");
            if ($album_query && mysqli_num_rows($album_query) > 0) {
                $album_row = mysqli_fetch_assoc($album_query);
                $existing_videos = $album_row['videos'];
                $updated_videos = !empty($existing_videos) ? $existing_videos . ',' . $videotitle : $videotitle;
                mysqli_query($con, "UPDATE albums SET videos = '$updated_videos' WHERE title = '$album'");
            }
        }

        header("Location: ../videos.php?success=" . urlencode("Video added successfully"));
    } else {
        // Delete uploaded file if database insert failed
        @unlink($target_file);
        header("Location: ../videos.php?error=" . urlencode("Error adding video: " . mysqli_error($con)));
    }

    mysqli_stmt_close($stmt);
    mysqli_close($con);
} else {
    header("Location: ../videos.php");
}
exit();
?>