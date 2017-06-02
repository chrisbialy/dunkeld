<?php
/*
Although the session can be started later it is useful
to start it at the beginning of the page. The session must
be started on each page that is part of the members area
for the logins to function appropriately.
session_regenerate_id() is used to ensure a new sessionid
is created for each person on each visit to the login page
Sessions do NOT work on HTML pages, just php pages.
*/
session_start();
session_regenerate_id();
?>
<!doctype html>
<html lang="en-gb" dir="ltr">
<head>
</head>
<body>
<?php
include('functions.php');
//Check that both a user name and user password have been set
if(isset($_POST['username']) && isset($_POST['userpass'])){ 
	$db=createConnection();
	//Assign POSTed values to variables
	$username=$_POST['username'];
	$userpass=$_POST['userpass'];
	//Create query, note that parameters being passed in are represented by question marks
	$loginsql="select userid, userpass, salt, firstname, surname, usertype from customer where username=?";
	$lgnstmt = $db->prepare($loginsql);
	//Bound parameters are defined by type, s = string, i = integer, d = double and b = blob
	$lgnstmt->bind_param("s",$username);
	//Run query
	$lgnstmt->execute();
	//Store Query Result
	$lgnstmt->store_result();
	//Bind returned row parameters in same order as they appear in query
	$lgnstmt->bind_result($userid,$hash,$salt,$firstname,$surname,$usertype);
	//Valid login only if exactly one row returned, otherwise something iffy is going on
	if($lgnstmt->num_rows==1) {
		//Fetch the next (it should be only) row from the returned results
		$lgnstmt->fetch();
		$cyphertext=makeHash($userpass,$salt,50);
		$lgnstmt->close();
		if($cyphertext==$hash) {
			//Update user's record with session data
			$sessionsql="update customer set sessionid=? where userid=?";
			$sessionstmt=$db->prepare($sessionsql);
			$sessionstmt->bind_param("si",session_id(),$userid);
			$sessionstmt->execute();
			$sessionstmt->close();
			// Store logged in userid as session variable
			$_SESSION['userid']=$userid;
			if($usertype>0) {
				header("location: ../loged.php");
			} else {
				header("location: logout.php");
			}

		} else {
		header("location: ../loged.php");
		exit();
		}
	} else {
		header("location: ../loged.php");
		exit();
	}
	$db->close();	
	
} else {
	header("location: ../loged.php");
	exit();
}
?>
</body>
</html>
