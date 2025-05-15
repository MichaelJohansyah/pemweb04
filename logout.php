<?php
session_start();

// Hapus semua variabel session
session_unset();

// Hancurkan session di server
session_destroy();

// Redirect ke halaman login
header("Location: login.php");
// iseng
exit;
?> 