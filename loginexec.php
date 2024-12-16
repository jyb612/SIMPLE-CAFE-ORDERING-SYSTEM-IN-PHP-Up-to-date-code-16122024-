<?php
// Start session
session_start();

// Connect to MySQL server
include('connection.php');

// Validation error flag
$errflag = false;

// Function to sanitize values received from the form. Prevents SQL injection
function clean($str) {
    return htmlspecialchars(trim($str)); // Better to use htmlspecialchars to prevent XSS
}

// Function to create a random password
function createRandomPassword() {
    $chars = "abcdefghijkmnopqrstuvwxyz023456789";
    $pass = '';

    for ($i = 0; $i <= 7; $i++) {
        $num = rand(0, strlen($chars) - 1);
        $pass .= $chars[$num];
    }

    return $pass;
}

$confirmation = createRandomPassword();
$login = clean($_POST['user']);
$password = clean($_POST['password']);

// Create query using prepared statements to prevent SQL injection
$qry = "SELECT * FROM members WHERE email=? AND password=?";
$stmt = mysqli_prepare($bd, $qry);
mysqli_stmt_bind_param($stmt, 'ss', $login, $password);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Check whether the query was successful or not
if ($result) {
    if (mysqli_num_rows($result) > 0) {
        // Login Successful
        session_regenerate_id();
        $member = mysqli_fetch_assoc($result);
        $_SESSION['SESS_MEMBER_ID'] = $member['id'];
        $_SESSION['SESS_FIRST_NAME'] = $confirmation;

        session_write_close();
        header("Location: order.php");
        exit();
    } else {
        // Login failed
        $errmsg_arr[] = 'Invalid email or password';
        $errflag = true;
    }
} else {
    die("Query failed: " . mysqli_error($bd)); // Show error if query fails
}

// If there was an error, redirect back
if ($errflag) {
    $_SESSION['ERRMSG_ARR'] = $errmsg_arr;
    session_write_close();
    header("Location: loginindex.php");
    exit();
}
?>
