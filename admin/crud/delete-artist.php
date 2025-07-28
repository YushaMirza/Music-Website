<?php
include '../connection.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM artists WHERE id = $id";
    $result = mysqli_query($con, $sql);

    if ($result) {
        echo "<script>alert('Artist deleted successfully'); window.location.href='../artists.php';</script>";
    } else {
        echo "<script>alert('Failed to delete artist'); window.location.href='../artists.php';</script>";
    }

    mysqli_close($con);
} else {
    echo "<script>alert('Invalid request'); window.location.href='../artists.php';</script>";
}
?>
