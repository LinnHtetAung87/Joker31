<?php  
session_start();
include('connect.php');

if(isset($_POST['btnSave'])) 
{
	$txtStaffName=$_POST['txtStaffName'];
	$cboRoleID=$_POST['cboRoleID'];
	$txtEmail=$_POST['txtEmail'];
	$txtPassword=$_POST['txtPassword'];
	$txtPhone=$_POST['txtPhone'];
	$txtAddress=$_POST['txtAddress'];

	//Image Upload-------------------------------------------------------
	$fileStaffPhoto=$_FILES['fileStaffPhoto']['name']; //Alex.jpg
	$FolderName="StaffPhoto/"; //StaffPhoto/
	$FileName=$FolderName . '_' . $fileStaffPhoto;  //StaffPhoto/_Alex.jpg

	$copied=copy($_FILES['fileStaffPhoto']['tmp_name'], $FileName);

	if(!$copied) 
	{
		echo "<p>Staff Photo Cannot Upload!</p>";
		exit();
	}

	//Check Validation : Email Already exist-----------------------------
	$Check="SELECT * FROM staff WHERE Email='$txtEmail' ";
	$result=mysqli_query($connection,$Check);
	$count=mysqli_num_rows($result);

	if($count > 0) 
	{
		echo "<script>window.alert('Email Address Already Exist!')</script>";
		echo "<script>window.location='Staff_Entry.php'</script>";
	}
	else
	{
		$Insert="INSERT INTO staff
				 (StaffName,RoleID,Email,Password,Phone,Address,StaffPhoto)
				 VALUES
				 ('$txtStaffName','$cboRoleID','$txtEmail','$txtPassword','$txtPhone','$txtAddress','$FileName')
				 ";
		$result=mysqli_query($connection,$Insert);
	}

	if($result) 
	{
		echo "<script>window.alert('Successfully Saved!')</script>";
		echo "<script>window.location='Staff_Entry.php'</script>";
	}
	else
	{
		echo "<p>Something went wrong in Staff Entry : " . mysqli_error($connection) . "</p>";
	}
	//------------------------------------------------------------------
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Staff Entry</title>
</head>
<body>
<form action="Staff_Entry.php" method="post" enctype="multipart/form-data">

<script>
	$(document).ready
	( function ()
	{
		$('#tableid').DataTable();
	}
	);
</script>

<fieldset>
<legend>Staff Entry :</legend>
<table cellpadding="5px" align="center">
<tr>
	<td>Staff Name :</td>
	<td>
		<input type="text" name="txtStaffName" placeholder="Eg. Alan Smith" required />
	</td>
</tr>
<tr>
	<td>Role :</td>
	<td>
		<select name="cboRoleID">
		<option>--Choose Role--</option>
		<?php  
		$RoleData="SELECT * FROM Role";
		$result=mysqli_query($connection,$RoleData);
		$count=mysqli_num_rows($result);

		for($i=0;$i<$count;$i++) 
		{ 
			$row=mysqli_fetch_array($result);
			$RoleID=$row['RoleID'];
			$RoleName=$row['RoleName'];

			echo "<option value='$RoleID'>$RoleID - $RoleName</option>";
		}
		?>
		</select>
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
	<td>Staff Photo :</td>
	<td>
		<input type="file" name="fileStaffPhoto" required />
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