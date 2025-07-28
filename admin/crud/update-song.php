<?php
include '../connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate required fields
    $required = ['id', 'title', 'artist', 'genre', 'year', 'status'];
    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            header("Location: ../songs.php?error=" . urlencode("$field is required"));
            exit();
        }
    }

    // Sanitize inputs
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $title = mysqli_real_escape_string($con, trim($_POST['title']));
    $artist = mysqli_real_escape_string($con, trim($_POST['artist']));
    $album = isset($_POST['album']) ? mysqli_real_escape_string($con, trim($_POST['album'])) : '';
    $genre = mysqli_real_escape_string($con, trim($_POST['genre']));
    $language = isset($_POST['language']) ? mysqli_real_escape_string($con, trim($_POST['language'])) : '';
    $year = mysqli_real_escape_string($con, trim($_POST['year']));
    $newflag = isset($_POST['newflag']) ? mysqli_real_escape_string($con, trim($_POST['newflag'])) : 'No';
    $status = mysqli_real_escape_string($con, trim($_POST['status']));
    $description = isset($_POST['description']) ? mysqli_real_escape_string($con, trim($_POST['description'])) : '';
    $existing_cover = mysqli_real_escape_string($con, trim($_POST['existing_cover']));
    $existing_audio = isset($_POST['existing_audio']) ? mysqli_real_escape_string($con, trim($_POST['existing_audio'])) : '';

    // Validate year format
    if (!preg_match('/^[1-2][0-9]{3}$/', $year)) {
        header("Location: ../songs.php?error=" . urlencode("Invalid year format"));
        exit();
    }

    // Validate title for special characters
    if (preg_match('/[!@#$%^&*()_+\-=\[\]{};\'\\|,.<>\/?]+/', $title)) {
        header("Location: ../songs.php?error=" . urlencode("Special characters are not allowed in song title"));
        exit();
    }

    // Handle cover image upload if new one is provided
    $cover_image = $existing_cover;
    if (!empty($_FILES['songcover']['name'])) {
        $target_dir = "../uploads/songscover/";
        $imageTypes = ['image/jpeg', 'image/png'];
        $maxSize = 2 * 1024 * 1024; // 2MB

        $file = $_FILES['songcover'];
        
        // Validate image
        if (!in_array($file['type'], $imageTypes)) {
            header("Location: ../songs.php?error=" . urlencode("Invalid image type (JPG/PNG only)"));
            exit();
        }
        
        if ($file['size'] > $maxSize) {
            header("Location: ../songs.php?error=" . urlencode("Image too large (max 2MB)"));
            exit();
        }

        // Generate unique filename
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $new_filename = uniqid() . '.' . $ext;
        $target_file = $target_dir . $new_filename;

        if (move_uploaded_file($file['tmp_name'], $target_file)) {
            // Delete old image if it exists
            if (!empty($existing_cover) && file_exists($target_dir . $existing_cover)) {
                @unlink($target_dir . $existing_cover);
            }
            $cover_image = $new_filename;
        } else {
            header("Location: ../songs.php?error=" . urlencode("Error uploading cover image"));
            exit();
        }
    }

    // Handle audio file upload if new one is provided
    $audio_file = $existing_audio;
    if (!empty($_FILES['songfile']['name'])) {
        $target_dir = "../uploads/songs/";
        $audioTypes = ['audio/mpeg', 'audio/wav', 'audio/mp3'];
        $maxSize = 10 * 1024 * 1024; // 10MB

        $file = $_FILES['songfile'];
        
        // Validate audio
        if (!in_array($file['type'], $audioTypes)) {
            header("Location: ../songs.php?error=" . urlencode("Invalid audio type (MP3/WAV only)"));
            exit();
        }
        
        if ($file['size'] > $maxSize) {
            header("Location: ../songs.php?error=" . urlencode("Audio file too large (max 10MB)"));
            exit();
        }

        // Generate unique filename
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $new_filename = uniqid() . '.' . $ext;
        $target_file = $target_dir . $new_filename;

        if (move_uploaded_file($file['tmp_name'], $target_file)) {
            // Delete old audio file if it exists
            if (!empty($existing_audio) && file_exists($target_dir . $existing_audio)) {
                @unlink($target_dir . $existing_audio);
            }
            $audio_file = $new_filename;
        } else {
            header("Location: ../songs.php?error=" . urlencode("Error uploading audio file"));
            exit();
        }
    }

    // Update database
    $sql = "UPDATE songs SET 
            title = ?,
            artist = ?,
            album = ?,
            genre = ?,
            language = ?,
            year = ?,
            new_flag = ?,
            status = ?,
            description = ?,
            image = ?";
    
    // Add audio file to query if it was updated
    if (!empty($_FILES['songfile']['name'])) {
        $sql .= ", file = ? WHERE id = ?";
        
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "sssssssssssi", 
            $title, $artist, $album, $genre, $language, 
            $year, $newflag, $status, $description, 
            $cover_image, $audio_file, $id);
    } else {
        $sql .= " WHERE id = ?";
        
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "ssssssssssi", 
            $title, $artist, $album, $genre, $language, 
            $year, $newflag, $status, $description, 
            $cover_image, $id);
    }
    
    if (mysqli_stmt_execute($stmt)) {
        header("Location: ../songs.php?success=" . urlencode("Song updated successfully"));
    } else {
        header("Location: ../songs.php?error=" . urlencode("Error updating song: " . mysqli_error($con)));
    }
    
    mysqli_stmt_close($stmt);
    mysqli_close($con);
} else {
    header("Location: ../songs.php");
}
exit();
?>