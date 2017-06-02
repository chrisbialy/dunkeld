<?php
	session_start();
	include("functions.php");
	$username=checkUser($_SESSION['userid'],session_id(),3);
	$currentuser=getUserLevel();
		$db=createConnection();
		
		
		$id=$_POST['id'];
		$product_code=$_POST['product_code'];
		$product_name=$_POST['product_name'];
		$product_desc=$_POST['product_desc'];
		$product_img_name=$_POST['product_img_name'];
		$price=$_POST['price'];
		$stockqty=$_POST['stockqty'];
		
	//	
		$updateusersql="UPDATE stock SET product_code=?, product_name=?, product_desc=?, product_img_name=?, price=?, stockqty=? where id=?;";
		$updateuser=$db->prepare($updateusersql);
		$updateuser->bind_param("ssssiii",$product_code,$product_name,$product_desc,$product_img_name,$price,$stockqty,$id);
		$updateuser->execute();
		$updateuser->close();
		$db->close();
	
	header("location: ../loged.php");
?>
