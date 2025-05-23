<?php
function checkRememberMe() {
    global $conn;
    
    if (isset($_COOKIE['remember_token']) && isset($_COOKIE['user_id'])) {
        $token = $_COOKIE['remember_token'];
        $user_id = $_COOKIE['user_id'];
        
        // Verify token from database
        $stmt = $conn->prepare("SELECT * FROM users WHERE id = ? AND remember_token = ?");
        $stmt->bind_param("is", $user_id, $token);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            
            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            
            return true;
        }
        
        // If token is invalid, clear cookies
        setcookie('remember_token', '', time() - 3600, '/');
        setcookie('user_id', '', time() - 3600, '/');
    }
    
    return false;
}

// Function to clear remember me cookies
function clearRememberMe() {
    global $conn;
    
    if (isset($_COOKIE['user_id'])) {
        // Clear token from database
        $stmt = $conn->prepare("UPDATE users SET remember_token = NULL WHERE id = ?");
        $stmt->bind_param("i", $_COOKIE['user_id']);
        $stmt->execute();
    }
    
    // Clear cookies
    setcookie('remember_token', '', time() - 3600, '/');
    setcookie('user_id', '', time() - 3600, '/');
}
?> 