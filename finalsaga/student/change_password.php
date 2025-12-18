<?php
session_start();
include '../db.php';
if(!isset($_SESSION['student'])) header("Location: ../index.php");

$student_id = $_SESSION['student'];
$res = $conn->query("SELECT * FROM students WHERE student_id='$student_id'");
$student = $res->fetch_assoc();

if(isset($_POST['change'])){
    $current = $_POST['current_password'];
    $new = $_POST['new_password'];

    if($current == $student['password']){
        $conn->query("UPDATE students SET password='$new' WHERE student_id='$student_id'");
        $msg = "Password changed successfully!";
    } else {
        $error = "Current password is incorrect!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Change Password</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        /* 1. Center the entire content on the screen */
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            background-color: #f4f6f8;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            text-align: center;
        }

        /* 2. Styling the Heading with the Gradient effect */
        h2 {
            margin-bottom: 20px;
            font-size: 26px;
            font-weight: 800;
            text-transform: uppercase;
            background: linear-gradient(45deg, #2980b9, #1abc9c);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* 3. Style the form card */
        form {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 350px; /* Shortens the width */
            margin-bottom: 20px;
        }

        label {
            display: block;
            text-align: left;
            font-weight: 600;
            margin-bottom: 5px;
            color: #555;
        }

        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 6px;
            box-sizing: border-box;
        }

        /* 4. Action Button */
        button[name="change"] {
            width: 100%;
            padding: 12px;
            background-color: #2980b9;
            color: white;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s;
        }

        button[name="change"]:hover {
            background-color: #1abc9c;
        }

        /* 5. Alert styles */
        .msg { background-color: #2ecc71; color: white; padding: 10px; border-radius: 6px; margin-bottom: 15px; width: 350px; }
        .error { background-color: #e74c3c; color: white; padding: 10px; border-radius: 6px; margin-bottom: 15px; width: 350px; }

        /* 6. Back Button Design */
        .btn-back {
            display: inline-block;
            background-color: #34495e;
            color: #ffffff !important;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-back:hover {
            background-color: #2c3e50;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>

    <h2>Change Password</h2>

    <?php if(isset($msg)) echo "<div class='msg'>$msg</div>"; ?>
    <?php if(isset($error)) echo "<div class='error'>$error</div>"; ?>

    <form method="POST">
        <label>Current Password</label>
        <input type="password" name="current_password" placeholder="" required>

        <label>New Password</label>
        <input type="password" name="new_password" placeholder="" required>

        <button type="submit" name="change">Update Password</button>
    </form>

    <a href="dashboard.php" class="btn-back">&larr; Back to Dashboard</a>

</body>
</html>