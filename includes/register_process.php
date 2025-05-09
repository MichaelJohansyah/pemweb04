<?php
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
        // Username sudah ada
        header("Location: ../register.php?error=" . urlencode("Username sudah digunakan."));
        exit();
    }

    // Password dan konfirmasi tidak cocok
    if ($password !== $confirm_password) {
        header("Location: ../register.php?error=" . urlencode("Password dan konfirmasi tidak sama."));
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
        // Register gagal
        header("Location: ../register.php?error=" . urlencode("Gagal mendaftar. Coba lagi."));
        exit();
    }
}
?>