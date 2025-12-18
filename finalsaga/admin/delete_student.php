<?php
session_start();
include '../db.php';
if(!isset($_SESSION['admin'])) header("Location: ../index.php");

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$conn->query("DELETE FROM students WHERE student_id='$id'");
header("Location: dashboard.php");
exit;
