<?php
include '../connection.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM songs WHERE id = $id";
    $result = mysqli_query($con, $sql);

    if ($result) {
        echo "<script>alert('Song deleted successfully'); window.location.href='../songs.php';</script>";
    } else {
        echo "<script>alert('Failed to delete song'); window.location.href='../songs.php';</script>";
    }

    mysqli_close($con);
} else {
    echo "<script>alert('Invalid request'); window.location.href='../songs.php';</script>";
}
?>
