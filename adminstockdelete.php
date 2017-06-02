<?php
	session_start();
	include("php/functions.php");
	$username=checkUser($_SESSION['userid'],session_id(),2);
	$currentuser=getUserLevel();
	if(isset($_COOKIE['userintent'])) {
		if($currentuser['userlevel']==0 && $_COOKIE['userintent']=="editarticle") {
			header("location:	login.php");
	exit;
		}
	}

	$userid=$currentuser['userid'];
	$stocktoedit=$_GET['stocktoedit'];
?>

<!DOCTYPE html>
<html>
 <head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  
      <title>Delete Stock</title>
	  
		<!--[if (lte IE 8)&!(IEMobile)]>
		<script>
		<script src="js/iefix.js"></script>
		</script>
		<link rel="stylesheet" type="text/css" href="css/ieold.css" />

		<![endif]-->
	  
	  <!-- Stylesheets Original -->
	  
      <link rel="stylesheet" href="css/foundation.min.css">
      <link rel="stylesheet" href="css/custom.css">
	   <link rel="stylesheet" href="css/style_fieldset.css">
	  
	   <!-- Stylesheets Responsive -->
		<link rel="stylesheet" type="text/css" media="screen and (min-width: 840px) and (max-width:999px)" href="css/medium.css" />
		<link rel="stylesheet" type="text/css" media="screen and (min-width: 640px) and (max-width:839px)" href="css/medium_narrow.css" />
		<link rel="stylesheet" type="text/css" media="screen and (max-width:639px)" href="css/narrow.css" />
		<link rel="stylesheet" type="text/css" media="screen and (min-width: 1000px)" href="css/wide.css" />
		
		 <!--  Thumnail Gallery -->
		
		<link rel="stylesheet" href="css/gallery.css">
		
		<script src="https://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
		<script src="js/script.js"></script>
	  
		<!-- Fonts -->
	  
      <link href="https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,100italic,300italic,400italic,700italic,900italic" rel="stylesheet">
	  <link href='https://fonts.googleapis.com/css?family=Exo:400,500,700,900' rel='stylesheet' type='text/css'>
      <link href="https://fonts.googleapis.com/css?family=Pacifico" rel="stylesheet">
	  
	  	<!--  Narrow Menu -->
	  
	  <script src="https://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
	  <script src="script.js"></script>
	 
	  
	  
 </head>
 
  <body>
  	
    <div class="container background_main_banner_small ">
      <header class="row " id="main">
          <div>
		  <img src="img/logo.png" alt=""class="hidden">
          </div>
		   <img src="img/logo_200.png" alt="" class="logoo_narrow">
		   
		
        <nav id="main">
		<div id="cssmenu" class="">
          <ul>
            <li><a href='index.html'class="button button-primary "><span>Home</span></a></li>
            <li><a href='gallery.html'class="button button-primary "><span>Gallery</span></a></li>
            <li><a href='shop.php'class="button button-primary "><span>Shop</span></a></li>
            <li><a href='photo_tips.html'class="button button-primary "><span>Photo Tips</span></a></li>
             <li><a href="about.html"class="button button-primary "><span>About</span></a></li>
			 <li><a href="view_cart.php"class="button button-primary "><span>Basket</span></a></li>
            <li><a href="login.php"class="button button-primary "><span>Sign up</span></a></li>
          </ul>
		  </div>
		  </nav>
      
      </header>
	  
      <div class="row feature feature_small   ">
        <div class="large-5 column ">
		<h1 class="hidden_small">Dunkeld Wildlife Photo Society.</h1>
        </div>
      </div>
    </div>
	
	
<!--\\\\\\\\\\\\\\\\\\\\\///////////////////////////////\\\\\\\\\\\\\\\\/////////\\\\\\ -->
	
  <!-- Admin delete stock -->
  <div class="container-spacy   ">
   <div class="row ">
	   <h3 class="h4_user_inactive">Delete Stock</h3>

	<ul>
		<?php if($currentuser['userlevel']>1) { ?>
		<li><a href="user.php" class="button">Account Panel</a></li>
		<br>
			<?php if($currentuser['userlevel']>2) { ?>
		<!--<li><a href="admin.php" class="button">Administration</a></li>-->
			<?php } ?>
		<?php } ?>
		<li><a href="php/logout.php" class="button">Log Out</a></li>
	</ul>
	
<section id="main">

<?php
	$db=createConnection();
	// get the first two articles
	$sql = "select id, product_code,product_name,product_desc,product_img_name,price,stockqty from stock where id=?";
	$stmt = $db->prepare($sql);
	$stmt->bind_param("i",$stocktoedit);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($id,$product_code,$product_name,$product_desc,$product_img_name,$price,$stockqty);

	while($stmt->fetch()) {

		// if user is logged in and not suspended add comment button
		if($currentuser['userlevel']==3) {
			?> 
		<br>

			<p>Id: <?php echo $id; ?></p>
			<p>Product Code: <?php echo $product_code; ?></p>
			<p>Firstname: <?php echo $product_name; ?></p>
			<p>Product Description: <?php echo $product_desc; ?><p>
			<p>Product Image Name: <?php echo $product_img_name; ?></p>
			<p>Price: <?php echo $price; ?></p>
			<p>Stock Quantity: <?php echo $stockqty; ?></p>
		
		<form method='post' action='php/xdeletestock.php'>
				<input type="hidden" readonly value="<?php echo $stocktoedit ?>" id="id" name="id" />
				<br>
				<button type="submit">Confirm Delete</button>
				</form> 
		

		<?php
		}
	}
	$stmt->close();
	$db->close();
?>
</section>			
			
	

</div>
</div>


<!--\\\\\\\\\\\\\\\\\\\\\///////////////////////////////\\\\\\\\\\\\\\\\/////////\\\\\\ -->


	
  </body>
</html>





























