<?php
session_start();


$_SESSION = array(); //remove stored data

// clear the session cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    //clearing cookies
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// destroy the session
session_destroy();

// check if the session is destroyed
if (session_status() === PHP_SESSION_NONE && empty($_SESSION)) {
    sendResponse(['sessionDestroyed' => true]);
} else {
    sendResponse(['sessionDestroyed' => false]);
}
