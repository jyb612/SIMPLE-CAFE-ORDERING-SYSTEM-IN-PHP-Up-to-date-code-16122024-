<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Kopitiamtech Welcome</title>
<meta name="keywords" />
<meta name="description" />
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="src/facebox.css" media="screen" rel="stylesheet" type="text/css" />
<script src="lib/jquery.js" type="text/javascript"></script>
<script src="src/facebox.js" type="text/javascript"></script>
<script type="text/javascript">
    jQuery(document).ready(function($) {
        $('a[rel*=facebox]').facebox({
            loadingImage : 'src/loading.gif',
            closeImage   : 'src/closelabel.png'
        })
    })
</script>
</head>
<body>
<div id="container">
    <div id="header_section"> 
        <p>&nbsp;</p>
        <p>&nbsp;</p>
    </div>
    <div id="menu_bg">
        <div id="menu">
            <?php
                include ('get-parameters.php'); // Include your parameters file
            ?>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="aboutus.php" class="current">About Us</a></li>
                <li><a href="contact.php">Contact Us</a></li>
                <li><a href="loginindex.php">Order Now!</a></li>
                <li><a href="admin_index.php">Admin</a></li>
            </ul>
        </div>
    </div>
    <div id="header"></div>
    <div id="content">
        <div id="content_left"> 
            <img src="images/bgr.JPG" width="734" height="300" style="margin-left:-10px;" />
        </div>
    </div>
    <div id="container_end"></div>
</div>
<div id="footer">
    <div class="top"></div>
    <div id="card">
        <h3>Server Information</h3>
        <p>Availability Zone: <?php echo htmlspecialchars($az); ?></p> <!-- Display availability zone -->
        <p>Region: <?php echo htmlspecialchars($region); ?></p> <!-- Display region -->
    </div>
    <div class="middle">
        Copyright © Nana Cafe 2024
    </div>
    <div class="button"></div>
</div>
<div>
</div>
</body>
</html>
