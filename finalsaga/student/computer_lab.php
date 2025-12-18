<?php
session_start();
include '../db.php';
if(!isset($_SESSION['student'])) header("Location: ../index.php");

$student_id = $_SESSION['student'];
$studentRes = $conn->query("SELECT * FROM students WHERE student_id='$student_id'");
$student = $studentRes->fetch_assoc();

// Get lab info
$lab_id = isset($_GET['lab']) ? intval($_GET['lab']) : 1;
$labRes = $conn->query("SELECT * FROM computer_labs WHERE lab_id='$lab_id'");
$lab = $labRes->fetch_assoc();

// Handle seat selection
if(isset($_POST['computer_number'])){
    $computer_number = intval($_POST['computer_number']);

    // Check if computer already has student of SAME class & year
    $check = $conn->query("SELECT s.* FROM lab_seats l
        JOIN students s ON l.student_id=s.student_id
        WHERE l.lab_id='$lab_id' AND l.computer_number='$computer_number'
        AND s.year_level='{$student['year_level']}' AND s.class='{$student['class']}'");

    if($check->num_rows == 0){
        // Remove previous seat
        $conn->query("DELETE FROM lab_seats WHERE lab_id='$lab_id' AND student_id='$student_id'");
        // Assign new seat
        $conn->query("INSERT INTO lab_seats (lab_id,computer_number,student_id) VALUES ('$lab_id','$computer_number','$student_id')");
        $msg = "Seat assigned successfully!";
    } else {
        $error = "Cannot choose this computer. Same class and year already seated!";
    }
}

// Fetch all seats
$seatsRes = $conn->query("SELECT l.seat_id, l.computer_number, s.name, s.year_level, s.class
                          FROM lab_seats l
                          JOIN students s ON l.student_id=s.student_id
                          WHERE l.lab_id='$lab_id'");
$computers = [];
while($row = $seatsRes->fetch_assoc()){
    $computers[$row['computer_number']][] = $row;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $lab['name']; ?> - Seat Selection</title>
    <link rel="stylesheet" href="../css/style.css">
    <script>
        function chooseSeat(number){
            if(confirm("Do you want to choose computer "+number+"?")){
                var form = document.getElementById("seatForm");
                document.getElementById("computer_number_input").value = number;
                form.submit();
            }
        }
    </script>
</head>
<body>
<div class="topnav">
    <div class="left">
        <?php echo $student['name']; ?> (<?php echo $student['year_level']." - Class ".$student['class']; ?>)
    </div>
    <div class="center">
        <?php echo $lab['name']; ?>
    </div>
    <div class="right">
        <a href="dashboard.php">Back</a>
        <a href="change_password.php">Change Password</a>
        <a href="../index.php">Logout</a>
    </div>
</div>

<div class="main">
    <?php if(isset($msg)) echo "<p class='msg'>$msg</p>"; ?>
    <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>

    <h3>Choose Your Seat</h3>
    <form method="POST" id="seatForm">
        <input type="hidden" name="computer_number" id="computer_number_input" value="">
        <?php
        for($i=1; $i<=$lab['total_computers']; $i++){
            $color = 'white';
            $disabled = '';
            $title = "Empty";

            if(isset($computers[$i])){
                foreach($computers[$i] as $stu){
                    $title .= " - {$stu['name']} ({$stu['year_level']} - Class {$stu['class']})";
                    if($stu['year_level']==$student['year_level'] && $stu['class']==$student['class']){
                        $color = 'red';
                        $disabled = 'disabled';
                    } else {
                        $color = 'green';
                    }
                }
            }

            $onclick = $disabled ? '' : "onclick='chooseSeat($i)'";
            echo "<button type='button' class='seat-btn $color' title='$title' $onclick $disabled>$i</button>";
        }
        ?>
    </form>
</div>
</body>
</html>
