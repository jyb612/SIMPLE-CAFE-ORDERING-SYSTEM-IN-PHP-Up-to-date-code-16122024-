<?php
    session_start();
    require_once('auth.php');
    include('connection.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Wings Cafe</title>
<link href="css/ble.css" rel="stylesheet" type="text/css" />
<link href="css/main.css" rel="stylesheet" type="text/css" />
<link href="src/facebox.css" media="screen" rel="stylesheet" type="text/css" />

<script src="lib/jquery.js" type="text/javascript"></script>
<script src="src/facebox.js" type="text/javascript"></script>
<script type="text/javascript">
    jQuery(document).ready(function($) {
      $('a[rel*=facebox]').facebox({
        loadingImage : 'src/loading.gif',
        closeImage   : 'src/closelabel.png'
      });
    });
</script>
</head>

<body>
<div style="width:900px; margin:0 auto; position:relative; border:3px solid rgba(0,0,0,0); -webkit-border-radius:5px; -moz-border-radius:5px; border-radius:5px; -webkit-box-shadow:0 0 18px rgba(0,0,0,0.4); -moz-box-shadow:0 0 18px rgba(0,0,0,0.4); box-shadow:0 0 18px rgba(0,0,0,0.4); margin-top:10%;">
<div style="background-color:#ff3300; height:40px; margin-bottom:10px;">
<div style="float:right; width:50px; margin-right:20px; background-color:#cccccc; text-align:center;"><a href="home_admin.php">back</a></div>
<div style="float:left; margin-left:10px; margin-top:10px;"><strong>Welcome</strong> <?php echo htmlspecialchars($_SESSION['SESS_FIRST_NAME']);?></div>
</div>

<br /><label style="margin-left:12px;">Filter</label> <input type="text" name="filter" value="" id="filter" /> 
<br /><br />

<table cellpadding="1" cellspacing="1" id="resultTable" border="1">
    <thead>
        <tr bgcolor="#cccccc" style="margin-bottom:10px;">
            <th>Student Num</th>
            <th>Amount Paid</th>
            <th>Code (click to view order)</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        <?php
            // Use mysqli_query to fetch data
            $result3 = mysqli_query($bd, "SELECT * FROM wings_orders");

            if ($result3) {
                // Fetch data row by row
                while ($row3 = mysqli_fetch_assoc($result3)) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($row3['cusid']) . '</td>';
                    echo '<td>M' . htmlspecialchars($row3['total']) . '.00</td>';
                    echo '<td><a rel="facebox" href="listorder.php?id=' . htmlspecialchars($row3["transactioncode"]) . '">' . htmlspecialchars($row3['transactioncode']) . '</a></td>';
                    echo '<td>' . htmlspecialchars($row3['transactiondate']) . '</td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="4">No orders found.</td></tr>';
            }

            // Free result set
            mysqli_free_result($result3);
            
            // Close connection
            mysqli_close($bd);
        ?>
    </tbody>
</table>
  
</div>
</body>
</html>
