<?php  
error_reporting(0);
session_start();
include('connect.php');
include('AutoID_Functions.php');
include('Purchase_Order_Functions.php');

if(isset($_POST['btnSave'])) 
{
	$txtPOID=$_POST['txtPOID'];
	$txtPODate=$_POST['txtPODate'];
	$txtTotalAmount=$_POST['txtTotalAmount'];
	$txtTotalQuantity=$_POST['txtTotalQuantity'];
	$txtVAT=$_POST['txtVAT'];
	$txtGrandTotal=$_POST['txtGrandTotal'];
	$cboSupplierID=$_POST['cboSupplierID'];

	$StaffID=$_SESSION['StaffID'];
	$Status="Pending";

	$Insert1="INSERT INTO `purchaseorder`
			  (`PurchaseOrderID`, `PurchaseOrderDate`, `TotalAmount`, `TotalQuantity`, `TaxAmount`, `GrandTotal`, `SupplierID`, `StaffID`, `Status`) 
			  VALUES
			  ('$txtPOID','$txtPODate','$txtTotalAmount','$txtTotalQuantity','$txtVAT','$txtGrandTotal','$cboSupplierID','$StaffID','$Status')
			  ";
	$result=mysqli_query($connection,$Insert1);

	$count=count($_SESSION['Purchase_Functions']);

	for ($i=0; $i < $count; $i++) 
	{ 
		$ProductID=$_SESSION['Purchase_Functions'][$i]['ProductID'];
		$PurchasePrice=$_SESSION['Purchase_Functions'][$i]['PurchasePrice'];
		$PurchaseQuantity=$_SESSION['Purchase_Functions'][$i]['PurchaseQuantity'];

		$Insert2="INSERT INTO `purchaseorderdetail`
				  (`PurchaseOrderID`, `ProductID`, `PurchaseQuantity`, `PurchasePrice`) 
				  VALUES
				  ('$txtPOID','$ProductID','$PurchasePrice','$PurchaseQuantity')
				  ";
		$result=mysqli_query($connection,$Insert2);
	}

	if($result) 
	{
		unset($_SESSION['Purchase_Functions']);

		echo "<script>window.alert('Purhase Order Successfully Saved!')</script>";
		echo "<script>window.location='Staff_Dashboard.php'</script>";
	}
	else
	{
		echo "<p>Something went wrong in Purchase Order : " . mysqli_error($connection) . "</p>";
	}
}


if(isset($_POST['btnAdd'])) 
{
	$ProductID=$_POST['cboProductID'];
	$PurchasePrice=$_POST['txtPurchasePrice'];
	$PurchaseQuantity=$_POST['txtPurchaseQuantity'];

	AddProduct($ProductID,$PurchasePrice,$PurchaseQuantity);
}
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
	<title>Purchase Order</title>
</head>
<body>
<form action="Purchase_Order.php" method="post">
<fieldset>
<legend>Purchase Order Form :</legend>
<table cellpadding="3px">
<tr>
	<td>PO Date</td>
	<td>
		<input type="text" name="txtPODate" value="<?php echo date('Y-m-d') ?>" readonly />
	</td>
	<td>Total Amount</td>
	<td>
		<input type="text" name="txtTotalAmount" value="<?php echo CalculateTotalAmount(); ?>" readonly /> USD
	</td>
</tr>
<tr>
	<td>PO ID</td>
	<td>
		<input type="text" name="txtPOID" value="<?php echo AutoID('purchaseorder','PurchaseOrderID','PU-',6) ?>" readonly />
	</td>
	<td>Total Quantity</td>
	<td>
		<input type="text" name="txtTotalQuantity" value="<?php echo CalculateTotalQuantity() ?>" readonly /> pcs
	</td>
</tr>
<tr>
	<td>Staff Info</td>
	<td>
		<input type="text" name="txtStaffInfo" value="<?php echo $_SESSION['StaffName'] ?>" readonly />
	</td>
	<td>VAT (5%)</td>
	<td>
		<input type="text" name="txtVAT" value="<?php echo CalculateTotalAmount()*0.05 ?>" readonly /> USD
	</td>
</tr>
<tr>
	<td>Product Info</td>
	<td>
		<select name="cboProductID">
		<option>--Choose ProductID--</option>
		<?php  
		$ProductData="SELECT * FROM product";
		$result=mysqli_query($connection,$ProductData);
		$count=mysqli_num_rows($result);

		for($i=0;$i<$count;$i++) 
		{ 
			$row=mysqli_fetch_array($result);
			$ProductID=$row['ProductID'];
			$ProductName=$row['ProductName'];

			echo "<option value='$ProductID'>$ProductID - $ProductName</option>";
		}
		?>
		</select>
	</td>
	<td>GrandTotal</td>
	<td>
		<input type="text" name="txtGrandTotal" value="<?php echo CalculateTotalAmount() + (CalculateTotalAmount()*0.05) ?>" readonly /> USD
	</td>
</tr>
<tr>
	<td>Purchase Price</td>
	<td>
		<input type="number" name="txtPurchasePrice" value="0"  />
	</td>
</tr>
<tr>
	<td>Purchase Quantity</td>
	<td>
		<input type="number" name="txtPurchaseQuantity" value="0"  />
	</td>
</tr>
<tr>
	<td></td>
	<td>
		<input type="submit" name="btnAdd" value="Add" />
		<input type="reset" name="btnClear" value="Clear" />
	</td>
</tr>
</table>

<hr/>

<?php  
if (!isset($_SESSION['Purchase_Functions'])) 
{
	echo "<p>No Purchase Record Found.</p>";
}
else
{
?>
	<table border="1" cellpadding="3px">
	<tr>
		<th>Image</th>
		<th>ProductID</th>
		<th>ProductName</th>
		<th>PurchasePrice</th>
		<th>PurchaseQuantity</th>
		<th>GrandTotal</th>
		<th>Action</th>
	</tr>
	<?php
	$count=count($_SESSION['Purchase_Functions']);

	for($i=0;$i<$count;$i++) 
	{ 
		$ProductID=$_SESSION['Purchase_Functions'][$i]['ProductID'];
		$ProductImage1=$_SESSION['Purchase_Functions'][$i]['ProductImage1'];
		echo "<tr>";
			echo "<td>
				  <img src='$ProductImage1' width='100px' height='100px' />
				 </td>";
			echo "<td>" . $_SESSION['Purchase_Functions'][$i]['ProductID'] . "</td>";
			echo "<td>" . $_SESSION['Purchase_Functions'][$i]['ProductName'] . "</td>";
			echo "<td>" . $_SESSION['Purchase_Functions'][$i]['PurchasePrice'] . "</td>";
			echo "<td>" . $_SESSION['Purchase_Functions'][$i]['PurchaseQuantity'] . "</td>";
			echo "<td>" . $_SESSION['Purchase_Functions'][$i]['PurchasePrice']  * $_SESSION['Purchase_Functions'][$i]['PurchaseQuantity'] . "</td>";
			echo "<td>
					<a href='Purchase_Order.php?action=Remove&ProductID=$ProductID'>Remove</a>
				  </td>";
		echo "</tr>";			
	}
	?>
	<tr>
		<td colspan="7">
		Choose Supplier : 
		<select name="cboSupplierID">
		<option>--Choose SupplierID--</option>
		<?php  
		$SData="SELECT * FROM supplier";
		$Sresult=mysqli_query($connection,$SData);
		$Scount=mysqli_num_rows($Sresult);

		for($i=0;$i<$Scount;$i++) 
		{ 
			$Srow=mysqli_fetch_array($Sresult);
			$SupplierID=$Srow['SupplierID'];
			$SupplierName=$Srow['SupplierName'];

			echo "<option value='$SupplierID'>$SupplierID - $SupplierName</option>";
		}
		?>
		</select>
		|
		<a href="Purchase_Order.php?action=ClearAll">Clear All</a>
		|
		<input type="submit" name="btnSave" value="Save" />
		</td>
	</tr>
	</table>
<?php
}
?>

</fieldset>
</form>
</body>
</html>