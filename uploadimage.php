
<!DOCTYPE html>
<html>
 <head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  
      <title>Upload Image</title>
	  
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
	  <h3 class="h4_user_inactive">Upload Image</h3>
	
<?php

$updest='../Project Files/img/'; //Sets the relative path to the uploads folder
$displaypath="uploads/"; //Sets the path to the uploads folder for use on the web page
$allowedExts = array("jpg", "jpeg", "gif", "png"); //Allowed image file extensions
$timestamp=time(); //The time of upload is used to ensure that filenames are unique, this way
// two files called 'myfile.jpg' can be uploaded but still have unique names as they would
// have different timestamps
$tempFileName=$_FILES['imagefile']['tmp_name']; //This finds the temporary location 
// where the file was uploaded to
$permFileName=$updest.$timestamp.$_FILES['imagefile']['name']; //The uploads folder and filename
// that the file will be stored in permanently
$displayName=$displaypath.$timestamp.$_FILES['imagefile']['name']; //The display path for the page
$uploadFileType=$_FILES['imagefile']['type']; //The filetype of the uploaded image (not extension)
$uploadFileSize=$_FILES["imagefile"]["size"]; //The size in bytes of the uploaded image



echo 'Uploaded Image <br />';
$extension = end(explode(".", $permFileName)); //Finds the extension of the uploaded file
if ((($uploadFileType == "image/gif")
|| ($uploadFileType == "image/jpeg")
|| ($uploadFileType == "image/png")
|| ($uploadFileType == "image/pjpeg"))
&& ($uploadFileSize < 8000000)
&& in_array($extension, $allowedExts)) //The if statement ensures the uploaded file is of the
//correct type, no bigger than 8Mb and has the correct type of file extension
{
	echo "Upload: " . $permFileName . "<br />"; //These echo statements just output a little 
	echo "Type: " . $uploadFileType . "<br />"; //information about the uploaded file
	echo "Size: " . ($uploadFileSize / 1024) . " Kb<br />";
	echo "Temp file: " . $tempFileName . "<br />";
	
}
else
{
	echo "Invalid file";
}
	

?>
  
<a href="addstockitem.php">Upload another image</a>


	
	
</div>
</div>
</div>


<!--\\\\\\\\\\\\\\\\\\\\\///////////////////////////////\\\\\\\\\\\\\\\\/////////\\\\\\ -->


	
  </body>
</html>




























