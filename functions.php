<?php
	require("../../config.php");
	//functions.php

	/*
	$nimi = "Krister";
	$perenimi = "Tarnamaa";
	function sum($x, $y) {
		
		return $x + $y;
		
	}
	
	echo sum(12312312,12312355553);
	echo "<br><br>";

	
	function tere($nimi, $perenimi) {
		return "Tere tulemast ".$nimi." ".$perenimi."!";
	}
	//echo "Tere tulemast: ".$nimi." ".$perenimi;
	echo tere("mina", "sina");
	*/
	//see fail peab olema siis seotud kõigiga, kus tahame sessiooni kasutada
	//saab kasutada nüüd $_SESSION muutujat.
	session_start();
	
	$database = "if16_kristarn";
	$mysqli = new mysqli($serverHost, $serverUsername, $serverPassword, $database);
	
	require("User.class.php");
	$User = new User($mysqli);
	
	require("Event.class.php");
	$Event = new Event($mysqli);
	

	
			function cleanInput($input) {
				
				// input = "  mina  "
				$input = trim($input);
				// input = "mina"
				
				//võtab välja \ tähemärgid
				$input = stripslashes($input);
				
				// html asendab ">" &gt -iga
				$input = htmlspecialchars($input);
				
				//otsib välja $inputis ";" ja kui on olemas muudab inputi "jamaks", mis ei lase lauset läbi.
				if (strpos($input, ';') > -1) {
				
				$input = "jama";
				
				return $input;
				
				} else {
				
				return $input;
				
				}
				
				
				
			}
	

			
	
	?>