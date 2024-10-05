<?php

session_start();

$config = require(BASE_PATH . ('config.php'));
$db = new Database($config['database']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $user = $data['user'];
    $score = $data['score'];
    $responses = $data['responses'];
    $topic_id = $data['topic_id'];

    // Validate required data
    if (empty($user) || empty($score) || empty($responses)) {
        sendResponse(["error" => "missing some data"], Response::BAD_REQUEST);
        return;
    }

    try {
        // get userid by email
        $userId = getUserID($db, $user);
        if (!$userId) {
            return;  // get out
        }

        // Insert into userResult table
        insertUserResults($db, $userId, $topic_id, $score);

        // Insert each response into UserResponses table
        insertUserResponse($db, $responses, $userId, $topic_id);

        sendResponse(["user data saved"], Response::OK);
    } catch (Exception $e) {


        // send error array
        sendResponse([
            "error" => "Error saving user response",
            "message" => $e->getMessage(),
        ], Response::SERVER_ERROR);
    }
}
