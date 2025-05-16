<?php
session_start();
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Cek apakah username sudah ada
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $_SESSION['error'] = "Username sudah digunakan.";
        header("Location: ../register.php");
        exit();
    }

    // Password dan konfirmasi tidak cocok
    if ($password !== $confirm_password) {
        $_SESSION['error'] = "Password dan konfirmasi tidak sama.";
        header("Location: ../register.php");
        exit();
    }
    
    // Cek apakah username dan email sudah dipakai
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
   $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['error'] = "Username atau email sudah digunakan.";
        header("Location: ../register.php");
        exit();
    }

    // Hash password
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Insert data
    $stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, 'user')");
    $stmt->bind_param("sss", $username, $email, $password_hash);

    if ($stmt->execute()) {
        // Register berhasil
        header("Location: ../login.php?success=1");
        exit();
    } else {
        $_SESSION['error'] = "Gagal mendaftar. Coba lagi.";
        header("Location: ../register.php");
        exit();
    }
}
?>