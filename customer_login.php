<?php  
session_start();
include('connect.php');

if(isset($_POST['btnLogin'])) 
{
	$txtEmail=$_POST['txtEmail'];
	$txtPassword=$_POST['txtPassword'];

	$CheckAccount="SELECT c.* 
				   FROM customer c
				   WHERE Email='$txtEmail'
				   AND Password='$txtPassword'";
	$result=mysqli_query($connection,$CheckAccount);
	$count=mysqli_num_rows($result);
	$arr=mysqli_fetch_array($result);

	if($count < 1) 
	{
		echo "<script>window.alert('Email or Password Incorrect')</script>";
		echo "<script>window.location='customer_login.php'</script>";
	}
	else
	{
		$_SESSION['customerID']=$arr['customerID'];
		$_SESSION['customername']=$arr['customername'];
		

		echo "<script>window.alert('Successfully Login as Customer!')</script>";
		echo "<script>window.location='Product_Display.php'</script>";
	}
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Customer Login</title>
</head>
<body>
<form action="customer_login.php" method="post">

<fieldset>
<legend>Customer Login :</legend>
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