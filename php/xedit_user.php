<?php
	session_start();
	include("functions.php");
	$username=checkUser($_SESSION['userid'],session_id(),2);
	$currentuser=getUserLevel();
		$db=createConnection();
	$userid=$_POST['userid'];
	if($currentuser['userlevel']>2 || ($currentuser['userid']==$userid && $currentuser['userlevel']>1)) {

	// 	$username=$_POST['username'];
		$firstname=$_POST['firstname'];
		$surname=$_POST['surname'];
		$dob=$_POST['dob'];
		$emailadd=$_POST['emailadd'];
	//	
		$updateusersql="UPDATE customer SET firstname=?, surname=?, dob=?, emailadd=? where userid=?;";
		$updateuser=$db->prepare($updateusersql);
		$updateuser->bind_param("ssssi",$firstname,$surname,$dob,$emailadd,$userid);
		$updateuser->execute();
		$updateuser->close();
		$db->close();
	}
	header("location: ../loged.php");
?>
