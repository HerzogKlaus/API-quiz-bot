<?php

function getQuestions($connect)
{
    $questions = mysqli_query($connect, "SELECT * FROM `questions`");

    $questionsList = [];

    while ($question = mysqli_fetch_assoc($questions)) {
        $questionsList[] = $question;
    }

    echo (json_encode($questionsList));
}

function getQuestion($connect, $id)
{ 
    $question = mysqli_query($connect, "SELECT * FROM `questions` WHERE `id` = '$id'");
    if (mysqli_num_rows($question) === 0) {
        http_response_code(404);
        $res = ["status" => false, "message" => "Question not found"];
        echo json_encode($res);
    }
    $question = mysqli_fetch_assoc($question);
    echo json_encode($question);
}

function addQuestion($connect, $data)
{
    $questionText = $data['questionText'];
    $answers = $data['answers'];
    $correct = $data['correct'];

    mysqli_query($connect, "INSERT INTO `questions` (`questionText`, `answers`, `correct`, `id`, `used`) VALUES ('$questionText', '$answers', '$correct', '', '0')");
    http_response_code(201);
    $res = [
    "status" => true,
     "question_id" => mysqli_insert_id($connect)
    ];

    echo json_encode($res);
}

function updateQuestion($connect, $id)
{
    mysqli_query($connect, "UPDATE `questions` SET `used` = '1' WHERE `questions`.`id` = '$id'");

    http_response_code(200);
    $res = ["status" => true, "message" => "Question has been updated"];

    echo json_encode($res);
}
