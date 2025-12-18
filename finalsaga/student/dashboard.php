<?php
session_start();
include '../db.php';
if(!isset($_SESSION['student'])) header("Location: ../index.php");

$student_id = $_SESSION['student'];

// Update last_active on page load
$conn->query("UPDATE students SET last_active=NOW() WHERE student_id='$student_id'");

// Fetch student info
$studentRes = $conn->query("SELECT * FROM students WHERE student_id='$student_id'");
$student = $studentRes->fetch_assoc();

// Fetch alerts
$alertsRes = $conn->query("SELECT * FROM alerts WHERE student_id='$student_id'");
$alerts = [];
while($a = $alertsRes->fetch_assoc()){
    $alerts[] = $a;
}

// Handle clearing alerts
if(isset($_POST['clear_alerts'])){
    $conn->query("DELETE FROM alerts WHERE student_id='$student_id'");
    header("Location: dashboard.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        body {
            margin: 0;
            background-color: #f4f6f8;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* 1. Navigation Styling */
        .topnav {
            background-color: #2c3e50;
            color: #fff;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .topnav a {
            color: #fff;
            text-decoration: none;
            margin-left: 15px;
            font-weight: 600;
        }

        .topnav a:hover { color: #1abc9c; }

        /* 2. Centering the Content */
        .main {
            display: flex;
            flex-direction: column;
            align-items: center; /* Centers horizontally */
            padding: 40px 20px;
            text-align: center;
        }

        /* 3. Alert Box Design */
        .alert-container {
            background: white;
            border: 2px solid #e74c3c; /* Red border */
            border-radius: 10px;
            padding: 20px;
            width: 100%;
            max-width: 500px;
            margin-bottom: 30px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }

        .alert-container h3 {
            color: #e74c3c;
            margin-top: 0;
        }

        .alert-list {
            list-style: none;
            padding: 0;
            text-align: left;
        }

        .alert-item {
            padding: 10px;
            border-bottom: 1px solid #eee;
            color: #333;
        }

        .alert-item:last-child { border-bottom: none; }

        /* 4. Laboratory Buttons Area */
        .lab-section {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            width: 100%;
            max-width: 500px;
        }

        button {
            padding: 12px 20px;
            background-color: #2980b9;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
            margin: 10px;
            transition: 0.3s;
        }

        button:hover {
            background-color: #1abc9c;
            transform: translateY(-2px);
        }

        .btn-clear {
            background-color: #95a5a6;
            margin-top: 15px;
        }

        .btn-clear:hover { background-color: #7f8c8d; }
    </style>
</head>
<body>

<div class="topnav">
    <div class="left">
        Welcome, <strong><?php echo $student['name']; ?></strong> 
        <small style="margin-left:10px; opacity:0.8;">(<?php echo $student['year_level']." - Class ".$student['class']; ?>)</small>
    </div>
    <div class="right">
        <a href="change_password.php">Change Password</a>
        <a href="../index.php">Logout</a>
    </div>
</div>

<div class="main">
    
    <div class="alert-container">
        <h3>📢 Your Alerts</h3>
        <?php if(count($alerts) == 0): ?>
            <p style="color: #7f8c8d;">No new alerts from the instructor.</p>
        <?php else: ?>
            <div class="alert-list">
                <?php foreach($alerts as $a): ?>
                    <div class="alert-item">📍 <?php echo $a['message']; ?></div>
                <?php endforeach; ?>
            </div>
            <form method="POST">
                <button type="submit" name="clear_alerts" class="btn-clear">Clear Alerts</button>
            </form>
        <?php endif; ?>
    </div>

    <div class="lab-section">
        <h3>🖥️ Computer Laboratories</h3>
        <p>Select a laboratory to view seat availability:</p>
        <a href="computer_lab.php?lab=1"><button>Laboratory 1</button></a>
        <a href="computer_lab.php?lab=2"><button>Laboratory 2</button></a>
    </div>

</div>

<script>
// Auto-update last_active every 10 seconds
setInterval(() => {
    fetch('update_last_active.php');
}, 10000);
</script>

</body>
</html>