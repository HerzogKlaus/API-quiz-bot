<?php

header('Content-type: application/json');

require 'connect.php';

require 'functions.php';

$method = $_SERVER['REQUEST_METHOD'];

$q = $_GET['q'];
$params = explode('/', $q);

$type = $params[0];
$id = $params[1];

if ($method === 'GET') {
  if ($type === 'questions') {

    if (isset($id)) {
      getQuestion($connect, $id);
    } else {
      getQuestions($connect);
    }
  }
} elseif ($method === 'POST') {
  if ($type === 'questions') {
    addQuestion($connect, $_POST);
  }
} elseif ($method === "PATCH") {
  if($type === 'questions') {
    if(isset($id)) {
      $data = file_get_contents('php://input');
      $data = json_decode($data);
      updateQuestion($connect, $id, $data);
    }
  }
}
