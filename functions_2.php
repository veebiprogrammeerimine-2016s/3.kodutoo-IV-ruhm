<?php 

require ("../../config.php");

session_start();
$database = "if16_thetloff";

$mysqli = new mysqli(
		$serverHost, 
		$serverUsername, 
		$serverPassword, 
		$database);


 ?>