<?php
session_start();
include '../db.php';
if(!isset($_SESSION['admin'])) header("Location: ../index.php");

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$res = $conn->query("SELECT * FROM students WHERE student_id='$id'");
if($res->num_rows == 0) die("Student not found!");
$student = $res->fetch_assoc();

if(isset($_POST['update'])){
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $year = $_POST['year_level'];
    $class = $_POST['class'];

    $conn->query("UPDATE students SET name='$name', gender='$gender', email='$email', year_level='$year', class='$class' WHERE student_id='$id'");
    header("Location: dashboard.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
    <link rel="stylesheet" href="../css/style.css">


</head>
<body>
<h2>Edit Student</h2>
<form method="POST">
    Name: <input type="text" name="name" value="<?php echo $student['name']; ?>" required><br><br>
    Gender: 
    <select name="gender">
        <option value="Male" <?php if($student['gender']=='Male') echo 'selected'; ?>>Male</option>
        <option value="Female" <?php if($student['gender']=='Female') echo 'selected'; ?>>Female</option>
    </select><br><br>
    Email: <input type="email" name="email" value="<?php echo $student['email']; ?>" required><br><br>
    Year Level:
    <select name="year_level">
        <option value="1st Year" <?php if($student['year_level']=='1st Year') echo 'selected'; ?>>1st Year</option>
        <option value="2nd Year" <?php if($student['year_level']=='2nd Year') echo 'selected'; ?>>2nd Year</option>
        <option value="3rd Year" <?php if($student['year_level']=='3rd Year') echo 'selected'; ?>>3rd Year</option>
    </select><br><br>
    Class:
    <select name="class">
        <option value="A" <?php if($student['class']=='A') echo 'selected'; ?>>A</option>
        <option value="B" <?php if($student['class']=='B') echo 'selected'; ?>>B</option>
    </select><br><br>
    <button type="submit" name="update">Update Student</button>
</form>
<a href="dashboard.php">Back</a>
<script src="../js/script.js"></script>
</body>
</html>
