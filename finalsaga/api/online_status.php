<?php
header("Content-Type: application/json");
include '../db.php';

$res = $conn->query("
  SELECT student_id, name,
  IF(last_active >= NOW() - INTERVAL 30 SECOND, 'online', 'offline') AS status
  FROM students
");

$data = [];
while($row = $res->fetch_assoc()){
    $data[] = $row;
}

echo json_encode($data);
