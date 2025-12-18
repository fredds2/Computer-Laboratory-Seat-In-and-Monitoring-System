<?php
session_start();
include '../db.php';
if(!isset($_SESSION['admin'])) header("Location: ../index.php");

if(isset($_POST['add'])){
    $class_name = $_POST['class_name'];
    $year_level = $_POST['year_level'];
    $instructor = $_POST['instructor'];

    $conn->query("INSERT INTO classes (name,year_level,instructor_name) VALUES ('$class_name','$year_level','$instructor')");
    header("Location: dashboard.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Class</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        /* 1. Center everything on the screen */
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

        /* 2. Styling the Heading (Apealing Style) */
        h2 {
            margin-bottom: 20px;
            font-size: 26px;
            font-weight: 800;
            text-transform: uppercase;
            background: linear-gradient(45deg, #2980b9, #1abc9c);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* 3. Style the form container and shorten inputs */
        form {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 350px; /* Shortens the form width */
            margin-bottom: 20px;
        }

        label {
            display: block;
            text-align: left;
            font-weight: 600;
            margin-bottom: 5px;
            color: #555;
        }

        input[type="text"], 
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 6px;
            box-sizing: border-box; /* Ensures width stays correct */
        }

        /* 4. Style the Add Class button */
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

        /* 5. The Designed Back Button */
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
            border: 1px solid #2c3e50;
        }

        .btn-back:hover {
            background-color: #7f8c8d;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>

    <h2>Add New Class</h2>

    <form method="POST">
        <label>Class Name</label>
        <input type="text" name="class_name" placeholder="e.g. Class A" required>

        <label>Year Level</label>
        <select name="year_level">
            <option value="1st Year">1st Year</option>
            <option value="2nd Year">2nd Year</option>
            <option value="3rd Year">3rd Year</option>
        </select>

        <label>Instructor Name</label>
        <input type="text" name="instructor" placeholder="Enter full name" required>

        <button type="submit" name="add">Add Class</button>
    </form>

    <a href="dashboard.php" class="btn-back">&larr; Back to Dashboard</a>

</body>
</html>