<?php  
function AddProduct($ProductID,$BuyQuantity)
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

	if ($BuyQuantity < 1) 
	{
		echo "<p>Incorrect Quantity.</p>";
		exit();

	}

	if(isset($_SESSION['Shopping_Cart_Functions'])) 
	{	
		$index=IndexOf($ProductID);

		if($index == -1) 
		{
			$count=count($_SESSION['Shopping_Cart_Functions']);

			$_SESSION['Shopping_Cart_Functions'][$count]['ProductID']=$ProductID;
			$_SESSION['Shopping_Cart_Functions'][$count]['BuyQuantity']=$BuyQuantity;

			$_SESSION['Shopping_Cart_Functions'][$count]['ProductName']=$arr['ProductName'];
			$_SESSION['Shopping_Cart_Functions'][$count]['Price']=$arr['Price'];
			$_SESSION['Shopping_Cart_Functions'][$count]['ProductImage1']=$arr['ProductImage1'];
		}
		else
		{
			$_SESSION['Shopping_Cart_Functions'][$index]['BuyQuantity']+=$BuyQuantity;
		}
	}
	else // for array zero position
	{
		$_SESSION['Shopping_Cart_Functions']=array();

		$_SESSION['Shopping_Cart_Functions'][0]['ProductID']=$ProductID;
		$_SESSION['Shopping_Cart_Functions'][0]['BuyQuantity']=$BuyQuantity;

		$_SESSION['Shopping_Cart_Functions'][0]['ProductName']=$arr['ProductName'];
		$_SESSION['Shopping_Cart_Functions'][0]['Price']=$arr['Price'];
		$_SESSION['Shopping_Cart_Functions'][0]['ProductImage1']=$arr['ProductImage1'];
	}

	echo "<script>window.location='Shopping_Cart.php'</script>";

}

function IndexOf($ProductID)
{
	if (!isset($_SESSION['Shopping_Cart_Functions'])) 
	{
		return -1;
	}

	$count=count($_SESSION['Shopping_Cart_Functions']);

	if($count < 1)
	{
		return -1;
	}
	else
	{
		for ($i=0; $i < $count; $i++) 
		{ 
			if ($ProductID == $_SESSION['Shopping_Cart_Functions'][$i]['ProductID']) 
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

	$count=count($_SESSION['Shopping_Cart_Functions']);

	for($i=0;$i<$count;$i++) 
	{ 
		$Price=$_SESSION['Shopping_Cart_Functions'][$i]['Price'];
		$BuyQuantity=$_SESSION['Shopping_Cart_Functions'][$i]['BuyQuantity'];

		$TotalAmount += ($Price * $BuyQuantity);
	}
	return $TotalAmount;
}

function CalculateTotalQuantity()
{
	$TotalQuantity=0;

	$count=count($_SESSION['Shopping_Cart_Functions']);

	for($i=0;$i<$count;$i++) 
	{ 
		$BuyQuantity=$_SESSION['Shopping_Cart_Functions'][$i]['BuyQuantity'];

		$TotalQuantity += ($BuyQuantity);
	}
	return $TotalQuantity;
}

function RemoveProduct($ProductID)
{
	$index=IndexOf($ProductID);

	unset($_SESSION['Shopping_Cart_Functions'][$index]);
	$_SESSION['Shopping_Cart_Functions']=array_values($_SESSION['Shopping_Cart_Functions']);

	echo "<script>window.location='Shopping_Cart.php'</script>";
}

function ClearAll()
{
	unset($_SESSION['Shopping_Cart_Functions']);
	echo "<script>window.location='Shopping_Cart.php'</script>";

}


?>