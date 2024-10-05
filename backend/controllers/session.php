<?php

session_start();
error_log('session started'); // Check if session is starting
error_log('user email: ' . ($_SESSION['user_email'] ?? 'No email in session'));

if (isset($_SESSION['user_email'])) {
    $email = $_SESSION['user_email'];

    // Send response with email and loggedIn = true
    sendResponse([
        'loggedIn' => true,
        'email' => $email
    ]);
} else {
    // Send response with loggedIn = false
    sendResponse(['loggedIn' => false], 403); // Use 403 Forbidden directly
}
