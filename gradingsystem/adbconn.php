<?php
// adbconn.php

include 'conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = $_POST["fname"];
    $mname = $_POST["mname"];
    $lname = $_POST["lname"];
    $ename = $_POST["ename"];
    $nickname = $_POST["nickname"];
    $age = $_POST["age"];
    $gender = $_POST["gender"];
    $birthdate = $_POST["birthdate"];
    $address = $_POST["address"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $role = $_POST["role"];
    $img = $_POST["img"];

    $sql = "INSERT INTO admins (fname, mname, lname, ename, nickname, age, gender, birthdate, address, username, password, role, img)
    VALUES ('$fname', '$mname', '$lname', '$ename', '$nickname', '$age', '$gender', '$birthdate', '$address', '$username', '$password', '$role', '$img')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(['success' => true, 'message' => 'New record created successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $sql . '<br>' . $conn->error]);
    }

    $conn->close();
}
?>
