<?php
session_start();
include("php/functions.php");
$username=checkUser($_SESSION['userid'],session_id(),3);
?>
<!doctype html>
<html lang="en-gb" dir="ltr">
<head>

</head>
<body>
<nav>
	<ul> 
		<li><a href="index.html">Home</a></li>
		<li><a href="user.php">Menu</a></li>
		<li><a href="php/logout.php">Logout</a></li>
	</ul>
</nav>
<h1>Welcome to the Admin  Menu <?php echo $username; ?></h1>
<p><a href="php/logout.php">Logout</a></p>
</body>
</html>
