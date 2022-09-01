<?php  
error_reporting(0);
session_start();
include('connect.php');
include('AutoID_Functions.php');
include('Purchase_Order_Functions.php');

if (isset($_POST['btnSearch'])) 
{
	$rdoSearchType=$_POST['rdoSearchType'];

	if ($rdoSearchType == 1) 
	{
		$cboPOID=$_POST['cboPOID'];

		$Query="SELECT po.*,sup.SupplierID,sup.SupplierName,st.StaffID,st.StaffName
				FROM purchaseorder po,staff st, supplier sup
				WHERE po.PurchaseOrderID='$cboPOID'
				AND po.StaffID=st.StaffID
				AND po.SupplierID=sup.SupplierID 
				";
		$result=mysqli_query($connection,$Query);
	}
	elseif($rdoSearchType == 2)
	{
		$From=date('Y-m-d',strtotime($_POST['txtFrom']));
		$To=date('Y-m-d',strtotime($_POST['txtTo']));

		$Query="SELECT po.*,sup.SupplierID,sup.SupplierName,st.StaffID,st.StaffName
				FROM purchaseorder po,staff st, supplier sup
				WHERE po.PurchaseOrderDate BETWEEN '$From' AND '$To'
				AND po.StaffID=st.StaffID
				AND po.SupplierID=sup.SupplierID 
				";
		$result=mysqli_query($connection,$Query);
	}
	elseif ($rdoSearchType == 3) 
	{
		$cboStatus=$_POST['cboStatus'];

		$Query="SELECT po.*,sup.SupplierID,sup.SupplierName,st.StaffID,st.StaffName
				FROM purchaseorder po,staff st, supplier sup
				WHERE po.Status='$cboStatus'
				AND po.StaffID=st.StaffID
				AND po.SupplierID=sup.SupplierID 
				";
		$result=mysqli_query($connection,$Query);
	}	
}
elseif(isset($_POST['btnShowAll']))
{
	$Query="SELECT po.*,sup.SupplierID,sup.SupplierName,st.StaffID,st.StaffName
			FROM purchaseorder po,staff st, supplier sup
			WHERE po.StaffID=st.StaffID
			AND po.SupplierID=sup.SupplierID 
			";
	$result=mysqli_query($connection,$Query);
}
else
{
	$today=date('Y-m-d');

	$Query="SELECT po.*,sup.SupplierID,sup.SupplierName,st.StaffID,st.StaffName
			FROM purchaseorder po,staff st, supplier sup
			WHERE po.PurchaseOrderDate='$today'
			AND po.StaffID=st.StaffID
			AND po.SupplierID=sup.SupplierID 
			";
	$result=mysqli_query($connection,$Query);
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Purchase Order Search</title>
	<link rel="stylesheet" type="text/css" href="DatePicker/datepicker.css" />
	<script type="text/javascript" src="DatePicker/datepicker.js"></script>

</head>
<body>
<form action="Purchase_Order_Search.php" method="post">
<fieldset>
<legend>Search Option :</legend>
<table cellpadding="5px" >
<tr>
	<td>
		<input type="radio" name="rdoSearchType" value="1" checked />Search by ID
		<br/>
		<select name="cboPOID">
		<option>---Choose POID---</option>
		<?php  
		$PData="SELECT * FROM purchaseorder";
		$Presult=mysqli_query($connection,$PData);
		$Pcount=mysqli_num_rows($Presult);

		for($i=0;$i<$Pcount;$i++) 
		{ 
			$Prow=mysqli_fetch_array($Presult);
			$PurchaseOrderID=$Prow['PurchaseOrderID'];

			echo "<option value='$PurchaseOrderID'>$PurchaseOrderID</option>";
		}
		?>
		</select>
	</td>
	<td>
		<input type="radio" name="rdoSearchType" value="2" />Search by Date
		<br/>
		From :
		<input type="text" name="txtFrom" value="<?php echo date('Y-m-d') ?>"  onClick="showCalender(calender,this)" />
		To :
		<input type="text" name="txtTo" value="<?php echo date('Y-m-d') ?>"  onClick="showCalender(calender,this)" />
	</td>
	<td>
		<input type="radio" name="rdoSearchType" value="3" />Search by Status
		<br/>
		<select name="cboStatus">
		<option>---Choose Status---</option>
		<option>Pending</option>
		<option>Confirmed</option>
		</select>
	</td>
	<td>
		<br/>
		<input type="submit" name="btnSearch" value="Search" />
		<input type="submit" name="btnShowAll" value="Show All" />
		<input type="reset" name="btnReset" value="Clear" />
	</td> 
</tr>
</table>
<hr/>
<?php  

$count=mysqli_num_rows($result);

if ($count < 1) 
{
	echo "<p>No Record Found.</p>";
}
else
{
?>
	<table cellpadding="5px" border="1" width="100%">
	<tr>
		<th>POID</th>
		<th>PODate</th>
		<th>SupplierName</th>
		<th>StaffName</th>
		<th>TotalAmount</th>
		<th>TotalQuantity</th>
		<th>GrandTotal</th>
		<th>Status</th>
		<th>Action</th>
	</tr>
	<?php
	for($i=0;$i<$count;$i++) 
	{ 
		$row=mysqli_fetch_array($result);
		$PurchaseOrderID=$row['PurchaseOrderID'];

		echo "<tr>";
			echo "<td> $PurchaseOrderID </td>";
			echo "<td>" . $row['PurchaseOrderDate'] . "</td>";
			echo "<td>" . $row['SupplierName'] . "</td>";
			echo "<td>" . $row['StaffName'] . "</td>";
			echo "<td>" . $row['TotalAmount'] . "</td>";
			echo "<td>" . $row['TotalQuantity'] . "</td>";
			echo "<td>" . $row['GrandTotal'] . "</td>";
			echo "<td>" . $row['Status'] . "</td>";
			echo "<td>
					<a href='Purchase_Details.php?PurchaseOrderID=$PurchaseOrderID'>Details</a>
				  </td>";
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