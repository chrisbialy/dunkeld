<?php
	session_start();
	include("functions.php");
	$username=checkUser($_SESSION['userid'],session_id(),3);
	$currentuser=getUserLevel();
		$db=createConnection();
		
		if(isset($_POST['userlevel'])){ 

		$userid=$_POST['userid'];
		$username=$_POST['username'];
		$firstname=$_POST['firstname'];
		$surname=$_POST['surname'];
		$dob=$_POST['dob'];
		$emailadd=$_POST['emailadd'];
		$usertype=$_POST['userlevel'];
		
	//	
		$updateusersql="UPDATE customer SET username=?, firstname=?, surname=?, dob=?, emailadd=?, usertype=? where userid=?;";
		$updateuser=$db->prepare($updateusersql);
		$updateuser->bind_param("sssssii",$username,$firstname,$surname,$dob,$emailadd,$usertype,$userid);
		$updateuser->execute();
		$updateuser->close();
		$db->close();
		}
	header("location: ../loged.php");
?>
