<?php
session_start();
include '../connection.php';

if (!isset($_SESSION['user_id'])) {
    echo "Please login to submit rating.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $video_id = $_POST['video_id'] ?? '';
    $song_id = $_POST['song_id'] ?? '';
    $artist_id = $_POST['artist_id'] ?? '';
    $album_id = $_POST['album_id'] ?? '';
    $item_name = $_POST['item_name'] ?? '';
    $item_type = $_POST['item_type'] ?? '';
    $rating = isset($_POST['rating']) ? (int)$_POST['rating'] : 0;
    $review = $_POST['review'] ?? '';

    echo"<script> console.log($item_name) </script>";

    if ($rating < 1 || $rating > 5 || empty($item_name) || empty($item_type)) {
        echo "<script>alert('Invalid input. Please fill all fields.')</script>";
        exit;
    }

    $item_name = mysqli_real_escape_string($con, $item_name);
    $item_type = mysqli_real_escape_string($con, $item_type);
    $review = mysqli_real_escape_string($con, $review);

    $sql = "INSERT INTO ratings (user_id, item_name, item_type, rating, review) 
            VALUES ('$user_id', '$item_name', '$item_type', '$rating', '$review')";

    if (mysqli_query($con, $sql)) {

        if($item_type == "video"){
            header('Location: video.php?id=' . $video_id . '');
        }else if($item_type == "song"){
            header('Location: song.php?id=' . $song_id . '');
        }else if($item_type == "artist"){
            header('Location: artist.php?artist=' . $artist_id . '');
        }else if($item_type == "album"){
            header('Location: album.php?album=' . $album_id . '');
        }
    } else {
        echo "<script>alert('Failed to submit review.')</script>";
    }
}
?>
