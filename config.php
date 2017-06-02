<?php
$currency = '&#163; '; //Currency Character or code

$db_username = 'pe14002792';
$db_password = '16051994';
$db_name = 'pe14002792';
$db_host = 'comp-hons.uhi.ac.uk';

$shipping_cost      = 1.50; //shipping cost
$taxes              = array( //List your Taxes percent here.
                            'VAT' => 12, 
                            'Service Tax' => 5
                            );						
//connect to MySql						
$mysqli = new mysqli($db_host, $db_username, $db_password,$db_name);						
if ($mysqli->connect_error) {
    die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
}
?>