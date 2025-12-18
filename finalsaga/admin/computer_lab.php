<?php
session_start();
include '../db.php';
if(!isset($_SESSION['admin'])) header("Location: ../index.php");

// Get lab info
$lab_id = isset($_GET['lab']) ? intval($_GET['lab']) : 1;
$labRes = $conn->query("SELECT * FROM computer_labs WHERE lab_id='$lab_id'");
$lab = $labRes->fetch_assoc();

// Fetch years and classes for alerts and sidebar
$years = ['1st Year','2nd Year','3rd Year'];
$classes = [];
$resC = $conn->query("SELECT * FROM classes");
while($rowC = $resC->fetch_assoc()){
    $classes[$rowC['year_level']][] = $rowC['name'];
}

// Handle seat assignment
if(isset($_POST['assign_seat'])){
    $student_id = $_POST['student_id'];
    $computer_number = $_POST['computer_number'];

    // Get student info
    $sRes = $conn->query("SELECT * FROM students WHERE student_id='$student_id'");
    $student = $sRes->fetch_assoc();

    // Check if seat already has student from same year and class
    $check = $conn->query("SELECT s.* FROM lab_seats l
        JOIN students s ON l.student_id=s.student_id
        WHERE l.lab_id='$lab_id' AND l.computer_number='$computer_number'
        AND s.year_level='{$student['year_level']}' AND s.class='{$student['class']}'");

    if($check->num_rows == 0){
        // Assign seat
        $conn->query("INSERT INTO lab_seats (lab_id,computer_number,student_id)
                      VALUES ('$lab_id','$computer_number','$student_id')");
        $msg = "Seat assigned successfully!";
    } else {
        $error = "This computer already has a student of the same class and year!";
    }
}

// Handle deleting a seat
if(isset($_GET['delete_seat'])){
    $seat_id = intval($_GET['delete_seat']);
    $conn->query("DELETE FROM lab_seats WHERE seat_id='$seat_id'");
}

// Handle alerts
if(isset($_POST['send_alert'])){
    $message = $_POST['alert_msg'];
    $student_id_alert = intval($_POST['student_id']);
    $class_alert = $_POST['class_alert'];

    if($student_id_alert > 0){
        $conn->query("INSERT INTO alerts (student_id,lab_id,message) VALUES ('$student_id_alert','$lab_id','$message')");
        $msg = "Alert sent to student!";
    } elseif($class_alert != "0") {
        list($year, $cls) = explode("-", $class_alert);
        $resS = $conn->query("SELECT student_id FROM students WHERE year_level='$year' AND class='$cls'");
        while($s = $resS->fetch_assoc()){
            $conn->query("INSERT INTO alerts (student_id,lab_id,message) VALUES ('{$s['student_id']}','$lab_id','$message')");
        }
        $msg = "Alert sent to class $year - Class $cls!";
    }
}

// Fetch all seats in this lab
$seats = $conn->query("SELECT l.seat_id, l.computer_number, s.name, s.student_id, s.year_level, s.class, s.last_active
                       FROM lab_seats l
                       JOIN students s ON l.student_id=s.student_id
                       WHERE l.lab_id='$lab_id'
                       ORDER BY l.computer_number ASC");


// Fetch all students for dropdown
$allStudents = $conn->query("SELECT * FROM students ORDER BY year_level,class,name");
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $lab['name']; ?> - Admin Panel</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        table { border-collapse: collapse; width: 80%; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
        button { padding:5px 10px; margin:2px; }
        .error {
            background-color: #e74c3c; 
            color:white;
         }
        .msg { 
            background-color: #2ecc71; 
            color:white;
        }
        .online { color: green; font-weight: bold; }
        .offline { color: black; font-weight: normal; }
        /* Styling for the Back to Dashboard link */
        .btn-back {
            display: inline-block;
            background-color: #34495e; /* Dark Blue-Grey */
            color: #ffffff !important;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            margin-bottom: 15px;
            margin-top: 12px;
            transition: background 0.3s ease;
        }

        .btn-back:hover {
            background-color: #2c3e50;
            text-decoration: none;
        }

        /* Styling for the Delete link inside the table */
        a {
            display: inline-block;
            background-color: #e74c3c; /* Red */
            color: #ffffff !important;
            padding: 5px 12px;
            text-decoration: none;
            border-radius: 4px;
            font-size: 13px;
            font-weight: bold;
            transition: background 0.3s ease;
        }

        a {
            background-color: #c0392b;
            text-decoration: none;
        }

        /* Shorten the inputs and select boxes */
        input[type="text"], 
        input[type="number"], 
        select {
            width: 100%;
            max-width: 250px; /* This makes them shorter */
            padding: 8px;
            margin: 5px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        /* Specific size for the PC number input */
        input[name="computer_number"] {
            max-width: 100px;
        }

        /* Ensure the table doesn't stretch columns unnecessarily */
        table {
            width: auto; /* Table only takes as much space as it needs */
            min-width: 600px;
        }

        .btn-delete {
            display: inline-block;
            background-color: #e74c3c;
            color: white !important;
            padding: 4px 12px;
            text-decoration: none;
            border-radius: 4px;
            font-size: 13px;
        }
                /* Center the main body text and headings */
        body {
            text-align: center;
        }

        /* Center the table and its content */
        table {
            margin-left: auto;
            margin-right: auto;
            width: 80%; /* Adjust width as needed */
            text-align: center; /* Centers text inside <td> and <th> */
        }

        table th, table td {
            text-align: center; /* Ensures content inside cells is centered */
            vertical-align: middle;
        }

        /* Center form elements */
        form {
            display: flex;
            flex-direction: column;
            align-items: center; /* Centers the inputs vertically */
            justify-content: center;
            margin-bottom: 30px;
        }

        /* Keep inputs short and centered */
        input[type="text"], 
        input[type="number"], 
        select {
            max-width: 300px;
            margin: 5px auto; /* Centers the input itself */
            text-align: center; /* Centers text inside the input */
        }

        /* Center the status spans and delete buttons */
        .online, .offline {
            display: block; /* Helps with centering in the cell */
            margin: 0 auto;
        }

        .btn-delete {
            display: inline-block;
            margin: 2px auto;
        }
    </style>
</head>
<body>
<h2><?php echo $lab['name']; ?> - Seat Management & Alerts</h2>
<a href="dashboard.php" class="btn-back">← Back to Dashboard</a>

<?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>
<?php if(isset($msg)) echo "<p class='msg'>$msg</p>"; ?>

<!-- Assign seat -->
<h3>Assign Student to Computer</h3>
<form method="POST">
    Student:
    <select name="student_id" required>
        <?php while($s = $allStudents->fetch_assoc()){
            echo "<option value='{$s['student_id']}'>{$s['name']} ({$s['year_level']} - Class {$s['class']})</option>";
        } ?>
    </select>
    Computer Number:
    <input type="number" name="computer_number" min="1" max="<?php echo $lab['total_computers']; ?>" required>
    <button type="submit" name="assign_seat">Assign</button>
</form>

<!-- Seats Table -->
<h3>Seats in <?php echo $lab['name']; ?></h3>
<table>
<thead>
    <tr>
        <th>Computer Number</th>
        <th>Student(s) Assigned</th>
        <th style="text-align: center;">Action</th> </tr>
</thead>
<tbody>
<?php
$computers = [];
$seats->data_seek(0); // Reset result pointer
while($row = $seats->fetch_assoc()){
    $computers[$row['computer_number']][] = $row;
}

for($i=1; $i<=$lab['total_computers']; $i++){
    echo "<tr>";
    echo "<td><strong>PC #$i</strong></td>";
    
    // Column 2: Student Names
    echo "<td>";
    if(isset($computers[$i])){
        foreach($computers[$i] as $stu){
            $online = (strtotime($stu['last_active']) > time() - 30);
            $colorClass = $online ? 'online' : 'offline';
            echo "<div style='height: 35px; display: flex; align-items: center;'>";
            echo "<span id='student-{$stu['student_id']}' class='$colorClass'>{$stu['name']} ({$stu['year_level']} - {$stu['class']})</span>";
            echo "</div>";
        }
    } else {
        echo "<span style='color: #ccc;'>Available</span>";
    }
    echo "</td>";

    // Column 3: Action Column (The Delete Buttons)
    echo "<td style='text-align: center;'>";
    if(isset($computers[$i])){
        foreach($computers[$i] as $stu){
            echo "<div style='height: 35px; display: flex; align-items: center; justify-content: center;'>";
            echo "<a href='?lab=$lab_id&delete_seat={$stu['seat_id']}' class='btn-delete' onclick='return confirm(\"Remove this student?\")'>Delete</a>";
            echo "</div>";
        }
    } else {
        echo "-";
    }
    echo "</td>";
    
    echo "</tr>";
}
?>
</tbody>
</table>

<!-- Alert Section -->
<h3>Alert Students</h3>
<form method="POST">
    Alert Message: <input type="text" name="alert_msg" required><br><br>
    Student:
    <select name="student_id">
        <option value="0">--Select Individual Student--</option>
        <?php
        $sRes = $conn->query("SELECT * FROM students ORDER BY year_level,class,name");
        while($s = $sRes->fetch_assoc()){
            echo "<option value='{$s['student_id']}'>{$s['name']} ({$s['year_level']} - Class {$s['class']})</option>";
        }
        ?>
    </select>
    Class:
    <select name="class_alert">
        <option value="0">--Select Class--</option>
        <?php
        foreach($years as $year){
            if(isset($classes[$year])){
                foreach($classes[$year] as $c){
                    echo "<option value='$year-$c'>$year - Class $c</option>";
                }
            }
        }
        ?>
    </select>
    <button type="submit" name="send_alert">Send Alert</button>
</form>

<script>
fetch("../api/online_status.php")
  .then(res => res.json())
  .then(data => {
    data.forEach(s => {
      const el = document.getElementById("student-" + s.student_id);
      if(el){
        el.className = s.status === "online" ? "online" : "offline";
      }
    });
  });
</script>

<script src="../js/script.js"></script>

</body>
</html>
