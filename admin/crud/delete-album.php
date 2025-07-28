<?php
include '../connection.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM albums WHERE id = $id";
    $result = mysqli_query($con, $sql);

    if ($result) {
        echo "<script>alert('Album deleted successfully'); window.location.href='../albums.php';</script>";
    } else {
        echo "<script>alert('Failed to delete album'); window.location.href='../albums.php';</script>";
    }

    mysqli_close($con);
} else {
    echo "<script>alert('Invalid request'); window.location.href='../albums.php';</script>";
}
?>
