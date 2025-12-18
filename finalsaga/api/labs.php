<?php
header("Content-Type: application/json");
include '../db.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    $res = $conn->query("SELECT * FROM computer_labs ORDER BY lab_id");
    $labs = [];
    while ($row = $res->fetch_assoc()) {
        $labs[] = $row;
    }
    echo json_encode($labs);
}
