<?php

session_start();

$config = require(BASE_PATH . ('config.php'));
$db = new Database($config['database']);


// get access token from the post
$data = json_decode(file_get_contents("php://input"), true);
//testing
// $test = file_get_contents("php://input");
// var_dump(json_decode($test['accessToken']));
// die();

$accessToken = $data['accessToken'] ?? null; 


if ($accessToken) {
    $url = 'https://www.googleapis.com/oauth2/v3/userinfo';

    // simple http request
    $options = [
        'http' => [
            'header'  => "Authorization: Bearer " . $accessToken,
            'method'  => 'GET'
        ]
    ];
    // var_dump($options);
    // create a stream context
    $context = stream_context_create($options);
    var_dump($context);

    // file_get_contents to send the request
    $response = file_get_contents($url, false, $context);
    // var_dump($response);
    // check response
    if ($response) {
        // decode the JSON response
        $userInfo = json_decode($response, true);

        // check if the user exists
        $emailExists = checkUser($db, $userInfo['email']);
        if (!$emailExists) {
            $newUserCreated = createUser($db, $userInfo['email']);
            if (!$newUserCreated) {
                sendResponse(['error' => 'failed to create a new user.'], Response::SERVER_ERROR); // Server error
                return;
            }
        }
        $_SESSION['user_email'] = $userInfo['email'];


        sendResponse(['email' => $userInfo['email']]);
    } else {
        sendResponse(['error' => 'response failed.'], Response::SERVER_ERROR);
    }
} else {
    sendResponse(['error' => 'access token failed.'], Response::BAD_REQUEST);
}