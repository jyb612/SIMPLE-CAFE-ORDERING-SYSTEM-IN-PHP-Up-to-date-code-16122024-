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
    <link href="style.css" rel="stylesheet" type="text/css" />
    <link href="src/facebox.css" media="screen" rel="stylesheet" type="text/css" />

    <script src="lib/jquery.js" type="text/javascript"></script>
    <script src="src/facebox.js" type="text/javascript"></script>
    <script type="text/javascript">
        // JavaScript code...
    </script>
</head>
<body onLoad="ShowTime()">
<div id="container">
    <div id="header_section">
        <div style="float:right; margin-right:30px;">
            <?php 
            $id = $_SESSION['SESS_MEMBER_ID'];
            $resulta = mysqli_query($bd, "SELECT * FROM members WHERE id = '$id'");

            while ($row = mysqli_fetch_assoc($resulta)) {
                echo htmlspecialchars($row['name'] . ' ' . $row['surname'] ?? '');
            }
            ?>&nbsp;<a href="logout.php" id="logout-button">Logout</a></div>
        </div>
    <div id="menu_bg">
        <div id="menu">
            <ul>
                <div style="float:left">
                    <input name="time" type="text" id="txt" style="border: 0; font-size: 25px; height: 23px; width: 130px; background-color:#000000; color:#FF0000; font-stretch:wider" readonly />
                </div>
            </ul>
        </div>
    </div>
    <div id="header"></div>
    <div id="content">
        <div id="content_left">
            <div class="text">Select From Menu Below</div>
            <div class="view1">
                <?php
                $result2 = mysqli_query($bd, "SELECT * FROM products");

                while ($row2 = mysqli_fetch_assoc($result2)) {
                    $id = $row2['id'];
                    echo '<div class="box"> <a rel="facebox" href=portal.php?id=' . htmlspecialchars($row2["product_id"] ?? '') . '><img src="images/bgr/' . htmlspecialchars($row2['product_photo'] ?? '') . '" width="75" height="75" /></a>';
                    echo '<div class="textbox"> ' . htmlspecialchars($row2['name'] ?? '') . ' </div>';
                    echo '</div>';
                }
                ?>
            </div>
        </div>

        <div id="content_right">
            <form method="post" action="confirm.php" name="abcd" onsubmit="return validateForm()">
                <input name="id" type="hidden" value="<?php echo htmlspecialchars($_SESSION['SESS_MEMBER_ID'] ?? '') ?>" />
                <input name="transactioncode" type="hidden" value="<?php echo htmlspecialchars($_SESSION['SESS_FIRST_NAME'] ?? '') ?>" />

                <h2>Order Details</h2>
                <table width="335" border="1" cellpadding="0" cellspacing="0" style="color:#000000; font-family:Arial, Helvetica, sans-serif; font-size:10px;">
                    <tr>
                        <td width="90"><div align="center"><strong>Product Name </strong></div></td>
                        <td width="27"><div align="center"><strong>Qty</strong></div></td>
                        <td width="45"><div align="center"><strong>Price</strong></div></td>
                        <td width="46"><div align="center"><strong>Total</strong></div></td>
                        <td width="29"><div align="center"><strong>Del</strong></div></td>
                    </tr>
                    <?php
                    $memid = $_SESSION['SESS_FIRST_NAME'];
                    $resulta = mysqli_query($bd, "SELECT * FROM orderditems WHERE transactioncode = '$memid'");

                    while ($row = mysqli_fetch_assoc($resulta)) {
                        echo '<tr>';
                        echo '<td><div align="center">' . htmlspecialchars($row['name'] ?? '') . '</div></td>';
                        echo '<td><div align="center">' . htmlspecialchars($row['quantity'] ?? '') . '</div></td>';
                        echo '<td><div align="center">' . htmlspecialchars($row['price'] ?? '') . '</div></td>';
                        echo '<td><div align="center">' . htmlspecialchars($row['total'] ?? '') . '</div></td>';
                        echo '<td><div align="center"><a href="deleteorder.php?id=' . htmlspecialchars($row["id"] ?? '') . '">Cancel</a></div></td>';
                        echo '</tr>';
                    }
                    ?>
                    <tr>
                        <td colspan="4"><div align="right">Grand Total: </div></td>
                        <td colspan="2"><div align="left">
                        <?php
                        $result = mysqli_query($bd, "SELECT sum(total) as grand_total FROM orderditems WHERE transactioncode = '$memid'");

                        if ($rows = mysqli_fetch_assoc($result)) { 
                            echo '<input name="total" type="text" size="10" value="' . htmlspecialchars($rows['grand_total'] ?? '') . '"/>'; 
                        }
                        ?>
                        </div></td>
                    </tr>
                </table>
                <br />
                <table width="273" border="0" cellpadding="0" cellspacing="0" style="color:#000000; font-family:Arial, Helvetica, sans-serif; font-size:10px;">
                    <tr>
                        <td><div align="right"><strong><h3>Student Num: </h3></strong></div></td>
                        <td><input type="text" name="num"> <span class="style2"></span></td>
                    </tr>		
                    <tr>
                        <td colspan="2">
                            <label>
                                <input type="checkbox" name="checkbox" value="checkbox" />
                                I Agree To The <a rel="facebox" href="terms.php">Terms and Conditions</a> of this company
                            </label>
                        </td>
                    </tr>
                </table><br />
                <input name="" type="submit" value="Confirm Order" />
            </form>
        </div>
    </div>
</div>
</body>
</html>
