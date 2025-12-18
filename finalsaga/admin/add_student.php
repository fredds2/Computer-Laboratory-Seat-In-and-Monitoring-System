<?php
session_start();
include '../db.php';
if(!isset($_SESSION['admin'])) header("Location: ../index.php");

if(isset($_POST['add'])){
    $name = $_POST['name'];
    $password = $_POST['password'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $year = $_POST['year_level'];
    $class = $_POST['class'];

    $conn->query("INSERT INTO students (name,password,gender,email,year_level,class) 
                  VALUES ('$name','$password','$gender','$email','$year','$class')");
    header("Location: dashboard.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Student</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        /* 1. Center everything on the page */
        body {
            display: flex;
            flex-direction: column;
            align-items: center; /* Horizontal center */
            justify-content: center; /* Vertical center (optional) */
            min-height: 100vh;
            margin: 0;
            background-color: #f4f6f8;
            text-align: center;
        }

        /* 2. Style the form container */
        form {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px; /* Makes the form shorter/narrower */
            margin-bottom: 20px;
        }

        /* 3. Style labels and inputs to be centered and neat */
        input[type="text"], 
        input[type="email"], 
        select {
            width: 100%;
            padding: 10px;
            margin: 10px 0 20px 0;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box; /* Ensures padding doesn't increase width */
            display: block;
        }

        /* 4. Style the "Add Student" button */
        button[name="add"] {
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

        button[name="add"]:hover {
            background-color: #1abc9c;
        }

        /* 5. The Back Button */
        .btn-back {
            display: inline-block;
            background-color: #34495e;
            color: #ffffff !important;
            padding: 8px 18px;
            text-decoration: none;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: 1px solid #2c3e50;
        }

        .btn-back:hover {
            background-color: #1abc9c;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        h2 {
            color: #2c3e50;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

    <h2>Add New Student</h2>

    <form method="POST">
        <label>Full Name:</label>
        <input type="text" name="name" placeholder="Enter name" required>

        <label>Password:</label>
        <input type="text" name="password" placeholder="Set password" required>

        <label>Gender:</label>
        <select name="gender">
            <option value="Male">Male</option>
            <option value="Female">Female</option>
        </select>

        <label>Email Address:</label>
        <input type="email" name="email" placeholder="example@mail.com" required>

        <label>Year Level:</label>
        <select name="year_level">
            <option value="1st Year">1st Year</option>
            <option value="2nd Year">2nd Year</option>
            <option value="3rd Year">3rd Year</option>
        </select>

        <label>Class:</label>
        <select name="class">
            <option value="A">A</option>
            <option value="B">B</option>
        </select>

        <button type="submit" name="add">Add Student</button>
    </form>

    <a href="dashboard.php" class="btn-back">&larr; Back to Dashboard</a>

    <script src="../js/script.js"></script>
</body>
</html>