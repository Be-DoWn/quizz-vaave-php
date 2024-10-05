<?php
$config = require(BASE_PATH . ('config.php'));
$db = new Database($config['database']);

$topics = getTopics($db);
sendResponse(['topics' => $topics], Response::OK);
