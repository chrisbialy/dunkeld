<?php
	session_start();
?>
<!DOCTYPE html>
<html lang="en-gb" dir="ltr">
 <head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  
      <title>Login</title>
	  
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
		  
		     <nav id="main">
		<div id="cssmenu" class="">
          <ul>
			
          </ul>
		  </div>
		  </nav>
      
      </header>
	  
      <div class="row feature feature_small">
        <div class="large-5 column ">
		<h1 class="hidden_small">Dunkeld Wildlife Photo Society.</h1>
	
        </div>
      </div>
	  
    </div>
  <!-- Login -->
  <div class="container-spacy background-white background-black2 h2_extra recent ">
   
		<div class="center_fieldset">
		<div class="row ">
			<form name="loginform" id="loginform" method="post" action="php/processlogin.php">
			<fieldset>
				<legend>Login Details</legend>
					<label for="username"> </legend><input type="text" placeholder="Username"  name="username" id="username" size="10" class="margin" required /><br />
				<br>
					<label for="userpass"></legend><input type="password" placeholder="Password" name="userpass" id="userpass" size="10" class="margin" required /><br />
				<br>
					<button type="submit">Login</button>
					<br>
					
			</fieldset>
			<br>
			 <a href="register.html"class="button button-primary "><span>Register</span></a>
			</form>
		
        <div class="large-4 column">
		 
        </div>
     
		</div>
	 </div>
	   </div>
 
    <div class=" background-grey  recent">
      <h3>More Info</h3>
		<div class="row ">
	  
		  <!--  Camera  -->
			
			<div class="large-4 column">
			<img src="img/camera3.png" class="img_more_i" alt="">
			</div>
			 
			<!-- Contact Us -->
				
			
			<div class="large-4 column">
			<img src="img/address2.png" class="img_more_i" alt="">
			</div>
			
			   <!--  Location  -->
			
			<div class="large-4 column">
			<img src="img/loc2.png" class="img_more_i" alt="">
			</div>
		  
		</div>
	</div>
	


		<!-- Copyright , Payment, Terms etc.. -->
		
	 <div class="container_Copyright ">
		
		<section>
		<h1>See the latest photo exhibition</h1>
		<p class="sub-title">Perth and Kinross</p>
		<p><a class="button_banner" id="load-more-content" href="#top">Book Now</a></p>
		<section>
		</div>
	
	

		<!-- Bottom Menu Wide, Medium -->
	
	<footer class="hidden">
	<nav>
	  <div class="container-bottom features">
      <div class="row">
       <div class="recent">
			<ul class="inline-list">
			<li class="selected"><a href="index.html">Home</a></li>
            <li><a href="gallery.html">Gallery</a></li>
            <li><a href="shop.php">Shop</a></li>
            <li><a href="photo_tips.html">Photo Tips</a></li>
            <li><a href="about.html">About</a></li>
			<li><a href="view_cart.php">Basket</a></li>
			</ul>
		</div>
	<hr>
		<span class="">Copyright &copy; Krzysztof Bialy </span>
		<a href="#"><img src="img/facebook_logo_black_50.png" alt="" class="fb_logo_black fb_logo_margin " 
		onmouseover="this.src='img/facebook_logo_white_50.png'" 
		onmouseout="this.src='img/facebook_logo_black_50.png'"/>
		</a>
		</nav>
		</footer>
		
		<!-- Footer Narrow -->
		
		<footer class="hidden_footer">
		<a href="#"><img src="img/facebook_logo_black_50.png" alt="" class="fb_logo_black " 
		onmouseover="this.src='img/facebook_logo_white_50.png'" 
		onmouseout="this.src='img/facebook_logo_black_50.png'"/>
		</a>
		<span>Copyright &copy; Krzysztof Bialy </span>
		</footer>
		
      </div>
    </div>
	
	
	<script src="js/functions.js"></script>
  </body>
</html>