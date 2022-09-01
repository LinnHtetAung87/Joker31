<?php  
session_start();
include('connect.php');
include('AutoID_Functions.php');
include('Purchase_Order_Functions.php');

if(isset($_POST['btnConfirm'])) 
{
	$txtPOID=$_POST['txtPOID'];

	$result=mysqli_query($connection,"SELECT * FROM purchaseorderdetail WHERE PurchaseOrderID='$txtPOID' ");

	while($arr=mysqli_fetch_array($result)) 
	{
		$ProductID=$arr['ProductID'];
		$PurchaseQuantity=$arr['PurchaseQuantity'];

		$UpdateQty="UPDATE product
					SET 
					Quantity=Quantity + '$PurchaseQuantity'
					WHERE ProductID='$ProductID'
					";
		$ret=mysqli_query($connection,$UpdateQty);			# code...
	}

	$UpdateStatus="UPDATE purchaseorder
				  SET
				  Status='Confirmed'
				  WHERE PurchaseOrderID='$txtPOID'
				  ";
	$ret=mysqli_query($connection,$UpdateStatus);

	if($ret) 
	{
		echo "<script>window.alert('Successfully Confirmed Purchase Order!')</script>";
		echo "<script>window.location='Staff_Dashboard.php'</script>";
	}
	else
	{
		echo "<p>Something went wrong in Purchase Order Confirmed: " . mysqli_error($connection) . "</p>";
	}
}

if(isset($_GET['PurchaseOrderID'])) 
{
	//Single
	$PurchaseOrderID=$_GET['PurchaseOrderID'];

	$Query1="SELECT po.*,sup.SupplierID,sup.SupplierName,st.StaffID,st.StaffName
			FROM purchaseorder po,staff st, supplier sup
			WHERE po.PurchaseOrderID='$PurchaseOrderID'
			AND po.StaffID=st.StaffID
			AND po.SupplierID=sup.SupplierID 
			";
	$result1=mysqli_query($connection,$Query1);
	$row1=mysqli_fetch_array($result1);

	//Repeat
	$Query2="SELECT po.*,pod.*,p.ProductID,p.ProductName
			FROM purchaseorder po,purchaseorderdetail pod, product p
			WHERE po.PurchaseOrderID=pod.PurchaseOrderID
			AND pod.PurchaseOrderID='$PurchaseOrderID'
			AND pod.ProductID=p.ProductID ";
	$result2=mysqli_query($connection,$Query2);
	$count=mysqli_num_rows($result2);
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Purchase_Details</title>
</head>
<body>
<form action="Purchase_Details.php" method="post">
<fieldset>
<legend>Purchase Order Details :</legend>
<table align="center" border="1" cellpadding="5px">
<tr>
	<td>PurchaseOrderID</td>
	<td>
		<b><?php echo $row1['PurchaseOrderID'] ?></b>
	</td>
	<td>Status</td>
	<td>
		<b><?php echo $row1['Status'] ?></b>
	</td>
</tr>
<tr>
	<td>PO Date</td>
	<td>
		<b><?php echo $row1['PurchaseOrderDate'] ?></b>
	</td>
	<td>Report Date</td>
	<td>
		<b><?php echo date('Y-m-d') ?></b>
	</td>
</tr>
<tr>
	<td>SupplierInfo</td>
	<td>
		<b><?php echo $row1['SupplierName'] ?></b>
	</td>
	<td>StaffInfo</td>
	<td>
		<b><?php echo $row1['StaffName'] ?></b>
	</td>
</tr>
<tr>
	<td colspan="4">
	<table cellpadding="5px" border="1" width="100%">
	<tr>
		<th>ProductID</th>
		<th>ProductName</th>
		<th>PurchasePrice</th>
		<th>PurchaseQuantity</th>
		<th>Sub-Total</th>
	</tr>
	<?php
	for($i=0;$i<$count;$i++) 
	{ 
		$row=mysqli_fetch_array($result2);

		echo "<tr>";
			echo "<td>" . $row['ProductID'] . "</td>";
			echo "<td>" . $row['ProductName'] . "</td>";
			echo "<td>" . $row['PurchasePrice'] . " USD</td>";
			echo "<td>" . $row['PurchaseQuantity'] . " pcs</td>";
			echo "<td>" . $row['PurchaseQuantity'] * $row['PurchasePrice']  . " USD</td>";
		echo "</tr>";			
	}
	?>
	</table>
	</td>
</tr>
<tr>
	<td colspan="4" align="right">
	TotalAmount : <b><?php echo $row1['TotalAmount'] ?> USD</b>
	<hr/>
	TotalQuantity : <b><?php echo $row1['TotalQuantity'] ?> pcs</b>
	<hr/>
	VAT (5%) : <b><?php echo $row1['TaxAmount'] ?> USD</b>
	<hr/>
	GrandTotal : <b><?php echo $row1['GrandTotal'] ?> USD</b>
	<hr/>
	<input type="hidden" name="txtPOID" value="<?php echo $row1['PurchaseOrderID'] ?>" />
	<input type="submit" name="btnConfirm" value="Confirm PO" />
	</td>
</tr>
</table>
</fieldset>
</form>
</body>
</html>