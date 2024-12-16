<?php
session_start();
include("connection.php"); // Ensure you're using MySQLi or PDO

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Query to find the user by email
    $stmt = $bd->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $member = $result->fetch_assoc();

        // Debugging output
        echo "Stored Password: " . $member['password'] . "<br>";
        echo "Password Entered: " . $password . "<br>";

        // Compare the entered password with the stored plain text password
        if ($password === $member['password']) {
            session_regenerate_id();
            $_SESSION['SESS_MEMBER_ID'] = $member['id'];
            $_SESSION['SESS_FIRST_NAME'] = $member['username'];
            session_write_close();
            header("Location: home_admin.php");
            exit();
        } else {
            echo "<h4 style='color:red;'>Invalid password.</h4>";
        }
    } else {
        echo "<h4 style='color:red;'>No user found.</h4>";
    }

    // Close the statement and connection
    $stmt->close();
    $bd->close();
}
?>
