<?php
include '../connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate and sanitize inputs
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $name = trim(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING));
    $country = trim(filter_input(INPUT_POST, 'country', FILTER_SANITIZE_STRING));
    $biography = trim(filter_input(INPUT_POST, 'biography', FILTER_SANITIZE_STRING));
    $existing_image = filter_input(INPUT_POST, 'existing_artist_img', FILTER_SANITIZE_STRING);
    
    // Validate required fields
    if (empty($id) || empty($name) || empty($country)) {
        header("Location: ../artists.php?error=Required fields are missing");
        exit();
    }
    
    // Validate name and country (no special characters)
    $specialChars = '/[!@#$%^&*()_+\-=\[\]{};\'\\|,.<>\/?]+/';
    if (preg_match($specialChars, $name) || preg_match($specialChars, $country)) {
        header("Location: ../artists.php?error=Special characters are not allowed in name or country");
        exit();
    }
    
    // Validate genres
    if (empty($_POST['genres']) || !is_array($_POST['genres'])) {
        header("Location: ../artists.php?error=Please select at least one genre");
        exit();
    }
    
    $genres = array_map(function($genre) use ($con) {
        return mysqli_real_escape_string($con, trim($genre));
    }, $_POST['genres']);
    $genres_str = implode(',', $genres);
    
    // Handle file upload if new image is provided
    $image = $existing_image;
    if (!empty($_FILES['artistImageFile']['name'])) {
        $target_dir = "../uploads/artists/";
        $file_name = basename($_FILES["artistImageFile"]["name"]);
        $target_file = $target_dir . $file_name;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        
        // Check if file is an actual image
        $check = getimagesize($_FILES["artistImageFile"]["tmp_name"]);
        if ($check === false) {
            header("Location: ../artists.php?error=File is not a valid image");
            exit();
        }
        
        // Check file size (max 2MB)
        if ($_FILES["artistImageFile"]["size"] > 2000000) {
            header("Location: ../artists.php?error=Image size must be less than 2MB");
            exit();
        }
        
        // Allow only specific file formats
        $allowed_types = ['jpg', 'jpeg', 'png'];
        if (!in_array($imageFileType, $allowed_types)) {
            header("Location: ../artists.php?error=Only JPG, JPEG & PNG files are allowed");
            exit();
        }
        
        // Generate unique filename
        $new_filename = uniqid() . '.' . $imageFileType;
        $target_file = $target_dir . $new_filename;
        
        // Try to upload file
        if (move_uploaded_file($_FILES["artistImageFile"]["tmp_name"], $target_file)) {
            // Delete old image if it exists
            if (!empty($existing_image) && file_exists($target_dir . $existing_image)) {
                @unlink($target_dir . $existing_image);
            }
            $image = $new_filename;
        } else {
            header("Location: ../artists.php?error=Error uploading image file");
            exit();
        }
    }
    
    // Update database using prepared statement
    $sql = "UPDATE artists SET 
            name = ?,
            country = ?,
            genres = ?,
            biography = ?,
            image = ?
            WHERE id = ?";
    
    $stmt = mysqli_prepare($con, $sql);
    if (!$stmt) {
        header("Location: ../artists.php?error=Database error");
        exit();
    }
    
    mysqli_stmt_bind_param($stmt, "sssssi", $name, $country, $genres_str, $biography, $image, $id);
    
    if (mysqli_stmt_execute($stmt)) {
        header("Location: ../artists.php?success=Artist updated successfully");
    } else {
        header("Location: ../artists.php?error=Error updating artist: " . mysqli_error($con));
    }
    
    mysqli_stmt_close($stmt);
    mysqli_close($con);
} else {
    header("Location: ../artists.php");
}
exit();
?>