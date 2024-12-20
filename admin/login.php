<?php
session_start();
include '../db.php';

$username = $_POST['username'];
$password = $_POST['password'];

$stmt = $conn->prepare("SELECT * FROM admin WHERE username = ? AND password = ?");
$stmt->bind_param("ss", $username, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $_SESSION['admin_logged_in'] = true;
    header("Location: dashboard.html");
} else {
    echo "<script>alert('Username atau password salah!'); window.location.href='login.html';</script>";
}
?>
