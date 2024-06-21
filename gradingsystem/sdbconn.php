<?php
    // Your database connection
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

    // Get the form data
    $name = $_POST['name'];
    $age = $_POST['age'];
    $birthdate = $_POST['birthdate'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $section = $_POST['section'];
    $yearlevel = $_POST['yearlevel']; // This will be either 'grade9' or 'grade10'

    // Determine the table name based on the year level
    $table = $yearlevel === 'grade9' ? 'grade9' : 'grade10';

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO $table (name, age, birthdate, gender, address, email, password, role, section) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sisssssss", $name, $age, $birthdate, $gender, $address, $email, $password, $role, $section);

    // Execute the statement
    if ($stmt->execute()) {
        echo json_encode(array('message' => 'New record created successfully'));
    } else {
        echo json_encode(array('message' => 'Error: ' . $stmt->error));
    }

    // Close the statement and the connection
    $stmt->close();
    $conn->close();
?>
