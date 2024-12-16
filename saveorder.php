<?php
session_start();
require_once('connection.php'); // Ensure your connection is established here

// Check if the form was submitted and required POST variables are set
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'], $_POST['quantity'], $_POST['name'], $_POST['transcode'], $_POST['butadd'], $_POST['price'])) {
    
    // Sanitize and validate input
    $memid = mysqli_real_escape_string($bd, $_POST['id']);
    $qty = (int)$_POST['quantity']; // Ensure quantity is an integer
    $name = mysqli_real_escape_string($bd, $_POST['name']);
    $transcode = mysqli_real_escape_string($bd, $_POST['transcode']);
    $id = mysqli_real_escape_string($bd, $_POST['butadd']);
    $pprice = (int)$_POST['price']; // Ensure price is an integer
    
    // Calculate total
    $total = $pprice * $qty;

    // Prepare and execute the INSERT query
    $query = "INSERT INTO orderditems (customer, quantity, price, total, name, transactioncode) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($bd, $query);
    mysqli_stmt_bind_param($stmt, 'iiisss', $memid, $qty, $pprice, $total, $name, $transcode);

    // Execute and check for success
    if (mysqli_stmt_execute($stmt)) {
        header("Location: order.php"); // Redirect on success
        exit();
    } else {
        echo "Error: " . mysqli_error($bd); // Display error message
    }

    // Close the statement
    mysqli_stmt_close($stmt);
} else {
    echo "Invalid form submission."; // Handle invalid submissions
}

// Close the database connection
mysqli_close($bd);
?>
