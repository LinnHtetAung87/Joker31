<?php  
session_start();
include('connect.php');

if(isset($_POST['btnLogin'])) 
{
	$txtEmail=$_POST['txtEmail'];
	$txtPassword=$_POST['txtPassword'];

	$CheckAccount="SELECT a.* 
				   FROM admin a
				   WHERE Email='$txtEmail'
				   AND Password='$txtPassword'";
	$result=mysqli_query($connection,$CheckAccount);
	$count=mysqli_num_rows($result);
	$arr=mysqli_fetch_array($result);

	if($count < 1) 
	{
		echo "<script>window.alert('Email or Password Incorrect')</script>";
		echo "<script>window.location='admin_login.php'</script>";
	}
	else
	{
		$_SESSION['adminID']=$arr['adminID'];
		$_SESSION['adminname']=$arr['adminname'];
		

		echo "<script>window.alert('Successfully Login as Admin!')</script>";
		echo "<script>window.location='Role_Entry.php'</script>";
	}
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Admin Login</title>
</head>
<body>
<form action="admin_login.php" method="post">

<fieldset>
<legend>Admin Login :</legend>
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