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
	$usertoedit=$_GET['usertoedit'];
?>

<!DOCTYPE html>
<html>
 <head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  
      <title>Admin Edit Users</title>
	  
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
	  <h3 class="h4_user_inactive">Edit Users</h3>
	
	<ul>
		<?php if($currentuser['userlevel']>1) { ?>
		<li><a href="user.php" class="button">Account Panel</a></li>
		<br>
			<?php if($currentuser['userlevel']>2) { ?>
			<?php } ?>
		<?php } ?>
		<li><a href="php/logout.php" class="button">Log Out</a></li>
		<br>
	</ul>

<section id="main">
<?php
	$db=createConnection();
	// get user data
	$sql = "select userid, username,firstname,surname,dob,emailadd,usertype from customer where userid=?";
	$stmt = $db->prepare($sql);
	$stmt->bind_param("i",$usertoedit);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($editid,$username,$firstname,$surname,$dob,$emailadd,$userslevel);

	while($stmt->fetch()) {

		// if user is logged in and not suspended add comment button
			if($currentuser['userlevel']==3) {
			?> 
		
		<form method="post" action="php/xedit_users.php">
		<fieldset><legend>Edit User</legend>
			<input type="hidden" readonly value="<?php echo $userid; ?>" id="userid" name="userid" />
			<label for="username"></label><input type="text" placeholder="Username" name="username" id="username" size="30" class="margin" required value="<?php echo $username; ?>"/></textarea><br />
			<br>
			<label for="firstname"></label><input type ="text" name="firstname" placeholder="Firstname" id="firstname" size="30"  value="<?php echo $firstname; ?>" class="margin"  /><br />
			<br>
			<label for="surname"></label><input type="text" name="surname" placeholder="Surname" id="surname" size="30" value="<?php echo $surname; ?>" class="margin"/><br />
			<br>
			<label for="dob"></label><input type="date" name="dob" id="dob" placeholder="Dob" value="<?php echo $dob; ?>" class="margin"/><br />
			<br>
			<label for="emailadd"></label><input type="email" name="emailadd" placeholder="Email" id="emailadd" size="30" value="<?php echo $emailadd; ?>"class="margin" /><br />
			<br>
			<label for="level">Level: </label>
				<select name="userlevel" id="userlevel" style="max-width:15%;" class="select">
					<option value="3"<?php if($userslevel==3) { echo " selected"; }?>>Admin</option>
					<option value="2"<?php if($userslevel==2) { echo " selected"; }?>>User</option>
					<option value="1"<?php if($userslevel==1) { echo " selected"; }?>>Suspended</option>
				</select>
				<br>
				<br>
			<button type="reset">Reset</button><button type="submit">Submit</button>
		</fieldset>
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
</div>


<!--\\\\\\\\\\\\\\\\\\\\\///////////////////////////////\\\\\\\\\\\\\\\\/////////\\\\\\ -->


	
  </body>
</html>




























