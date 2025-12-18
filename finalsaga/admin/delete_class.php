<?php
session_start();
include '../db.php';
if(!isset($_SESSION['admin'])) header("Location: ../index.php");

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Optional: Check if class exists
$res = $conn->query("SELECT * FROM classes WHERE id='$id'");
if($res->num_rows == 0){
    die("Class not found!");
}

// Delete the class
$conn->query("DELETE FROM classes WHERE id='$id'");

// Optional: Delete all students assigned to this class
// $conn->query("DELETE FROM students WHERE class='CLASS_NAME' AND year_level='YEAR_LEVEL'");

header("Location: dashboard.php");
exit;
