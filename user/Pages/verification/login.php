<?php
session_start();
include '../../connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($con, $_POST['useremail']);
    $password = $_POST['userpass'];

    if (empty($email) || empty($password)) {
        echo 'Please fill in all fields';
        exit;
    }

    $query = "SELECT * FROM user_data WHERE email = '$email'";
    $result = mysqli_query($con, $query);

    if (!$result || mysqli_num_rows($result) < 1) {
        echo 'Invalid email or password';
        exit;
    }

    $user = mysqli_fetch_assoc($result);

    if (password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user['email'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['username'] = $user['name'];
        $_SESSION['user_id'] = $user['id'];

        $redirectURL = ($_SESSION['role'] === 'admin') ? '../../admin/dashboard.php' : 'home-page.php';

        echo json_encode([
            'status' => 'success',
            'message' => 'Login successful! Redirecting...',
            'redirect' => $redirectURL
        ]);
        exit;
    } else {
        echo 'Invalid email or password';
        exit;
    }
}
echo 'Invalid request';
exit;
?>
