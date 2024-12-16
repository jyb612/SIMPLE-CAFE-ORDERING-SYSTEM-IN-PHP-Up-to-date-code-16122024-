<?php
session_start();
require_once('auth.php');
include('connection.php');

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $total = $_POST['total'] ?? '';
    $transactioncode = $_POST['transactioncode'] ?? '';
    $student = $_POST['num'] ?? '';

    // Check if total, transactioncode, and student number are provided
    if (empty($total) || empty($transactioncode) || empty($student)) {
        echo "Missing required fields.";
        exit(0);
    }

    // Check if the student number exists in the database
    $query = "SELECT * FROM members WHERE studentnum = ?";
    $stmt = $bd->prepare($query);
    $stmt->bind_param('s', $student); // assuming studentnum is a string
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo "Wrong student number.";
        exit(0);
    }

    // Get the student id (assuming the first record is needed)
    $info = $result->fetch_assoc();
    $stud = $info['id']; // Adjust according to your database structure

    // Prepare and execute the insert statement
    $transactiondate = date("m/d/Y");
    $insertQuery = "INSERT INTO wings_orders (cusid, total, transactiondate, transactioncode) VALUES (?, ?, ?, ?)";
    $insertStmt = $bd->prepare($insertQuery);
    $insertStmt->bind_param('isss', $stud, $total, $transactiondate, $transactioncode);

    if ($insertStmt->execute()) {
        echo "Order placed successfully.";
    } else {
        echo "Error placing order: " . $insertStmt->error;
    }
}
?>

<form method="post" action="">
    <input name="transactioncode" type="hidden" value="<?php echo htmlspecialchars($transactioncode); ?>" />
    <input name="total" type="hidden" value="<?php echo htmlspecialchars($total); ?>" />
</form>
<a rel="facebox" href="order.php"><img src="images/28.png" width="75px" height="75px" /></a>
