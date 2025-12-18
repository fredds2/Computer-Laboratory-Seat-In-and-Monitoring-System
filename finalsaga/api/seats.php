<?php
header("Content-Type: application/json");
include '../db.php';
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $lab_id = $data['lab_id'];
    $student_id = $data['student_id'];
    $computer_number = $data['computer_number'];

    $conn->query("INSERT INTO lab_seats (lab_id, computer_number, student_id)
                  VALUES ('$lab_id','$computer_number','$student_id')");
    echo json_encode(['status'=>'success']);
}

elseif ($method === 'DELETE') {
    parse_str(file_get_contents("php://input"), $data);
    $seat_id = $data['seat_id'];
    $conn->query("DELETE FROM lab_seats WHERE seat_id='$seat_id'");
    echo json_encode(['status'=>'deleted']);
}
