<?php
	session_start();
	include("functions.php");
	/*Checking username, session id and user level - ensure security*/
	$username=checkUser($_SESSION['userid'],session_id(),2);
	$currentuser=getUserLevel();
	$db=createConnection();

		$product_code=$_POST['product_code'];
		$product_name=$_POST['product_name'];
		$product_desc=$_POST['product_desc'];
		$product_img_name=$_POST['product_img_name'];
		$price=$_POST['price'];
		$stockqty=$_POST['stockqty'];
	
	
	$insertitemsql="insert into stock (product_code,product_name,product_desc,product_img_name,price,stockqty) values (?,?,?,?,?,?)";
	$insertitem=$db->prepare($insertitemsql);
	$insertitem->bind_param("ssssii",$product_code,$product_name,$product_desc,$product_img_name,$price,$stockqty);
	$insertitem->execute();
	$insertitem->close();
	$db->close();
	header("location: ../loged.php");
?>