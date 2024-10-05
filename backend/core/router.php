<?php

$routes = [
    '/login' => 'controllers/login.php',
    '/session' => 'controllers/session.php',
    '/topics' => 'controllers/topics.php',
    '/questions' => 'controllers/questions.php',
    '/userdata' => 'controllers/userdata.php',
    '/logout' => 'controllers/logout.php',
    'googlelogin' => 'google-login/goog.php'
];

function routetoController($uri, $routes)
{
    // check if the URI is one of the static routes
    if (array_key_exists($uri, $routes)) {
        require BASE_PATH . ($routes[$uri]);
    } else {
        // Handle  /questions/{topic_name}/{id} -its a mistake
        $uriParts = explode('/', trim($uri, '/'));

        if ($uriParts[0] === 'questions' && isset($uriParts[1]) && isset($uriParts[2])) {
            require BASE_PATH . ('controllers/questions.php');
        } else {
            http_response_code(404);
            echo "Page not found";
        }
    }
}

// parse the URI to get the path
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Route to the appropriate controller
routetoController($uri, $routes);
