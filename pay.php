<?php
session_start();
include_once("config.php");
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Pay</title>
<link href="css/style.css" rel="stylesheet" type="text/css">
<link href="css/style_fieldset_basket.css" rel="stylesheet" type="text/css">
</head>
<body>

<h1 align="center">Pay</h1>
<div class="cart-view-table-back">
<form name="cart_update" method="post" action="">
<table width="100%"  cellpadding="1" cellspacing="0"><thead><tr><th>Quantity</th><th>Code</th><th>Name</th><th>Size</th><th>Price</th><th>Total</th></tr></thead>
  <tbody>

 	<?php
	if(isset($_SESSION["cart_products"])) //check session var
		{
		
		
		$total = 0; //set initial total value
		$b = 0; //var for zebra stripe table 
		foreach ($_SESSION["cart_products"] as $cart_itm)
        {
			//set variables to use in content below
			$product_name = $cart_itm["product_name"];
			$product_qty = $cart_itm["product_qty"];
			$product_price = $cart_itm["product_price"];
			$product_code = $cart_itm["product_code"];
			$product_color = $cart_itm["product_color"];
			$subtotal = ($product_price * $product_qty); //calculate Price x Qty
			
		   	$bg_color = ($b++%2==1) ? 'odd' : 'even'; //class for zebra stripe 
		    echo '<tr class="'.$bg_color.'">';
			echo '<td>'.$product_qty.'</td>';
			echo '<td>'.$product_code.'</td>';
			echo '<td>'.$product_name.'</td>';
			echo '<td>'.$product_color.'</td>';
			echo '<td>'.$currency.$product_price.'</td>';
			echo '<td>'.$currency.$subtotal.'</td>';
            echo '</tr>';
			$total = ($total + $subtotal); //add subtotal to total var
        }
	
		$grand_total = $total + $shipping_cost; //grand total including shipping cost
		foreach($taxes as $key => $value){ //list and calculate all taxes in array
				$tax_amount     = round($total * ($value / 100));
				$tax_item[$key] = $tax_amount;
				$grand_total    = $grand_total + $tax_amount;  //add tax val to grand total
		}
		
		$list_tax       = '';
		foreach($tax_item as $key => $value){ //List all taxes
			$list_tax .= $key. ' : '. $currency. sprintf("%01.2f", $value).'<br />';
		}
		$shipping_cost = ($shipping_cost)?'Shipping Cost : '.$currency. sprintf("%01.2f", $shipping_cost).'<br />':'';
		}
		
	
	
    ?>
	
	
	
    <tr><td colspan="5"><span style="float:right;text-align: right;"><?php echo $shipping_cost. $list_tax; ?>Amount Payable : <?php echo sprintf("%01.2f", $grand_total);?></span></td></tr>
    
			
  </tbody>
</table>
<input type="hidden" name="return_url" value="<?php 
$current_url = urlencode($url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
echo $current_url; ?>" />






</form>
	
  <!-- Register for delivery address  -->
  <div class="container-spacy background-white background-black2 h2_extra recent ">
  
		<div class="row">
		
	<?php
	include("php/functions.php");
	$orderno=$_POST['orderno'];
	$firstname=$_POST['firstname'];
	$surname=$_POST['surname'];
	$emailadd=$_POST['emailadd'];
	$street=$_POST['street'];
	$town=$_POST['town'];
	$postcode=$_POST['postcode'];

	
	
	// Used to check that submitted user does not exist already

	$orderexists=false;
	
	
	// connect to database
	
	$db = createConnection();
	
	// check form details again in case javascript disabled form bypassed
	// javascript client side scripting
	// check userid and orderno do not already exist

	$sql="select orderno from oorder where orderno=?;";
	$stmt=$db->prepare($sql);
	$stmt->bind_param("i",$orderno);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($orderresult);
	while($row=$stmt->fetch()) {
		if($orderresult==$orderno) {$orderexists=true;}
	}
		
			
	if ($orderexists) {
	
	// insert into item table multiple poducts (repeating orderno and single product_code)
		
	if(isset($_SESSION["cart_products"])) //check session var
		{
		
		
		$total = 0; //set initial total value
		$b = 0; //var for zebra stripe table 
		foreach ($_SESSION["cart_products"] as $cart_itm)
        {
			
	//set variables to use in content below
			$product_qty = $cart_itm["product_qty"];
			$product_code = $cart_itm["product_code"];
			
			
		$insertquery="insert into orderline (orderno, product_code, qty) values (?,?,?);";
		$inst=$db->prepare($insertquery);
		$inst->bind_param("isi", $orderno, $product_code, $product_qty);
		$inst->execute();
		
		//Updating stock table /////\\\\\\\\\
		
		$query="UPDATE stock SET stockqty=stockqty-'".$product_qty."' WHERE product_code='".$product_code."'";
		$up=$db->prepare($query);
		$up->bind_param("ii",$product_code, $product_qty);
		$up->execute();
		
		
		//echo "hello";
		}
		}
	
		
		
		
	// check user inserted, if so display delivery details
	
		if($inst->affected_rows==1) {
	

	
	?>
	<?php echo "<h4>Payment successful</h4>";?>
	<fieldset>	
	<legend>Order Details</legend>
	<?php echo"<h3>Order Number:  $orderno</h3>";  ?>
	<?php echo $firstname; ?>
	<br>
	<?php echo $surname; ?>
	<br>
	<?php echo $street;?>
	<br>
	<?php echo $town ?>
	<br>
	<?php echo $postcode ?>
	<?php echo "<h4>Thank You $firstname for shopping with us !!!<h4>"; ?>
	<input name="button" type="button" onclick="window.print()" value="Print">
	</fieldset>	
	
	<a href="index.html" class="button">Home</a>
	
		<?php } else { 
		//feedback there was a problem adding the user
		echo "<p>There was a problem adding your details. Please contact the website administrators</p>"; 
		}
		
} else { 
// registration failed either due to disabled javascript or other attempt to bypass validation
?>


	<?php 
		if(!$orderexists){ echo "<p>The order $orderno doesn't exists.</p>"; }
		?>
		<fieldset>
		<p><font color="red">Back to shop</p>
		<a href="shop.php" class="button">Shop</a>
		</fieldset>
<?php 
}

	$stmt->close();
	$inst->close();
	$db->close(); 
?>



</div>

</body>
</html>