<?php
header("Content-Type: application/json");
include '../db.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    $res = $conn->query("SELECT student_id, name, year_level, class FROM students");
    $data = [];
    while($row = $res->fetch_assoc()){
        $data[] = $row;
    }
    echo json_encode($data);
}

if ($method === 'POST') {
    $input = json_decode(file_get_contents("php://input"), true);

    $name = $input['name'];
    $password = $input['password'];
    $year = $input['year_level'];
    $class = $input['class'];

    $conn->query("INSERT INTO students (name,password,year_level,class)
                  VALUES ('$name','$password','$year','$class')");

    echo json_encode(["status" => "success"]);
}
