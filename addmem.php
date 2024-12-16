<?php
session_start();
include('connection.php');

// Get POST values and sanitize
$studentnum = mysqli_real_escape_string($bd, $_POST['studentnum']);
$name = mysqli_real_escape_string($bd, $_POST['name']);
$surname = mysqli_real_escape_string($bd, $_POST['surname']);
$contacts = mysqli_real_escape_string($bd, $_POST['contacts']);
$password = mysqli_real_escape_string($bd, $_POST['password']); // Consider hashing passwords
$email = mysqli_real_escape_string($bd, $_POST['email']);

// Prepare SQL statement
$sql = "INSERT INTO members (studentnum, name, surname, contacts, password, email) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($bd, $sql);

if ($stmt) {
    // Bind parameters
    mysqli_stmt_bind_param($stmt, "ssssss", $studentnum, $name, $surname, $contacts, $password, $email);
    
    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
        header("location: loginindex.php");
        exit();
    } else {
        echo "Error: Could not execute the query: " . mysqli_error($bd);
    }
    
    // Close the statement
    mysqli_stmt_close($stmt);
} else {
    echo "Error: Could not prepare the statement: " . mysqli_error($bd);
}

// Close the connection
mysqli_close($bd);
?>
