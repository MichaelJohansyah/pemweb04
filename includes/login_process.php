<?php
session_start();

require_once 'config.php'; // koneksi ke database, misalnya via $conn

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "Form submitted.<br>";
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $remember = isset($_POST['remember']) ? true : false;

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

    // Set session variables
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['role'] = $user['role'];

    // If remember me is checked, set cookies
    if ($remember) {
        // Create a secure token
        $token = bin2hex(random_bytes(32));
        
        // Store token in database
        $stmt = $conn->prepare("UPDATE users SET remember_token = ? WHERE id = ?");
        $stmt->bind_param("si", $token, $user['id']);
        $stmt->execute();

        // Set cookies (30 days expiry)
        setcookie('remember_token', $token, time() + (86400 * 30), '/', '', true, true);
        setcookie('user_id', $user['id'], time() + (86400 * 30), '/', '', true, true);
    }

    header("Location: ../dashboard.php");
    exit();

    // buat perilaku ketika login gagal (fallback umum jika semua gagal)
    $_SESSION['error'] = "Login gagal. Silakan coba lagi.";
    header("Location: ../login.php");
    exit();
}
?>