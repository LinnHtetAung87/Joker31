<?php  
session_start();
include('connect.php');
include('AutoID_Functions.php');
include('Shopping_Cart_Functions.php');

$_SESSION['CustomerID']='1';
$_SESSION['Phone']='0959938988';
$_SESSION['CustomerName']='Alex John';
$_SESSION['Address']='No 331, Pyay Road, Yangon';
$_SESSION['Phone']='0959938988';

if(isset($_POST['btnCheckout'])) 
{
	$txtOrderID=$_POST['txtOrderID'];
	$txtOrderDate=$_POST['txtOrderDate'];
	$CustomerID=$_SESSION['CustomerID'];
	$rdoDeliveryType=$_POST['rdoDeliveryType'];
	$rdoPaymentType=$_POST['rdoPaymentType'];
	$txtDirection=$_POST['txtDirection'];
	$txtCardNo=$_POST['txtCardNo'];
	$Status="Pending";
	$DeliveryStatus="Pending";


	$TotalAmount=CalculateTotalAmount();
	$TotalQuantity=CalculateTotalQuantity();
	$VAT=CalculateTotalAmount() * 0.05;
	$GrandTotal=CalculateTotalAmount() + (CalculateTotalAmount() * 0.05);

	if ($rdoDeliveryType == "SameAddress") 
	{
		$CustomerName=$_SESSION['CustomerName'];
		$Phone=$_SESSION['Phone'];
		$Address=$_SESSION['Address'];
	}
	else
	{
		$CustomerName=$_POST['txtCustomerName'];
		$Phone=$_POST['txtPhone'];
		$Address=$_POST['txtAddress'];
	}


	//Insert Order Data (Single)---------------------------------------------------------------
	$InsertOrder="INSERT INTO `orders`
				  (`OrderID`, `OrderDate`, `CustomerID`, `DeliveryType`, `PaymentType`, `CustomerName`, `Phone`, `Address`, `Direction`, `CardNo`, `TotalQuantity`, `TotalAmount`, `VAT`, `GrandTotal`, `Status`, `DeliveryStatus`) 
				  VALUES
				  ('$txtOrderID','txtOrderDate','$CustomerID','$rdoDeliveryType','$rdoPaymentType','$CustomerName','$Phone','$Address','$txtDirection','$txtCardNo','$TotalQuantity','$TotalAmount','$VAT','$GrandTotal','$Status','$DeliveryStatus')
				  ";
	$result=mysqli_query($connection,$InsertOrder);

	//Insert Order Details (Repeat)------------------------------------------------------------
	$count=count($_SESSION['Shopping_Cart_Functions']);

	for ($i=0; $i < $count; $i++) 
	{ 
		$ProductID=$_SESSION['Shopping_Cart_Functions'][$i]['ProductID'];
		$Price=$_SESSION['Shopping_Cart_Functions'][$i]['Price'];
		$BuyQuantity=$_SESSION['Shopping_Cart_Functions'][$i]['BuyQuantity'];

		$InsertOD="INSERT INTO `orderdetails`
				 (`OrderID`, `ProductID`, `Price`, `Quantity`) 
				 VALUES
				 ('$txtOrderID','$ProductID','$Price','$BuyQuantity')
				  ";
		$result=mysqli_query($connection,$InsertOD);
	}
	//-------------------------------------------------------------------------------------------

	if($result) 
	{
		unset($_SESSION['Shopping_Cart_Functions']);

		echo "<script>window.alert('Successfully Completed Checkout Process!')</script>";
		echo "<script>window.location='Product_Display.php'</script>";
	}
	else
	{
		echo "<p>Something went wrong in Checkout : " . mysqli_error($connection) . "</p>";
	}
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Checkout</title>

<script type="text/javascript">
function SameAddress()
{
	document.getElementById('SameAddress').style.display="block";
	document.getElementById('OtherAddress').style.display="none";
}
function OtherAddress()
{
	document.getElementById('SameAddress').style.display="none";
	document.getElementById('OtherAddress').style.display="block";
}
function COD()
{
	document.getElementById('CardPayment').style.display="none";
	document.getElementById('Kpay').style.display="none";
}
function Card()
{
	document.getElementById('CardPayment').style.display="block";
	document.getElementById('Kpay').style.display="none";
}
function Kpay()
{
	document.getElementById('CardPayment').style.display="none";
	document.getElementById('Kpay').style.display="block";
}
</script>

</head>
<body>
<form action="Checkout.php" method="post">
<fieldset>
<legend>Checkout Page :</legend>
<table cellpadding="5px">
<tr>
	<td>OrderID :</td>
	<td>
		<input type="text" name="txtOrderID" value="<?php echo AutoID('orders','OrderID','ORD-',6) ?>">
	</td>
	<td>Total Amount :</td>
	<td>
		<b><?php echo CalculateTotalAmount() ?> USD</b>
	</td>
	<td>VAT (5%)</td>
	<td>
		<b><?php echo CalculateTotalAmount() * 0.05 ?> USD</b>
	</td>
</tr>
<tr>
	<td>OrderDate :</td>
	<td>
		<input type="text" name="txtOrderDate" value="<?php echo date('Y-m-d') ?>">
	</td>
	<td>Total Quantity :</td>
	<td>
		<b><?php echo CalculateTotalQuantity() ?> pcs</b>
	</td>
	<td>Grand Total</td>
	<td>
		<b><?php echo CalculateTotalAmount() + (CalculateTotalAmount() * 0.05) ?> USD</b>
	</td>
</tr>
</table>
<hr/>
<p><b><u>Delivery Details :</u></b></p>
<input type="radio" name="rdoDeliveryType" value="SameAddress" onClick="SameAddress()" checked />Same Address
<input type="radio" name="rdoDeliveryType" value="OtherAddress" onClick="OtherAddress()" />Other Address

<div id="SameAddress" style="display: block;">
<table>
	<tr>
		<td>Customer Name :</td>
		<td>
			<b><?php echo $_SESSION['CustomerName'] ?></b>
		</td>
	</tr>
	<tr>
		<td>Address :</td>
		<td>
			<b><?php echo $_SESSION['Address'] ?></b>
		</td>
	</tr>
	<tr>
		<td>Phone :</td>
		<td>
			<b><?php echo $_SESSION['Phone'] ?></b>
		</td>
	</tr>
</table>
</div>

<div id="OtherAddress" style="display: none;">
<table>
	<tr>
		<td>Customer Name :</td>
		<td>
			<input type="text" name="txtCustomerName" placeholder="Eg. Alan" />
		</td>
	</tr>
	<tr>
		<td>Phone :</td>
		<td>
			<input type="text" name="txtPhone" placeholder="+95-----------" />
		</td>
	</tr>
	<tr>
		<td>Address :</td>
		<td>
			<textarea name="txtAddress" cols="30" placeholder="Room No / Street Name / etc."></textarea>
		</td>
	</tr>
</table>
</div>

<table>
<tr>
	<td>Direction : &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</td>
	<td>
		<textarea name="txtDirection" cols="50" rows="2" placeholder="Eg. Bus-Stop etc..."></textarea>
	</td>
</tr>	
</table>

<hr/>
<p><b><u>Payment Details :</u></b></p>
<input type="radio" name="rdoPaymentType" value="COD" checked onClick="COD()" />Cash on Delivery
<input type="radio" name="rdoPaymentType" value="Card" onClick="Card()" />Card Payment
<input type="radio" name="rdoPaymentType" value="KPay" onClick="Kpay()" />Kpay

<div id="CardPayment" style="display: none">
<table>
<tr>
	<td>
		<input type="text" name="txtCardNo" placeholder="Enter Card Number" /> |
		<input type="text" name="txtSecurityNo" placeholder="Security Code" size="9" /> 
	</td>
</tr>
<tr>
	<td>
		<input type="text" name="txtMonth" placeholder="JAN" size="5" />
		<input type="text" name="txtYear" placeholder="2021" size="5" />
	</td>
</tr>
</table>
</div>

<div id="Kpay" style="display: none">
<p><b>KBZ Pay No : 29282938293829</b></p>
<img src="images/kpay.png" width="100px" height="100px" />
</div>

<hr/>
<input type="submit" name="btnCheckout" value="Checkout" />
<input type="reset" name="btnClear" value="Clear" />
<hr/>

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
		echo "</tr>";			
	}
	?>
	</table>
<?php
}
?>

</fieldset>
</form>
</body>
</html>