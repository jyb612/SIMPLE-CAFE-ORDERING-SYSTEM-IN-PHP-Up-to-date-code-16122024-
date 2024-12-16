<?php
if (isset($_GET['id'])) {
    include('connection.php'); // Ensure this file sets up the $bd connection

    $id = (int)$_GET['id']; // Cast to an integer to prevent SQL injection

    // Prepare and execute the delete statement
    $stmt = $bd->prepare("DELETE FROM orderditems WHERE id = ?");
    $stmt->bind_param('i', $id); // 'i' indicates the parameter type is integer

    if ($stmt->execute()) {
        header("Location: order.php");
        exit();
    } else {
        echo "Error deleting item: " . $stmt->error;
    }

    $stmt->close(); // Close the prepared statement
    $bd->close(); // Close the database connection
}
?>
