<!DOCTYPE html>
<html lang="en-gb" dir="ltr">
 <head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  
      <title>Register</title>
	  
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
  	
    <div class="container background_main_banner ">
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
	  
      <div class="row feature hidden">
        <div class="large-5 column ">
		<h1>Dunkeld Wildlife Photo Society.</h1>
	
        </div>
      </div>
	  
    </div>
  <!-- Register -->
  <div class="container-spacy background-white background-black2 h2_extra recent ">
   <h2>Login</h2>
		<div class="center_fieldset">
		
	<?php
	include("php/functions.php");
	$username=$_POST['username'];
	$firstname=$_POST['firstname'];
	$surname=$_POST['surname'];
	$emailadd=$_POST['emailadd'];
	$dayob=$_POST['dayob'];
	$monthob=$_POST['monthob'];
	$yearob=$_POST['yearob'];
	$dob=$yearob."-".$monthob."-".$dayob;

	$userpass=$_POST['userpass'];
	$secondpass=$_POST['secondpass'];
	$tnc=(isset($_POST['tnc'])?1:0);
	$salt=getSalt(16);
	$cryptpass=makeHash($userpass,$salt,50);
	
	// Used to check that submitted user does not exist already
	
	$userexists=false;
	$emailexists=false;
	
	// connect to database
	
	$db = createConnection();
	
	// check form details again in case javascript disabled form bypassed
	// javascript client side scripting
	// check username and email do not already exist
	
	$sql="select username,emailadd from customer where username=? or emailadd=?;";
	$stmt=$db->prepare($sql);
	$stmt->bind_param("ss",$username,$emailadd);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($userresult,$emailresult);
	while($row=$stmt->fetch()) {
		if($userresult==$username) {$userexists=true;}
		if($emailresult==$email) {$emailexists=true;}
	}
	// check user is old enough, in this example users must be 16
	
	$latestbirthday=mktime(0, 0, 0,date("m"),date("d"),date("Y")-16); // the last value controls min age
	$birthday=mktime(0, 0, 0, $monthob, $dayob, $yearob);
	$validage=(($birthday-$latestbirthday)>0?false:true);
	// Check submitted and calculated variables before storing
	
	if(!$userexists && !$emailexists && $userpass==$secondpass && isset($userpass) && filter_var($emailadd, FILTER_VALIDATE_EMAIL) && $tnc && isset($firstname) && isset($surname) && $validage) {

	// insert new user
	
		$insertquery="insert into customer (username, firstname, surname, emailadd, dob, usertype, tnc, salt, userpass) values (?,?,?,?,?,2,?,?,?);";
		$inst=$db->prepare($insertquery);
		$inst->bind_param("sssssiss", $username, $firstname, $surname, $emailadd, $dob, $tnc, $salt, $cryptpass);
		$inst->execute();
		
	// check user inserted, if so create login form
	
		if($inst->affected_rows==1) {
	
	?>
	
	<h1>Welcome:  <?php echo $firstname." ".$surname; ?></h1>
	<br>
	<p>You can now login with your username <em><?php echo $username; ?></em></p>
	<br>
	<section>
	
	<form name="login" id="login" method="post" action="php/processlogin.php">
		<fieldset><legend>Login</legend>
		<p><label for="username">Username: </label><input type="text" name="username" id="username" required value="<?php echo $username; ?>"/></p>
		<p><label for="userpass">Password: </label><input type="password" name="userpass" id="userpass" required /></p>
		<button type="submit" id="submit">Login</button>
		</fieldset>
	</form>
	
	
	</section>
<?php } else { 
		//feedback there was a problem adding the user
		echo "<p>There was a problem adding your details. Please contact the website administrators</p>"; 
		}
} else { 
// registration failed either due to disabled javascript or other attempt to bypass validation
?>
		
		<?php 
		if($emailexists){ echo "<p>The email address $emailadd already exists.</p>"; }
		if($userexists){ echo "<p>The username $username already exists.</p>"; }
		if($userpass!=$secondpass){ echo "<p>The passwords do not match.</p>"; }
		if(!filter_var($emailadd, FILTER_VALIDATE_EMAIL)){ echo "<p>The email address is invalid.</p>"; }
		?>
		<p>You need to return to the registration page and try again</p>
		<a href="register.html"class="button button-primary "><span>Register</span></a>
<?php 
}
	$stmt->close();
	$inst->close();
	$db->close(); 
?>
	<ul>
		<li><a href="index.html" class="button">Home</a></li>
	</ul>
		
        <div class="large-4 column">
			
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
            <li><a href="#">Shop</a></li>
            <li><a href="photo_tips.html">Photo Tips</a></li>
            <li><a href="about.html">About</a></li>
			<li><a href="#">Basket</a></li>
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
	
	
	
  </body>
<script src="js/functions.js"></script>
<script src="js/touch.js"></script>
</html>