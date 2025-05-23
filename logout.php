<?php
session_start();
require_once 'includes/auth.php';

// Clear remember me cookies
clearRememberMe();

// Destroy session
session_destroy();

// Redirect to login page
header("Location: login.php");
exit();
?> 