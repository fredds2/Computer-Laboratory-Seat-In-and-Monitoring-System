<?php
session_start();
include 'db.php';

$error = "";

if(isset($_POST['login'])){
    $id = trim($_POST['id']); // Admin username OR Student ID
    $password = trim($_POST['password']);

    // Check the single admin
    $admin = $conn->query("SELECT * FROM admin WHERE username='$id' AND password='$password'");
    if($admin->num_rows === 1){
        $_SESSION['admin'] = $id;
        header("Location: admin/dashboard.php");
        exit;
    }

    // Check students
    $student = $conn->query("SELECT * FROM students WHERE student_id='$id' AND password='$password'");
    if($student->num_rows === 1){
        $_SESSION['student'] = $id;
        header("Location: student/dashboard.php");
        exit;
    }

    $error = "Invalid ID or password!";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login - Lab Seat in and Monitoring</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* 1. Center the entire login box on the screen */
        body {
            display: flex;
            justify-content: center; /* Horizontal centering */
            align-items: center;     /* Vertical centering */
            min-height: 100vh;       /* Full screen height */
            margin: 0;
            background-color: #f0f2f5;
            font-family: Arial, sans-serif;
        }

        /* 2. Control the size of the login card */
        .login-container {
            background: #ffffff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 360px; /* This makes the box and inputs shorter */
            text-align: center;
        }

        .login-container h2 {
            margin-bottom: 25px;
            font-size: 24px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            /* Gradient Effect */
            background: linear-gradient(45deg, #2980b9, #1abc9c);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* 3. Style and size the inputs */
        .login-container label {
            display: block;
            text-align: left;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }

        .login-container input {
            width: 100%;             /* Takes full width of the 360px container */
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;  /* Important: ensures padding doesn't add to width */
        }

        /* 4. Button Design */
        .login-container button {
            width: 100%;
            padding: 12px;
            background-color: #2980b9;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
        }

        .login-container button:hover {
            background-color: #1abc9c;
        }

        /* 5. Error Message */
        .error {
            background-color: #e74c3c;
            color: white;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 14px;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2>Computer Lab Seat in and Monitoring System
    </h2>

    <?php if($error): ?>
        <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST">
        <label>ID / Username</label>
        <input type="text" name="id" placeholder="Enter ID" required>

        <label>Password</label>
        <input type="password" name="password" placeholder="Enter Password" required>

        <button type="submit" name="login">Login</button>
    </form>
</div>

</body>
</html>