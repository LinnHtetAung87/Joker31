<?php  
session_start();
include('connect.php');

if(isset($_POST['btnLogin'])) 
{
	$txtEmail=$_POST['txtEmail'];
	$txtPassword=$_POST['txtPassword'];

	$CheckAccount="SELECT s.*,r.RoleID,r.RoleName 
				   FROM staff s, role r
				   WHERE Email='$txtEmail'
				   AND Password='$txtPassword'
				   AND s.RoleID=r.RoleID ";
	$result=mysqli_query($connection,$CheckAccount);
	$count=mysqli_num_rows($result);
	$arr=mysqli_fetch_array($result);

	if($count < 1) 
	{
		echo "<script>window.alert('Email or Password Incorrect')</script>";
		echo "<script>window.location='Staff_Login.php'</script>";
	}
	else
	{
		$_SESSION['StaffID']=$arr['StaffID'];
		$_SESSION['StaffName']=$arr['StaffName'];
		$_SESSION['RoleName']=$arr['RoleName'];

		echo "<script>window.alert('Successfully Login as Staff!')</script>";
		echo "<script>window.location='Staff_Dashboard.php'</script>";
	}
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Staff Login</title>
</head>
<body>
<form action="Staff_Login.php" method="post">

<fieldset>
<legend>Staff Login :</legend>
<table cellpadding="5px" align="center">
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
	<td></td>
	<td>
		<input type="submit" name="btnLogin" value="Login" />
		<input type="reset" name="btnClear" value="Clear" />
	</td>
</tr>
</table>
<hr/>

</form>
</body>
</html>