<?php

session_start();
$config = require(BASE_PATH . ('config.php'));
$db = new Database($config['database']);
$data = $_GET['topic'];
// echo 'this is bk' . $data;

if ($data) {
    $questions = getQuestion($db, ['topic' => $data]);
    // sendResponse(['questions' => $questions]);
    if (empty($questions)) {
        sendResponse(['message' => 'topic not found'], 404); // send 404 if topic not there
    } else {
        sendResponse(['questions' => $questions]); // send questions
    }

    // var_dump($questions);
}
