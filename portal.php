<?php
session_start();
require_once('auth.php');
include('connection.php'); // Ensure your connection is established here

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wings Cafe</title>
    <style>
		    .button-image {
		        background-image: url('images/button.png'); /* Your button image */
		        background-size: cover; /* Cover the entire button */
		        border: none; /* Remove default border */
		        width: 45px; /* Set your desired button width */
		        height: 30px; /* Set your desired button height */
		        cursor: pointer; /* Change cursor to pointer on hover */
		    }
        .style1 {
            color: #000000;
            font-weight: bold;
            font-size: 24px;
        }
    </style>
</head>
<body>
<form action="saveorder.php" method="post">
    <input name="id" type="hidden" value="<?php echo htmlspecialchars($_SESSION['SESS_MEMBER_ID']); ?>" />
    <input name="transcode" type="hidden" value="<?php echo htmlspecialchars($_SESSION['SESS_FIRST_NAME']); ?>" />
    <table width="400" border="0" cellpadding="0" cellspacing="0">
        <?php
        if (isset($_GET['id'])) {
            $id = (int)$_GET['id']; // Sanitize input
            $result = mysqli_query($bd, "SELECT * FROM products WHERE product_id = $id");

            while ($row3 = mysqli_fetch_assoc($result)) {
                echo '<tr>';
                echo '<td width="80"><img src="images/bgr/' . htmlspecialchars($row3['product_photo']) . '" alt="Product Image" /></td>';
                echo '<td width="200"><span class="style1">' . htmlspecialchars($row3['name']) . '</span></td>';
                echo '</tr>';
                echo '<tr>';
                echo '<td width="80"><input name="name" type="text" value="' . htmlspecialchars($row3['name']) . '" readonly/><input name="product_id" type="hidden" value="' . htmlspecialchars($row3['product_id']) . '"/></td>';
                echo '</tr>';
            }
        }
        ?>
    </table>
    <br />
    <table width="400" border="0" cellpadding="0" cellspacing="0" style="color:#000000;">
        <tr>
            <td width="128">Price</td>
            <td width="93">Quantity</td>
        </tr>
        <?php
        if (isset($_GET['id'])) {
            $id = (int)$_GET['id']; // Sanitize input
            $result = mysqli_query($bd, "SELECT * FROM products WHERE product_id = $id");

            while ($row3 = mysqli_fetch_assoc($result)) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($row3['price']) . '</td>';
                echo "<input type='hidden' name='price' value='" . htmlspecialchars($row3['price']) . "'>";
                echo "<input type='hidden' name='name' value='" . htmlspecialchars($row3['name']) . "'>";
                echo '<td><input type="text" size="5" name="quantity" required></td>'; // Added required attribute
                echo '<td><input name="butadd" type="submit" value="" class="button-image" /></td>';
                echo '</tr>';
            }
        }
        ?>
    </table>
</form>
</body>
</html>
