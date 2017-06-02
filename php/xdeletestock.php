<?php
	session_start();
	include("functions.php");
	$username=checkUser($_SESSION['userid'],session_id(),2);
	$currentuser=getUserLevel();
	$id=$_POST['id'];
	if(!$id) { header("location: ../index.html"); exit();}

	$db=createConnection();
	// get the first two articles
	$sql = "select id from stock where id=?";
	$stmt = $db->prepare($sql);
	$stmt->bind_param("i",$id);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($id,$id);
	if($stmt->num_rows==1) {
		$stmt->fetch();
		if($currentuser['userlevel']>2 || ($currentuser['userid']==$userid && $currentuser['userlevel']>1)) {
			$deletesql="delete from stock where id=?;";
			$deletestmt=$db->prepare($deletesql);
			$deletestmt->bind_param("i",$id);
			$deletestmt->execute();
		}
		
	}
	$stmt->close();
	$deletestmt->close();
	$db->close();
	header("location: ../loged.php");
?>
