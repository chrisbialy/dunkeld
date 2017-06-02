<?php
session_start();
include("php/functions.php");
$currentuser=getUserLevel();
if(isset($_COOKIE['userintent'])) {
	if($currentuser['userlevel']==0 && $_COOKIE['userintent']=="addarticle") {
		header("location:	login.php");
exit;
	}
}
$username=checkUser($_SESSION['userid'],session_id(),2);

?>

<!DOCTYPE html>
<html>
 <head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  
      <title>Add Stock Item</title>
	  
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
	
  <!-- User Logged In  -->
  <div class="container-spacy   ">
   <div class="center_fieldset">
   <div class="row ">
	  <h3 class="h4_user_inactive">Add Stock Item</h3>
	  	<ul>
		<?php if($currentuser['userlevel']>1) { ?> 	<!--Only Active Users Can Add comments-->
		<li><a href="administration.php" class="button">Administration</a></li>
		<br>
		<li><a href="user.php" class="button">Account Panel<a></li>
		<br>
			<?php if($currentuser['userlevel']>2) { ?>
			<?php } ?>
		<?php } ?>
		<li><a href="php/logout.php" class="button">Log Out</a></li>
		<br>
	</ul>

<section id="main">

	<form method="post" action="php/xaddstockitem.php">
	<fieldset><legend>Add New Item</legend>
			<label for="product_code"></label><input type="text" placeholder="Product Code" name="product_code" id="product_code" size="30" class="margin" required/></textarea><br />
			<br>
			<label for="product_name"></label><input type ="text" name="product_name" placeholder="Product Name" id="product_name" size="30" class="margin"  /><br />
			<br>
			<label for="product_desc"></label><textarea type="text" name="product_desc" placeholder="Product Description" class="margin" id="product_desc"cols="31" rows="3"></textarea><br />
			<br>
			<label for="product_img_name"></label><input type="text" name="product_img_name" id="product_img_name" placeholder="Product Image Name" class="margin"/><br />
			<br>
			<label for="price"></label><input type="number" step="any" min="0" name="price" placeholder="Price" id="price" size="6"class="margin" /><br />
			<br>
			<label for="stockqty"></label><input type="number" min="0" name="stockqty" placeholder="Stock Quantity" id="stockqty" size="6"class="margin" /><br />
			<br>
		<button type="submit">Add Item</button>
	</fieldset>
	</form>
</section>
		<br>
<section id="main">
	<fieldset><legend>Upload Photo</legend>
	<form action="uploadimage.php" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <button  type="submit" value="Upload Image" name="submit">Upload Image</button>
	
	<!-- <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Image" name="submit"> -->
	
</form>
	
	</fieldset>
</section>			
	
</div>
</div>
</div>


<!--\\\\\\\\\\\\\\\\\\\\\///////////////////////////////\\\\\\\\\\\\\\\\/////////\\\\\\ -->


	
  </body>
</html>









