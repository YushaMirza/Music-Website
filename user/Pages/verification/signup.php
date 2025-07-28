<?php
session_start();
include('../../connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($con, $_POST['regname']);
    $email = mysqli_real_escape_string($con, $_POST['regemail']);
    $password = password_hash($_POST['regpass'], PASSWORD_BCRYPT);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    $address = mysqli_real_escape_string($con, $_POST['address']);

    // Check if email exists
    $checkQuery = "SELECT * FROM user_data WHERE email = '$email'";
    $result = mysqli_query($con, $checkQuery);
    
    if (mysqli_num_rows($result) > 0) {
        die(json_encode(['status' => 'error', 'message' => 'Email already exists. Please try another.']));
    }

    // Role logic
    $role = 'user';
    if ($email === 'admin@gmail.com' && $_POST['regpass'] === 'admin123') {
        $role = 'admin';
    }

    $_SESSION['username'] = $username;

    $sql = "INSERT INTO user_data (name, email, password, phone, address, role) 
            VALUES ('$username', '$email', '$password', '$phone', '$address', '$role')";

    if (mysqli_query($con, $sql)) {
        echo json_encode(['status' => 'success', 'message' => 'Registration successful! Please login.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error: Unable to register.']);
    }
    exit;
}
?>