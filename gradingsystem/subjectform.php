<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gradingsystem";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $subject_id = $_POST["subject_id"];
    $subject_name = $_POST["subject_name"];
    $year_level = $_POST["year_level"];
    $section = $_POST["section"];

    $sql = "INSERT INTO subject (subject_id, subject_name, year_level, section)
            VALUES ('$subject_id', '$subject_name', '$year_level', '$section')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
