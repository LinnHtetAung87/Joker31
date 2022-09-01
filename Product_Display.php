<?php  
session_start();
include('connect.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Product Display</title>
</head>
<body>
<form action="Product_Display.php" method="post">
<fieldset>
<legend>Product List :</legend>
<table width="100%">
<tr>
	<td align="right">
		<input type="text" name="txtData" placeholder="Enter Search Data" />
		<input type="submit" name="btnSearch" value="Search" />
	</td>
</tr>
</table>
<hr/>
<table>
<?php 

if(isset($_POST['btnSearch'])) 
{
	$txtData=$_POST['txtData'];

	$query1="SELECT * FROM product WHERE ProductName LIKE '%$txtData%' OR Price='$txtData' ";
	$result1=mysqli_query($connection,$query1);
	$count1=mysqli_num_rows($result1);

	for($i=0;$i<$count1;$i+=4) 
	{ 
		$query2="SELECT * FROM product
				 WHERE ProductName LIKE '%$txtData%' 
				 OR Price='$txtData'
				 LIMIT $i,4";
		$result2=mysqli_query($connection,$query2);
		$count2=mysqli_num_rows($result2);

		echo "<tr>";
		for($x=0;$x<$count2;$x++) 
		{ 
			$row=mysqli_fetch_array($result1);

			$ProductID=$row['ProductID'];
			$ProductName=$row['ProductName'];
			$Price=$row['Price'];
			$ProductImage1=$row['ProductImage1'];

			list($width,$height)=getimagesize($ProductImage1);
			$w=$width/2;
			$h=$height/2;
		?>
			<td>
				<img src="<?php echo $ProductImage1 ?>" width="<?php echo $w ?>" height="<?php echo $h ?>">
				<hr/>
				<b><p><?php echo $ProductName ?></p></b>
				<b><p><?php echo $Price ?> USD</p></b>
				<hr/>
				<a href="Product_Details.php?ProductID=<?php echo $ProductID ?>">Details</a>
			</td>
		<?php
		}
		echo "</tr>";
	}
}
else
{
	$query1="SELECT * FROM product";
	$result1=mysqli_query($connection,$query1);
	$count1=mysqli_num_rows($result1);

	for($i=0;$i<$count1;$i+=4) 
	{ 
		$query2="SELECT * FROM product
				 LIMIT $i,4";
		$result2=mysqli_query($connection,$query2);
		$count2=mysqli_num_rows($result2);

		echo "<tr>";
		for($x=0;$x<$count2;$x++) 
		{ 
			$row=mysqli_fetch_array($result1);

			$ProductID=$row['ProductID'];
			$ProductName=$row['ProductName'];
			$Price=$row['Price'];
			$ProductImage1=$row['ProductImage1'];

			list($width,$height)=getimagesize($ProductImage1);
			$w=$width/2;
			$h=$height/2;
		?>
			<td>
				<img src="<?php echo $ProductImage1 ?>" width="<?php echo $w ?>" height="<?php echo $h ?>">
				<hr/>
				<b><p><?php echo $ProductName ?></p></b>
				<b><p><?php echo $Price ?> USD</p></b>
				<hr/>
				<a href="Product_Details.php?ProductID=<?php echo $ProductID ?>">Details</a>
			</td>
		<?php
		}
		echo "</tr>";
	}
}


?>
</table>
</fieldset>
</form>
</body>
</html>




