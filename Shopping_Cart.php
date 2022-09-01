<?php  
session_start();
include('connect.php');
include('Shopping_Cart_Functions.php');

if(isset($_GET['action'])) 
{
	$action=$_GET['action'];

	if ($action == 'Remove') 
	{
		$ProductID=$_GET['ProductID'];
		RemoveProduct($ProductID);
	}
	elseif ($action == 'ClearAll') 
	{
		ClearAll();
	}
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Shopping Cart</title>
</head>
<body>
<form action="Shopping_Cart.php" method="post">
<?php  
if (!isset($_SESSION['Shopping_Cart_Functions'])) 
{
	echo "<p>Empty Cart</p>";
	echo "<a href='Product_Display.php'>Back to Product List</a>";
}
else
{
?>
	<table border="1" cellpadding="3px" width="100%">
	<tr>
		<th>Image</th>
		<th>ProductID</th>
		<th>ProductName</th>
		<th>Price</th>
		<th>BuyQuantity</th>
		<th>GrandTotal</th>
		<th>Action</th>
	</tr>
	<?php
	$count=count($_SESSION['Shopping_Cart_Functions']);

	for($i=0;$i<$count;$i++) 
	{ 
		$ProductID=$_SESSION['Shopping_Cart_Functions'][$i]['ProductID'];
		$ProductImage1=$_SESSION['Shopping_Cart_Functions'][$i]['ProductImage1'];
		echo "<tr>";
			echo "<td>
				  <img src='$ProductImage1' width='100px' height='100px' />
				 </td>";
			echo "<td>" . $_SESSION['Shopping_Cart_Functions'][$i]['ProductID'] . "</td>";
			echo "<td>" . $_SESSION['Shopping_Cart_Functions'][$i]['ProductName'] . "</td>";
			echo "<td>" . $_SESSION['Shopping_Cart_Functions'][$i]['Price'] . "</td>";
			echo "<td>" . $_SESSION['Shopping_Cart_Functions'][$i]['BuyQuantity'] . "</td>";
			echo "<td>" . $_SESSION['Shopping_Cart_Functions'][$i]['Price']  * $_SESSION['Shopping_Cart_Functions'][$i]['BuyQuantity'] . "</td>";
			echo "<td>
					<a href='Shopping_Cart.php?action=Remove&ProductID=$ProductID'>Remove</a>
				  </td>";
		echo "</tr>";			
	}
	?>
	<tr>
		<td colspan="7" align="right">
		Total Quantity : <b><?php echo CalculateTotalQuantity() ?> pcs</b>
		<hr/>
		Total Amount : <b><?php echo CalculateTotalAmount() ?> USD</b>
		<hr/>
		VAT (5%) : <b><?php echo CalculateTotalAmount() * 0.05 ?> USD</b>
		<hr/>
		GrandTotal : <b><?php echo CalculateTotalAmount() + (CalculateTotalAmount() * 0.05) ?> USD</b>
		<hr/>
		|
		<a href='Product_Display.php'>Back to Product List</a>
		|
		<a href="Shopping_Cart.php?action=ClearAll">Empty Cart</a>
		|
		<a href="Checkout.php">Make Checkout</a>	
		</td>
	</tr>
	</table>
<?php
}
?>

</form>
</body>
</html>