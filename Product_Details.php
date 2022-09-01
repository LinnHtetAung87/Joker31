<?php  
session_start();
include('connect.php');
include('Shopping_Cart_Functions.php');

if(isset($_GET['ProductID'])) 
{
	$ProductID=$_GET['ProductID'];

	$query="SELECT p.*,b.BrandID,b.BrandName,c.CategoryID,c.CategoryName 
			FROM product p,Category c,Brand b 
			WHERE p.ProductID='$ProductID' 
			AND p.BrandID=b.BrandID
			AND p.CategoryID=c.CategoryID
			";
	$result=mysqli_query($connection,$query);
	$row=mysqli_fetch_array($result);

	$ProductImage1=$row['ProductImage1'];
	list($width,$height)=getimagesize($ProductImage1);
	$w=$width/2;
	$h=$height/2;
}

if(isset($_POST['btnAdd2Cart'])) 
{
	$ProductID=$_POST['txtProductID'];
	$BuyQuantity=$_POST['txtBuyQuantity'];

	AddProduct($ProductID,$BuyQuantity);
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Product Details :</title>
</head>
<body>
<form action="Product_Details.php" method="post">
<fieldset>
<legend>Product Details for <?php echo $row['ProductName'] ?></legend>
<table>
<tr>
	<td>
		<img id="PImage" src="<?php echo $ProductImage1 ?>" width="<?php echo $w ?>" height="<?php echo $h ?>">
		<hr/>
		<img src="<?php echo $row['ProductImage1'] ?>" width="100" height="100" 
		onClick="document.getElementById('PImage').src='<?php echo $row['ProductImage1'] ?>' " />
		<img src="<?php echo $row['ProductImage2'] ?>" width="100" height="100" 
		onClick="document.getElementById('PImage').src='<?php echo $row['ProductImage2'] ?>' "/>
		<img src="<?php echo $row['ProductImage3'] ?>" width="100" height="100" 
		onClick="document.getElementById('PImage').src='<?php echo $row['ProductImage3'] ?>' "/>
	</td>
	<td>
		<table>
		<tr>
			<td>ProductName :</td>
			<td>
				<b><?php echo $row['ProductName'] ?></b>
			</td>
		</tr>
		<tr>
			<td>Brand :</td>
			<td>
				<b><?php echo $row['BrandName'] ?></b>
			</td>
		</tr>
		<tr>
			<td>Category :</td>
			<td>
				<b><?php echo $row['CategoryName'] ?></b>
			</td>
		</tr>
		<tr>
			<td>Type :</td>
			<td>
				<b><?php echo $row['Type'] ?></b>
			</td>
		</tr>
		<tr>
			<td>BottleType :</td>
			<td>
				<b><?php echo $row['BottleType'] ?></b>
			</td>
		</tr>
		<tr>
			<td>Capacity :</td>
			<td>
				<b><?php echo $row['Capacity'] ?> ml</b>
			</td>
		</tr>
		<tr>
			<td>Price :</td>
			<td>
				<b><?php echo $row['Price'] ?> USD</b>
			</td>
		</tr>
		<tr>
			<td>Buy Quantity :</td>
			<td>
				<input type="hidden" name="txtProductID" value="<?php echo $row['ProductID'] ?>">
				<input type="number" name="txtBuyQuantity" value="1" />
				<input type="submit" name="btnAdd2Cart" value="Add to Cart" />
			</td>
		</tr>
		</table>
	</td>
</tr>
<tr>
	<td colspan="2">
	Description :
	<hr/>
	<?php echo $row['Description'] ?>
	</td>
</tr>
</table>
</fieldset>
</form>
</body>
</html>