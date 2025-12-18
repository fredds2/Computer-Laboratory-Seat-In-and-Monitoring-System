<?php
header("Content-Type: application/json");
include '../db.php';

$res = $conn->query("
    SELECT year_level, COUNT(*) AS total
    FROM students
    GROUP BY year_level
");

$data = [];
while ($row = $res->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
