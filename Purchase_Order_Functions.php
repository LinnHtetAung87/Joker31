<?php  
error_reporting(0);
function AddProduct($ProductID,$PurchasePrice,$PurchaseQuantity)
{
	include('connect.php');

	$Query="SELECT * FROM product WHERE ProductID='$ProductID' ";
	$result=mysqli_query($connection,$Query);
	$count=mysqli_num_rows($result);
	$arr=mysqli_fetch_array($result);

	if($count < 1) 
	{
		echo "<p>No Product Found.</p>";
		exit();
	}

	if ($PurchaseQuantity < 1) 
	{
		echo "<p>Incorrect Quantity.</p>";
		exit();

	}

	if(isset($_SESSION['Purchase_Functions'])) 
	{	
		$index=IndexOf($ProductID);

		if($index == -1) 
		{
			$count=count($_SESSION['Purchase_Functions']);

			$_SESSION['Purchase_Functions'][$count]['ProductID']=$ProductID;
			$_SESSION['Purchase_Functions'][$count]['PurchasePrice']=$PurchasePrice;
			$_SESSION['Purchase_Functions'][$count]['PurchaseQuantity']=$PurchaseQuantity;

			$_SESSION['Purchase_Functions'][$count]['ProductName']=$arr['ProductName'];
			$_SESSION['Purchase_Functions'][$count]['ProductImage1']=$arr['ProductImage1'];
		}
		else
		{
			$_SESSION['Purchase_Functions'][$index]['PurchaseQuantity']+=$PurchaseQuantity;
		}
	}
	else // for array zero position
	{
		$_SESSION['Purchase_Functions']=array();

		$_SESSION['Purchase_Functions'][0]['ProductID']=$ProductID;
		$_SESSION['Purchase_Functions'][0]['PurchasePrice']=$PurchasePrice;
		$_SESSION['Purchase_Functions'][0]['PurchaseQuantity']=$PurchaseQuantity;

		$_SESSION['Purchase_Functions'][0]['ProductName']=$arr['ProductName'];
		$_SESSION['Purchase_Functions'][0]['ProductImage1']=$arr['ProductImage1'];
	}

	echo "<script>window.location='Purchase_Order.php'</script>";

}

function IndexOf($ProductID)
{
	if (!isset($_SESSION['Purchase_Functions'])) 
	{
		return -1;
	}

	$count=count($_SESSION['Purchase_Functions']);

	if($count < 1)
	{
		return -1;
	}
	else
	{
		for ($i=0; $i < $count; $i++) 
		{ 
			if ($ProductID == $_SESSION['Purchase_Functions'][$i]['ProductID']) 
			{
				return $i;
			}	
		}
		return -1;
	}
}

function CalculateTotalAmount()
{
	$TotalAmount=0;

	$count=count($_SESSION['Purchase_Functions']);

	for($i=0;$i<$count;$i++) 
	{ 
		$PurchasePrice=$_SESSION['Purchase_Functions'][$i]['PurchasePrice'];
		$PurchaseQuantity=$_SESSION['Purchase_Functions'][$i]['PurchaseQuantity'];

		$TotalAmount += ($PurchasePrice * $PurchaseQuantity);
	}
	return $TotalAmount;
}

function CalculateTotalQuantity()
{
	$TotalQuantity=0;
	
	$count=count($_SESSION['Purchase_Functions']);

	for($i=0;$i<$count;$i++) 
	{ 
		$PurchaseQuantity=$_SESSION['Purchase_Functions'][$i]['PurchaseQuantity'];

		$TotalQuantity += ($PurchaseQuantity);
	}
	return $TotalQuantity;
}

function RemoveProduct($ProductID)
{
	$index=IndexOf($ProductID);

	unset($_SESSION['Purchase_Functions'][$index]);
	$_SESSION['Purchase_Functions']=array_values($_SESSION['Purchase_Functions']);

	echo "<script>window.location='Purchase_Order.php'</script>";
}

function ClearAll()
{
	unset($_SESSION['Purchase_Functions']);
	echo "<script>window.location='Purchase_Order.php'</script>";

}

?>








