<?php
session_start();
include '../connection.php';
header('Content-Type: application/json');

$response = ['status' => 'error', 'message' => ''];

// 1. Check login
if (!isset($_SESSION['user_id'])) {
    $response['message'] = 'Please login first!';
    echo json_encode($response);
    exit;
}

$user_id = $_SESSION['user_id'];
$song_id = isset($_POST['song_id']) ? intval($_POST['song_id']) : 0;
$video_id = isset($_POST['video_id']) ? intval($_POST['video_id']) : 0;
$action = $_POST['action'] ?? '';

if (!in_array($action, ['add', 'remove'])) {
    $response['message'] = 'Invalid action';
    echo json_encode($response);
    exit;
}

// Determine which type is being favorited
if ($song_id > 0) {
    $type = 'song';
    $column = 'song_id';
    $id = $song_id;
} elseif ($video_id > 0) {
    $type = 'video';
    $column = 'video_id';
    $id = $video_id;
} else {
    $response['message'] = 'No song or video ID provided';
    echo json_encode($response);
    exit;
}

// 2. Process action
if ($action === 'add') {
    $check = mysqli_query($con, "SELECT * FROM favorites WHERE user_id = $user_id AND $column = $id");

    if (mysqli_num_rows($check) > 0) {
        $response['status'] = 'info';
        $response['message'] = ucfirst($type) . ' already in favorites';
    } else {
        $insert = mysqli_query($con, "INSERT INTO favorites (user_id, $column) VALUES ($user_id, $id)");

        if ($insert) {
            $response['status'] = 'success';
            $response['message'] = ucfirst($type) . ' added to favorites!';
        } else {
            $response['message'] = 'Database insert error: ' . mysqli_error($con);
        }
    }
} else { // remove
    $delete = mysqli_query($con, "DELETE FROM favorites WHERE user_id = $user_id AND $column = $id");

    if ($delete && mysqli_affected_rows($con) > 0) {
        $response['status'] = 'success';
        $response['message'] = ucfirst($type) . ' removed from favorites';
    } else {
        $response['status'] = 'info';
        $response['message'] = ucfirst($type) . ' not in favorites';
    }
}

echo json_encode($response);
exit;
?>
