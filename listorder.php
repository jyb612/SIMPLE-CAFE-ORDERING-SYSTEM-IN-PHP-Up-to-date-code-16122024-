<style type="text/css">
<!--
.style1 {color: #FFFFFF}
-->
</style>
<table width="249" border="1" cellpadding="0" cellspacing="0">
    <tr>
        <td width="189"><div align="left">&nbsp;&nbsp;&nbsp;&nbsp;Products</div></td>
        <td width="65">Price</td>
        <td width="50">Qty</td>
    </tr>

<?php
    if (isset($_GET['id'])) {
        include('connection.php');
        
        $id = mysqli_real_escape_string($bd, $_GET['id']); // Sanitize input
        
        // Use a prepared statement
        $stmt = mysqli_prepare($bd, "SELECT * FROM orderditems WHERE transactioncode = ?");
        mysqli_stmt_bind_param($stmt, 's', $id);
        mysqli_stmt_execute($stmt);
        $result3 = mysqli_stmt_get_result($stmt);
        
        // Fetch and display each item
        while ($row3 = mysqli_fetch_assoc($result3)) {
            echo '<tr>';
            echo '<td><div align="left">&nbsp;&nbsp;&nbsp;&nbsp;' . htmlspecialchars($row3['name']) . '</div></td>';
            echo '<td>' . 'M' . htmlspecialchars($row3['price']) . '.00' . '</td>';
            echo '<td>' . htmlspecialchars($row3['quantity']) . '</td>';
            echo '</tr>';
        }
        
        // Close the statement
        mysqli_stmt_close($stmt);
    }
?>
</table><br>

<?php
    if (isset($_GET['id'])) {
        include('connection.php');
        
        $id = mysqli_real_escape_string($bd, $_GET['id']);
        
        // Get the customer ID from orderditems
        $stmt = mysqli_prepare($bd, "SELECT customer FROM orderditems WHERE transactioncode = ?");
        mysqli_stmt_bind_param($stmt, 's', $id);
        mysqli_stmt_execute($stmt);
        $result3 = mysqli_stmt_get_result($stmt);
        $row3 = mysqli_fetch_assoc($result3);
        
        if ($row3) {
            $var = $row3['customer'];
            
            // Get member details
            $stmt2 = mysqli_prepare($bd, "SELECT * FROM members WHERE id = ?");
            mysqli_stmt_bind_param($stmt2, 's', $var);
            mysqli_stmt_execute($stmt2);
            $result4 = mysqli_stmt_get_result($stmt2);
            $row4 = mysqli_fetch_assoc($result4);
            
            // Close the second statement
            mysqli_stmt_close($stmt2);
        }
        
        // Close the first statement
        mysqli_stmt_close($stmt);
    }
?>
<br />
