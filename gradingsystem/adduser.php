<?php
include 'conn.php'; // Include the first database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Firstname = $_POST['firstname'];
    $Middlename = $_POST['middlename'];
    $Lastname = $_POST['lastname'];
    $ExtensionName = $_POST['extensionname'];
    $Email = $_POST['email']; 
    $Address = $_POST['address'];
    $FathersName = $_POST['fathersname'];
    $FathersOccupation = $_POST['fathersoccupation'];
    $MothersName = $_POST['mothersname'];
    // Removed $MothersOccupation
    $Gender = $_POST['gender'];
    $Birthdate = $_POST['birthdate'];
    $Username = $_POST['username'];
    $Password = $_POST['password'];
    $Picture = $_POST['picture'];
    $table = $_POST['table'];

    $sql = "INSERT INTO $table (Firstname, Middlename, Lastname, ExtensionName, Email, Address, FathersName, FathersOccupation, MothersName, Gender, Birthdate, Username, Password, Picture)
    VALUES ('$Firstname', '$Middlename', '$Lastname', '$ExtensionName', '$Email', '$Address', '$FathersName', '$FathersOccupation', '$MothersName', '$Gender', '$Birthdate', '$Username', '$Password', '$Picture')";

    if ($conn->query($sql) === TRUE) {
        $message = "<script>alert('New record created successfully in $table');</script>";
    } else {
        $message = "<script>alert('Error: " . $sql . "<br>" . $conn->error . "');</script>";
    }

    $conn->close();
    
    // Redirect to the same page or a different one
    header("Location: pass2.php");
    exit;
}
?>
