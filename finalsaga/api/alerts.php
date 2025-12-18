<?php
header("Content-Type: application/json");
include '../db.php';
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $student_id = $data['student_id'];
    $lab_id = $data['lab_id'];
    $message = $data['message'];

    $conn->query("INSERT INTO alerts (student_id, lab_id, message)
                  VALUES ('$student_id', '$lab_id', '$message')");
    echo json_encode(['status'=>'sent']);
}
