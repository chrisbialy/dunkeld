<?php
session_start();
include_once("config.php");
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Confirmation</title>
<link href="css/style_fieldset.css" rel="stylesheet" type="text/css">
<link href="css/style.css" rel="stylesheet" type="text/css">
</head>
<body>

<h1 align="center">Confirmation</h1>
<div class="cart-view-table-back">
<form name="cart_update" method="post" action="">
<table width="100%"  cellpadding="6" cellspacing="0"><thead><tr><th>Quantity</th><th>Code</th><th>Name</th><th>Size</th><th>Price</th><th>Total</th></tr></thead>
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
	<a href="payment.php" class="button">Payment</a>
	<br>
  <!-- Register for delivery address  -->
  <div class="container-spacy background-white background-black2 h2_extra recent ">
   <h4>Delivery</h4>
		<div class="row">
		
	<?php
	include("php/functions.php");
	$userid=$_POST['userid'];
	$firstname=$_POST['firstname'];
	$surname=$_POST['surname'];
	$emailadd=$_POST['emailadd'];
	$street=$_POST['street'];
	$town=$_POST['town'];
	$postcode=$_POST['postcode'];
	
	
	// Used to check that submitted user does not exist already
	
	$userexists=false;
	$emailexists=false;
	
	
	// connect to database
	
	$db = createConnection();
	
	// check form details again in case javascript disabled form bypassed
	// javascript client side scripting
	// check userid and email do not already exist
	
	$sql="select userid,emailadd from customer where userid=? or emailadd=?;";
	$stmt=$db->prepare($sql);
	$stmt->bind_param("is",$userid,$emailadd);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($userresult,$emailresult);
	while($row=$stmt->fetch()) {
		if($userresult==$userid) {$userexists=true;}
		if($emailresult==$emailadd) {$emailexists=true;}
	}
	
	if($userexists && $emailexists && filter_var($emailadd, FILTER_VALIDATE_EMAIL)) {
	
	// insert into oorder
	
		$insertquery="insert into oorder (userid, firstname, surname, emailadd, street, town, postcode) values (?,?,?,?,?,?,?);";
		$inst=$db->prepare($insertquery);
		$inst->bind_param("issssss", $userid, $firstname, $surname, $emailadd, $street, $town, $postcode);
		$inst->execute();
	
	// check user inserted, if so display delivery details
	
			
	
		if($inst->affected_rows==1) {
	
	?>
	<fieldset>	
	<legend>Items will be sent to</legend>
	<?php echo $firstname; ?>
	<br>
	<?php echo $surname; ?>
	<br>
	<?php echo $street;?>
	<br>
	<?php echo $town ?>
	<br>
	<?php echo $postcode ?>
	</fieldset>	
	

		<?php } else { 
		//feedback there was a problem adding the user
		echo "<p>There was a problem adding your details. Please contact the website administrators</p>"; 
		}
} else { 
// registration failed either due to disabled javascript or other attempt to bypass validation
?>

	<?php 
		if(!$emailexists){ echo "<p>The email address $emailadd doesn't exists.</p>"; }
		if(!$userexists){ echo "<p>The userid $userid doesn't exists.</p>"; }
		if(!filter_var($emailadd, FILTER_VALIDATE_EMAIL)){ echo "<p>The email address is invalid.</p>"; }
		?>
		<fieldset>
		<p><font color="red">You need to register</p>
		<a href="register.html" class="button">Register</a>
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