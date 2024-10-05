<?php

// Allow requests from the frontend
header("Access-Control-Allow-Origin: http://localhost:5173"); 
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Access-Control-Allow-Credentials: true"); // cookies/credentials

// Handle preflight (OPTIONS) requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}
const BASE_PATH = __DIR__ . '/../';


// Set the base path

require BASE_PATH . 'allfunctions.php';

require BASE_PATH . 'core/Database.php';
require BASE_PATH . 'core/Response.php';
require BASE_PATH . 'core/router.php';
