<?php
session_start();
include '../db.php';

// Redirect if not admin
if(!isset($_SESSION['admin'])){
    header("Location: ../index.php");
    exit;
}

// Fetch students count by year level for chart
$chartData = [];
$years = ['1st Year','2nd Year','3rd Year'];
foreach($years as $year){
    $res = $conn->query("SELECT COUNT(*) as total FROM students WHERE year_level='$year'");
    $row = $res->fetch_assoc();
    $chartData[] = $row['total'];
}

// Fetch classes for dropdown sidebar
$classes = [];
$res = $conn->query("SELECT * FROM classes");
while($row = $res->fetch_assoc()){
    $classes[$row['year_level']][] = $row;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* Delete Button Design */
        .btn-delete {
            display: inline-block;
            background-color: #e74c3c; /* Red */
            color: white !important;   /* White text */
            padding: 6px 12px;
            text-decoration: none;
            border-radius: 4px;
            font-size: 13px;
            font-weight: 600;
            transition: background 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn-delete:hover {
            background-color: #c0392b; /* Darker red on hover */
            text-decoration: none;
        }

        /* Edit Button Design (Optional, for consistency) */
        .btn-edit {
            display: inline-block;
            background-color: #3498db; /* Blue */
            color: white !important;
            padding: 6px 12px;
            text-decoration: none;
            border-radius: 4px;
            font-size: 13px;
            font-weight: 600;
            margin-right: 5px;
        }

        .btn-edit:hover {
            background-color: #2980b9;
        }
            table th:last-child, 
            table td:last-child {
            text-align: center;
            width: 150px; /* Gives enough space for the buttons */
        }
    </style>
</head>
<body>

<!-- Top Navigation Menu -->
<div class="topnav">
    <div class="left">Admin Dashboard</div>
    <div class="right">
        <a href="add_student.php">Add Student</a>
        <a href="add_class.php">Add Class</a>
        <a href="computer_lab.php?lab=1">ComLab 1</a>
        <a href="computer_lab.php?lab=2">ComLab 2</a>
        <a href="../index.php">Logout</a>
    </div>
</div>

<div class="container">

    <!-- Sidebar for classes -->
    <div class="sidebar">
        <h4>Classes</h4>
        <?php foreach($years as $year): ?>
            <strong><?php echo $year; ?></strong>
            <ul>
            <?php 
            if(isset($classes[$year])){
                foreach($classes[$year] as $class){
                    echo "<li><a href='?year=$year&class={$class['name']}'>Class {$class['name']}</a></li>";
                }
            }
            ?>
            </ul>
        <?php endforeach; ?>
    </div>

    <!-- Main Content -->
    <div class="main">
        <?php
        // Display students of selected class
        if(isset($_GET['year']) && isset($_GET['class'])){
            $year = $_GET['year'];
            $class = $_GET['class'];
            $res = $conn->query("SELECT * FROM students WHERE year_level='$year' AND class='$class'");
            echo "<h3>$year - Class $class</h3>";
            echo "<table>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Gender</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>";
            while($row = $res->fetch_assoc()){
                echo "<tr>
                        <td>{$row['student_id']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['gender']}</td>
                        <td>{$row['email']}</td>
                        <td>
                        
                            <a href='edit_student.php?id={$row['student_id']}' class='btn-edit'>Edit</a>
                            <a href='delete_student.php?id={$row['student_id']}' class='btn-delete' onclick=\"return confirm('Are you sure you want to delete this student?');\">Delete</a>
                        
                        </td>
                    </tr>";
            }
            echo "</table>";
        }
        ?>

        <!-- Classes Table -->
        <h3>All Classes</h3>
        <table>
            <tr>
                <th>Class Name</th>
                <th>Year Level</th>
                <th>Instructor</th>
                <th>Action</th>
            </tr>
            <?php
            $classRes = $conn->query("SELECT * FROM classes ORDER BY year_level, name");
            while($row = $classRes->fetch_assoc()){
                echo "<tr>";
                echo "<td>{$row['name']}</td>";
                echo "<td>{$row['year_level']}</td>";
                echo "<td>{$row['instructor_name']}</td>";
                echo "<td>
                        <a href='delete_class.php?id={$row['id']}' class='btn-delete' onclick=\"return confirm('Are you sure you want to delete this class?');\">Delete</a>
                      </td>";
                echo "</tr>";
            }
            ?>
        </table>

        <!-- Chart -->
        <h3>Students per Year Level</h3>
        <canvas id="yearChart" width="400" height="150"></canvas>
    </div>
</div>

<script>
var ctx = document.getElementById('yearChart').getContext('2d');
var yearChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['1st Year','2nd Year','3rd Year'],
        datasets: [{
            label: 'Number of Students',
            data: <?php echo json_encode($chartData); ?>,
            backgroundColor: ['#3498db','#2ecc71','#e74c3c']
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } }
    }
});
</script>
<script>
fetch("../api/students.php")
  .then(res => res.json())
  .then(data => {
    console.log("Students from API:", data);
  });
</script>

</body>
</html>
