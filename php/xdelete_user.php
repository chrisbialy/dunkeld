<?php
	session_start();
	include("functions.php");
	$username=checkUser($_SESSION['userid'],session_id(),2);
	$currentuser=getUserLevel();
	$userid=$_POST['userid'];
	if(!$userid) { header("location: ../index.html"); exit();}

	$db=createConnection();
	// get the first two articles
	$sql = "select userid from customer where userid=?";
	$stmt = $db->prepare($sql);
	$stmt->bind_param("i",$userid);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($userid,$userid);
	if($stmt->num_rows==1) {
		$stmt->fetch();
		if($currentuser['userlevel']>2 || ($currentuser['userid']==$userid && $currentuser['userlevel']>1)) {
			$deletesql="delete from customer where userid=?;";
			$deletestmt=$db->prepare($deletesql);
			$deletestmt->bind_param("i",$userid);
			$deletestmt->execute();
		}
		
	}
	$stmt->close();
	$deletestmt->close();
	$db->close();
	header("location: ../loged.php");
?>
