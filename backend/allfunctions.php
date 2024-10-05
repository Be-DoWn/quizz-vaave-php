<?php

function sendResponse($data, $statusCode = 200)
{
    http_response_code($statusCode);
    header('Content-Type: application/json');
    echo json_encode($data, JSON_PRETTY_PRINT);
    exit; // Stop here
}

function checkUser($db, $email)
{
    $query = $db->query("select useremail from usersdata");
    $users = $query->fetchAll(PDO::FETCH_ASSOC); // Fetch as an array of associative arrays

    // array_column return column
    $emailArray = array_column($users, 'useremail');

    return in_array($email, $emailArray); // return true / false
}

function createUser($db, $email)
{
    $statement = $db->prepare("insert into usersdata (useremail) values (?)");
    if ($statement->execute([$email])) {
        return true;
    }
    return false;
}

function getTopics($db)
{
    $statement = $db->query('select * from topics');
    $topics = $statement->fetchAll();
    return $topics;
}

function getQuestion($db, $params = [])
{
    $statement = $db->prepare('
        select questions.id AS question_id, 
               questions.question_text, 
               options.id AS option_id, 
               options.option_text, 
               options.is_correct,
               questions.level_id AS level_id
        FROM questions
        JOIN topics ON questions.topic_id = topics.id
        JOIN options ON questions.id = options.question_id
        WHERE topics.topic_name = ?
    ');

    $statement->execute([$params['topic']]); 
    return $statement->fetchAll();  
}

function getUserID($db, $useremail)
{
    if ($useremail) {
        $statement = $db->prepare('select id from usersdata where useremail=?');
        $statement->execute([$useremail]);
        $user = $statement->fetch();
        if (!$user) {
            throw new Exception('user not found');
        }
        return $user['id'];
    }
    return false;
}

function insertUserResults($db, $userId, $topic_id, $score)
{
    $statement = $db->prepare('insert into userResult (user_id, topic_id, user_score) values (?, ?, ?)');
    if (!$statement->execute([$userId, $topic_id, $score])) {
        throw new Exception('insertion failed - user result');
    }
}

function insertUserResponse($db, $responses = [], $userId, $topic_id)
{
    if ($responses && $userId && $topic_id) {
        $insertUserResponse = $db->prepare('
            insert into UserResponses (user_id, topic_id, level_id, question_id, selected_option_id, is_correct)
            values (?, ?, ?, ?, ?, ?)
        ');

        foreach ($responses as $response) {
            if (!$insertUserResponse->execute([
                $userId,
                $topic_id,
                $response['level_id'],
                $response['question_id'],
                $response['selected_option_id'],
                $response['is_correct'] ? 1 : 0
            ])) {
                throw new Exception('insertion failed - user response');
            }
        }
    }
}
