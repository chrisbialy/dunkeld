<?php
session_start();
include_once("config.php");
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Checkout</title>
<link href="css/style.css" rel="stylesheet" type="text/css">
<link href="css/style_fieldset.css" rel="stylesheet" type="text/css">
</head>
<body>

<h1 align="center">Checkout</h1>
<div class="cart-view-table-back">
<form name="cart_update" method="post" action="confirmation.php">
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



 <!-- Register User -->
  <div class="container-spacy background-white background-black2 h2_extra recent ">
   <h2>Delivery Details</h2>
	<div class="center_fieldset">
	<form id="registeruser" name="registeruser" method="post" action="confirmation.php">
	<fieldset><legend>Personal Details</legend>
	<br>
	<label for="userid"></label><input type="number" placeholder="User Id" id="userid" min="1" name="userid" required size="15" class="margin" /><span id="useridFB"></span><br />
	<br>
	<label for="firstname"> </label><input type="text" placeholder="First name" id="firstname" name="firstname" required size="15" class="margin"  /><span id="firstnameFb"></span><br />
	<br>
	<label for="surname"></label><input type="text" placeholder="Surname" id="surname" name="surname" required size="15" class="margin"   /><span id="surnameFb"></span><br />
	<br>
	<label for="emailadd"></label><input type="email" placeholder="Email" id="emailadd" name="emailadd" required size="15" class="margin"  /><span id="emailFb"></span><br />
	<br>

	<fieldset>	
	<legend>Delivery Address</legend>
	<br>
	<label for="Street"></label><input type="text" placeholder="Street" id="street" name="street" required size="15" class="margin"  /><span id="streetFb"></span><br />
	<br>
	<label for="Town"></label><input type="text" placeholder="Town" id="town" name="town" required size="15" class="margin"  /><span id="streetFb"></span><br />
	<br>
	<label for="Postcode"></label><input type="text" pattern="[A-Za-z]{1,2}[0-9Rr][0-9A-Za-z]? [0-9][ABD-HJLNP-UW-Zabd-hjlnp-uw-z]{2}" placeholder="Postcode" id="town" name="postcode" required size="15" class="margin"  /><span id="postcodeFb"></span><br />	
	<br>
	</fieldset>
	<button type="reset">Reset</button><button type="submit">Confirmation</button>
</form>
</form>

</div>

</body>
</html>
