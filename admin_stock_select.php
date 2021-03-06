<?php
	session_start();
	// connect to the database
	include('php/functions.php');
	$username=checkUser($_SESSION['userid'],session_id(),3);
	$currentuser=getUserLevel();
	$userid=$currentuser['userid'];
	$rowstart=($_GET['f']==NULL)?0:$_GET['f'];
	$rowcount=($_GET['n']==NULL)?4:$_GET['n'];


	// connect to the database
	$db=createConnection();
?>

<!DOCTYPE html>
<html>
 <head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  
      <title>Admin User Select</title>
	  
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
	
  <!--Admin  View Stock   -->
  <div class="container-spacy   ">
   <div class="row ">
  <h3 class="h4_user_inactive">View Stock</h3>
	<ul>
		<?php if($currentuser['userlevel']>1) { ?>
		<li><a href="administration.php" class="button">Administration</a></li>
		<br>
		<li><a href="user.php" class="button">Account Panel</a></li>
		<br>
			<?php if($currentuser['userlevel']>2) { ?>
			<?php } ?>
		<?php } ?>
		<li><a href="php/logout.php" class="button">Log Out</a></li>
	</ul>
	<br>
<?php
	$userlist="SELECT id,product_code FROM stock ORDER BY id LIMIT ?,?";
	$getlist=$db->prepare($userlist);
	$getlist->bind_param("ii",$rowstart,$rowcount);
	$getlist->execute();
	$getlist->store_result();
	$getlist->bind_result($stocktoedit, $product_code);
	while ($getlist->fetch()) {
?>

<p><?php echo "Id: " .$stocktoedit." - Code: ".$product_code;?></p>
	<?php
	echo '<a href="admstockedit.php?stocktoedit='.$stocktoedit.'"class="button">Edit Stock</a>'; 
	echo '<a href="adminstockdelete.php?stocktoedit='.$stocktoedit.'"class="button">Delete Stock</a>'; 

	?>
<?php
	}
	$getlist->close();
	$totalrowssql="select count(*) as totalrows from stock;";
	$counttotal=$db->prepare($totalrowssql);
	$counttotal->execute();
	$counttotal->bind_result($totalrows);
	$counttotal->store_result();
	$counttotal->fetch();
	$displayrowstart=$rowstart+1;
	$displayrowend=($rowstart+$rowcount)>$totalrows?$totalrows:($rowstart+$rowcount);
		echo "<footer><p>Showing results $displayrowstart to $displayrowend of $totalrows</p><p>";
			if ($rowstart>0) {
				$newrowstart=(($rowstart-$rowcount)<0)?0:$rowstart-$rowcount;
					echo "<a href='admin_stock_select.php?f=$newrowstart&n=$rowcount'>&lt;&lt;Previous</a>";
				}
			if ($rowstart>0 && ($rowcount+$rowstart)<$totalrows) {
					echo " - ";
				}
			if (($rowcount+$rowstart)<$totalrows) {
				$newrowstart=(($rowstart+$rowcount)>=$totalrows)?$rowstart:$rowstart+$rowcount;
					echo "<a href='admin_stock_select.php?f=$newrowstart&n=$rowcount'>Next&gt;&gt;</a>";
				}
		echo "</p></footer>";

	$counttotal->close();
	$db->close();
?>
			
	

</div>
</div>


<!--\\\\\\\\\\\\\\\\\\\\\///////////////////////////////\\\\\\\\\\\\\\\\/////////\\\\\\ -->



  </body>
</html>



