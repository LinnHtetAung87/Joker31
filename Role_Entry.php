<?php  
session_start();
include('connect.php');

if(isset($_POST['btnSave'])) 
{
	$txtRoleName=$_POST['txtRoleName'];
	$rdoStatus=$_POST['rdoStatus'];

	//Check Validation : Role Already exist-----------------------------
	$Check="SELECT * FROM role WHERE RoleName='$txtRoleName' ";
	$result=mysqli_query($connection,$Check);
	$count=mysqli_num_rows($result);

	if($count > 0) 
	{
		echo "<script>window.alert('Role Name Already Exist!')</script>";
		echo "<script>window.location='Role_Entry.php'</script>";
	}
	else
	{
		$Insert="INSERT INTO role
				 (RoleName,Status)
				 VALUES
				 ('$txtRoleName','$rdoStatus')
				 ";
		$result=mysqli_query($connection,$Insert);
	}

	if($result) 
	{
		echo "<script>window.alert('Successfully Saved!')</script>";
		echo "<script>window.location='Role_Entry.php'</script>";
	}
	else
	{
		echo "<p>Something went wrong in Role Entry : " . mysqli_error($connection) . "</p>";
	}
	//------------------------------------------------------------------
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Role Entry</title>

<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="DataTables/datatables.min.js"></script>
<link rel="stylesheet" type="text/css" href="DataTables/datatables.min.css" />
<link rel="stylesheet" type="text/css" href="style.css" />

</head>
<body>
<form action="Role_Entry.php" method="post">

<script>
	$(document).ready
	( function ()
	{
		$('#tableid').DataTable();
	}
	);
</script>

<fieldset>
<legend>Role Entry :</legend>
<table cellpadding="5px" align="center">
<tr>
	<td>Role Name :</td>
	<td>
		<input type="text" name="txtRoleName" placeholder="Eg. Sales Manager" required />
	</td>
</tr>
<tr>
	<td>Status :</td>
	<td>
		<input type="radio" name="rdoStatus" value="Active" checked />Active
		<input type="radio" name="rdoStatus" value="InActive" />InActive
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

<?php  
$Query="SELECT * FROM Role";
$result=mysqli_query($connection,$Query);
$count=mysqli_num_rows($result);

if($count < 1) 
{
	echo "<p>No Record Found!</p>";
}
else
{
?>
	<table id="tableid" class="display">
	<thead>
	<tr>
		<th>RoleID</th>
		<th>RoleName</th>
		<th>Status</th>
		<th>Action</th>
	</tr>
	</thead>
	<tbody>
	<?php  
	for($i=0;$i<$count;$i++) 
	{ 
		$rows=mysqli_fetch_array($result);
		$RoleID=$rows['RoleID'];

		echo "<tr>";
			echo "<td>" . $RoleID . "</td>";
			echo "<td>" . $rows['RoleName'] . "</td>";
			echo "<td>" . $rows['Status'] . "</td>";
			echo "<td>
					<a href='Role_Update.php?RoleID=$RoleID'>Edit</a> |
					<a href='Role_Delete.php?RoleID=$RoleID'>Delete</a>
				  </td>";
		echo "</tr>";			
	}
	?>
	</tbody>
	</table>

<?php
}
?>
</fieldset>
</form>
</body>
</html>