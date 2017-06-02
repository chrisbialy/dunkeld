<!doctype html>
<html lang="en-gb" dir="ltr">
<head>

</head>
<body>
<?php
include("php/functions.php");
$username=$_POST['username'];
$firstname=$_POST['firstname'];
$surname=$_POST['surname'];
$emailadd=$_POST['emailadd'];
$dob=$_POST['dob'];
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
$birthday=mktime(0, 0, 0, substr($dob,5,2), substr($dob,8,2), substr($dob,0,4));
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
	<header>
		<h1>Your Registration Details</h1>
	</header>
	<p>Welcome <?php echo $firstname." ".$surname; ?></p>
	<p>You can now login with your username <em><?php echo $username; ?></em></p>
	<section>
	<form name="login" id="login" method="post" action="php/processlogin.php">
		<fieldset><legend>Login</legend>
		<p><label for="username">Username</label><input type="text" name="username" id="username" required value="<?php echo $username; ?>"/></p>
		<p><label for="userpass">Password</label><input type="password" name="userpass" id="userpass" required /></p>
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
		<header>
			<h1>Registration failed</h1>
		</header>
		<?php 
		if($emailexists){ echo "<p>The email address $emailadd already exists.</p>"; }
		if($userexists){ echo "<p>The username $username already exists.</p>"; }
		if($userpass!=$secondpass){ echo "<p>The passwords do not match.</p>"; }
		if(!filter_var($emailadd, FILTER_VALIDATE_EMAIL)){ echo "<p>The email address is invalid.</p>"; }
		?>
		<p>You need to return to the registration page and try again</p>
<?php 
}
$stmt->close();
$inst->close();
$db->close(); 
?>
<p>Return to the <a href="index.html">home</a> page.</p>
</body>
</html>
