<?php  
session_start();
include('connect.php');

if(isset($_POST['btnSave'])) 
{
	$txtcustomername=$_POST['txtcustomername'];
	$txtEmail=$_POST['txtEmail'];
	$txtPassword=$_POST['txtPassword'];
	$txtPhone=$_POST['txtPhone'];
	$txtAddress=$_POST['txtAddress'];

	//Image Upload-------------------------------------------------------
	//$filecustomerphoto=$_FILES['filecustomerphoto']['name']; //Alex.jpg
	//$FolderName="customerphoto/"; //CustomerPhoto/
	//$FileName=$FolderName . '_' . $filecustomerphoto;  //CustomerPhoto/_Alex.jpg

	//$copied=copy($_FILES['filecustomerphoto']['tmp_name'], $FileName);

	//if(!$copied) 
	//{
		//echo "<p>Customer Photo Cannot Upload!</p>";
		//exit();
	//}

	//Check Validation : Email Already exist-----------------------------
	$Check="SELECT * FROM customer WHERE Email='$txtEmail' ";
	$result=mysqli_query($connection,$Check);
	$count=mysqli_num_rows($result);

	if($count > 0) 
	{
		echo "<script>window.alert('Email Address Already Exist!')</script>";
		echo "<script>window.location='customer_entry.php'</script>";
	}
	else
	{
		$Insert="INSERT INTO customer
				 (customername,Email,Password,Phone,Address)
				 VALUES
				 ('$txtcustomername','$txtEmail','$txtPassword','$txtPhone','$txtAddress')
				 ";
		$result=mysqli_query($connection,$Insert);
	}

	if($result) 
	{
		echo "<script>window.alert('Successfully Saved!')</script>";
		echo "<script>window.location='customer_entry.php'</script>";
	}
	else
	{
		echo "<p>Something went wrong in Customer Entry : " . mysqli_error($connection) . "</p>";
	}
	//------------------------------------------------------------------
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Customer Entry</title>
</head>
<body>
<form action="customer_entry.php" method="post" enctype="multipart/form-data">

<script>
	$(document).ready
	( function ()
	{
		$('#tableid').DataTable();
	}
	);
</script>

<fieldset>
<legend>Customer Entry :</legend>
<table cellpadding="5px" align="center">
<tr>
	<td>Customer Name :</td>
	<td>
		<input type="text" name="txtcustomername" placeholder="Eg. Alan Smith" required />
	</td>
</tr>

<tr>
	<td>Email :</td>
	<td>
		<input type="email" name="txtEmail" placeholder="example@domain.com" required />
	</td>
</tr>
<tr>
	<td>Password :</td>
	<td>
		<input type="password" name="txtPassword" placeholder="XXXXXXXXXXXXXX" required />
	</td>
</tr>
<tr>
	<td>Phone :</td>
	<td>
		<input type="text" name="txtPhone" placeholder="+95-----------" required />
	</td>
</tr>

<tr>
	<td>Address :</td>
	<td>
		<textarea name="txtAddress" placeholder="Enter Address"></textarea>
	</td>
</tr>
<tr>
	<td></td>
	<td>
		<input type="submit" name="btnSave" value="Save" />
		<input type="reset" name="btnClear" value="Clear" />
	</td>
</tr>
</table>
<hr/>

</form>
</body>
</html>