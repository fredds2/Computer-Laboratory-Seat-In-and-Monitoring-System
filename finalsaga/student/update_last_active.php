<?php
session_start();
include '../db.php';
if(!isset($_SESSION['student'])) exit;
$student_id = $_SESSION['student'];
$conn->query("UPDATE students SET last_active=NOW() WHERE student_id='$student_id'");
?>
