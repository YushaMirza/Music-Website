<?php
include '../connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate inputs
    $required = ['title', 'artist', 'genre', 'year', 'newflag'];
    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            header("Location: ../songs.php?error=" . urlencode("$field is required"));
            exit();
        }
    }

    // Sanitize inputs
    $songtitle = mysqli_real_escape_string($con, trim($_POST['title']));
    $artist = mysqli_real_escape_string($con, trim($_POST['artist']));
    $album = isset($_POST['album']) ? mysqli_real_escape_string($con, trim($_POST['album'])) : '';
    $genre = mysqli_real_escape_string($con, trim($_POST['genre']));
    $lang = isset($_POST['language']) ? mysqli_real_escape_string($con, trim($_POST['language'])) : '';
    $newflag = mysqli_real_escape_string($con, trim($_POST['newflag']));
    $new = ($newflag === 'Yes') ? 'NEW' : '';
    $year = mysqli_real_escape_string($con, trim($_POST['year']));
    $desc = isset($_POST['description']) ? mysqli_real_escape_string($con, trim($_POST['description'])) : '';
    $status = 'published';

    // Validate year
    if (!preg_match('/^[1-2][0-9]{3}$/', $year)) {
        header("Location: ../songs.php?error=" . urlencode("Invalid year format"));
        exit();
    }

    // Validate file uploads
    if (!isset($_FILES["songfile"]) || $_FILES["songfile"]["error"] != UPLOAD_ERR_OK ||
        !isset($_FILES["songcover"]) || $_FILES["songcover"]["error"] != UPLOAD_ERR_OK) {
        header("Location: ../songs.php?error=" . urlencode("File upload error"));
        exit();
    }

    // Validate file types and sizes
    $audioTypes = ['audio/mpeg', 'audio/wav', 'audio/mp3'];
    $imageTypes = ['image/jpeg', 'image/png'];
    $maxAudioSize = 10 * 1024 * 1024; // 10MB
    $maxImageSize = 2 * 1024 * 1024; // 2MB

    $audioFile = $_FILES["songfile"];
    $imageFile = $_FILES["songcover"];

    if (!in_array($audioFile['type'], $audioTypes) || $audioFile['size'] > $maxAudioSize) {
        header("Location: ../songs.php?error=" . urlencode("Invalid audio file (MP3/WAV, max 10MB)"));
        exit();
    }

    if (!in_array($imageFile['type'], $imageTypes) || $imageFile['size'] > $maxImageSize) {
        header("Location: ../songs.php?error=" . urlencode("Invalid image file (JPG/PNG, max 2MB)"));
        exit();
    }

    // Add this right after validating required fields
if (preg_match('/[!@#$%^&*()_+\-=\[\]{};\'\\|,.<>\/?]+/', $songtitle)) {
    header("Location: ../songs.php?error=" . urlencode("Special characters are not allowed in song title"));
    exit();
}

    // Handle file uploads
    $target_song_dir = "../uploads/songs/";
    $target_songcover_dir = "../uploads/songscover/";

    // Generate unique filenames
    $audioExt = pathinfo($audioFile['name'], PATHINFO_EXTENSION);
    $imageExt = pathinfo($imageFile['name'], PATHINFO_EXTENSION);
    $audioFilename = uniqid() . '.' . $audioExt;
    $imageFilename = uniqid() . '.' . $imageExt;

    if (!move_uploaded_file($audioFile['tmp_name'], $target_song_dir . $audioFilename) ||
        !move_uploaded_file($imageFile['tmp_name'], $target_songcover_dir . $imageFilename)) {
        header("Location: ../songs.php?error=" . urlencode("File upload failed"));
        exit();
    }

    // Insert into database
    $sql = "INSERT INTO songs (title, artist, album, year, genre, language, image, new_flag, type, file, status, description)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'song', ?, ?, ?)";

    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "sssisssssss", 
        $songtitle, $artist, $album, $year, $genre, 
        $lang, $imageFilename, $new, $audioFilename, $status, $desc);

    if (mysqli_stmt_execute($stmt)) {
        // Update album's songs column if album was specified
        if (!empty($album)) {
            $updateAlbum = mysqli_prepare($con, "UPDATE albums SET songs = CONCAT(IFNULL(songs, ''), IF(songs IS NULL, '', ','), ?) WHERE title = ?");
            mysqli_stmt_bind_param($updateAlbum, "ss", $songtitle, $album);
            mysqli_stmt_execute($updateAlbum);
            mysqli_stmt_close($updateAlbum);
        }

        header("Location: ../songs.php?success=" . urlencode("Song added successfully"));
    } else {
        // Clean up uploaded files if database insert failed
        @unlink($target_song_dir . $audioFilename);
        @unlink($target_songcover_dir . $imageFilename);
        header("Location: ../songs.php?error=" . urlencode("Database error: " . mysqli_error($con)));
    }

    mysqli_stmt_close($stmt);
    mysqli_close($con);
} else {
    header("Location: ../songs.php?error=" . urlencode("Invalid request method"));
}
exit();
?>