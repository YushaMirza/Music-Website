<?php
include '../connection.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM videos WHERE id = $id";
    $result = mysqli_query($con, $sql);

    if ($result) {
        echo "<script>alert('Video deleted successfully'); window.location.href='../videos.php';</script>";
    } else {
        echo "<script>alert('Failed to delete video'); window.location.href='../videos.php';</script>";
    }

    mysqli_close($con);
} else {
    echo "<script>alert('Invalid request'); window.location.href='../videos.php';</script>";
}
?>
