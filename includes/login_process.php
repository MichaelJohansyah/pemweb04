<?php
session_start();

require_once 'config.php'; // koneksi ke database, misalnya via $conn

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "Form submitted.<br>";
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Cek apakah username ada di database
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // buat perilaku ketika username tidak ditemukan
    if ($result->num_rows == 0) {
        $_SESSION['error'] = "Username tidak ditemukan.";
        header("Location: ../login.php");
        exit();
    }

    $user = $result->fetch_assoc();

    // buat perilaku ketika password salah
    if (!password_verify($password, $user['password'])) {
        $_SESSION['error'] = "Password salah.";
        header("Location: ../login.php");
        exit();
    }

    // buat perilaku ketika login berhasil
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['role'] = $user['role'];
    header("Location: ../dashboard.php");
    exit();

    // buat perilaku ketika login gagal (fallback umum jika semua gagal)
    $_SESSION['error'] = "Login gagal. Silakan coba lagi.";
    header("Location: ../login.php");
    exit();
}
?>