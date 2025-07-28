<?php
session_start();
session_unset();
session_destroy();
header("Location: ../user/Pages/home-page.php");
exit;
?>