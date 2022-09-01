<?php  
session_start();
include('connect.php');

if(isset($_POST['btnUpdate'])) 
{
	$txtRoleID=$_POST['txtRoleID'];
	$txtRoleName=$_POST['txtRoleName'];
	$rdoStatus=$_POST['rdoStatus'];

	$Update="UPDATE role
			 SET 
			 RoleName='$txtRoleName',
			 Status='$rdoStatus'
			 WHERE 
			 RoleID='$txtRoleID'
			 ";
	$result=mysqli_query($connection,$Update);
	
	if($result) 
	{
		echo "<script>window.alert('Successfully Updated!')</script>";
		echo "<script>window.location='Role_Entry.php'</script>";
	}
	else
	{
		echo "<p>Something went wrong in Role Update : " . mysqli_error($connection) . "</p>";
	}
	//------------------------------------------------------------------
}

if(isset($_GET['RoleID'])) 
{
	$RoleID=$_GET['RoleID'];

	$Query="SELECT * FROM role WHERE RoleID='$RoleID' ";
	$result=mysqli_query($connection,$Query);
	$arr=mysqli_fetch_array($result);
}	
else
{
	$RoleID="";
	echo "<script>window.location='Role_Entry.php'</script>";
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Role Uodate</title>

<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="DataTables/datatables.min.js"></script>
<link rel="stylesheet" type="text/css" href="DataTables/datatables.min.css" />
<link rel="stylesheet" type="text/css" href="style.css" />

</head>
<body>
<form action="Role_Update.php" method="post">
<fieldset>
<legend>Role Update :</legend>
<a href="Role_Entry.php">Role List</a>
<table cellpadding="5px" align="center">
<tr>
	<td>Role Name :</td>
	<td>
		<input type="text" name="txtRoleName" value="<?php echo $arr['RoleName'] ?>" required />
	</td>
</tr>
<tr>
	<td>Status :</td>
	<td>
		<?php  
		if($arr['Status'] == "Active") 
		{
			echo "<input type='radio' name='rdoStatus' value='Active' checked />Active";
			echo "<input type='radio' name='rdoStatus' value='InActive' />InActive";
		}
		else
		{
			echo "<input type='radio' name='rdoStatus' value='Active'  />Active";
			echo "<input type='radio' name='rdoStatus' value='InActive' checked />InActive";
		}
		?>
	</td>
</tr>
<tr>
	<td></td>
	<td>
		<input type="hidden" name="txtRoleID" value="<?php echo $arr['RoleID'] ?>">
		<input type="submit" name="btnUpdate" value="Update" />
		<input type="reset" name="btnClear" value="Clear" />
	</td>
</tr>
</table>
</fieldset>
</form>
</body>
</html>