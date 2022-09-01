<?php  
session_start();
include('connect.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Staff_Dashboard</title>
</head>
<body>
<form>
	<h2>Welcome <?php echo $_SESSION['StaffName'] . ' | ' . $_SESSION['RoleName']  ?></h2>

	<a href="Purchase_Order.php">Manage Purchase</a>
</form>
</body>
</html>