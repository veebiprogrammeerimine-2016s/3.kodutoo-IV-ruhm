<?php

	require("../../config.php");
	session_start();
	
	$database = "if16_ksenbelo_4";

	//REGISTREERIMINE
	function registration($email, $password, $nickname, $gender) {
		
		$mysqli = new mysqli($GLOBALS["serverHost"],
		$GLOBALS["serverUsername"],
		$GLOBALS["serverPassword"],
		$GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO 3user_food (epost, password, username,gender) VALUE (?, ?, ?, ?)");
		echo $mysqli->error;
		$stmt->bind_param("ssss",$email, $password, $nickname, $gender);
		
		if ( $stmt->execute() ) {
			echo "õnnestus";
		} else {
			echo "ERROR ".$stmt->error;
		}	
	}
	
	//LOOGIMINE SISSE
	function login($email,$password) {
		
		$error = "";
		$mysqli = new mysqli($GLOBALS["serverHost"],
		$GLOBALS["serverUsername"],
		$GLOBALS["serverPassword"],
		$GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("
		SELECT id, epost, password
		FROM 3user_food
		WHERE epost = ?
		");
		
		echo $mysqli->error;
		
		$stmt->bind_param("s", $email);
		$stmt->bind_result($id, $emailFromDb, $passwordFromDb);
		$stmt->execute();
		
		if($stmt->fetch()) {
			$hash = hash("sha512", $password);
		
		if ($hash == $passwordFromDb) {
			echo "Kasutaja $id logis sisse";
			$_SESSION["userId"] = $id;
			$_SESSION["userEmail"] = $emailFromDb;
			header("Location: HOME_page.php");
		} else {
			$error = "parool vale";
			}	
		} else {
			$error = "Sellise emailiga ".$email." kasutajat ei ole olemas";
		}
		
		return $error;
	}
	
	//KASUTAJA TABEL
	function profile(){
		
		$mysqli = new mysqli($GLOBALS["serverHost"], 
		$GLOBALS["serverUsername"], 
		$GLOBALS["serverPassword"], 
		$GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("
		SELECT id, epost, password, gender, username, avatar
		FROM 3user_food
		");
		
		$stmt->bind_result($id, $email, $password, $gender, $nickname, $avatar);
		$stmt->execute();
		$results = array();
		
		while ($stmt->fetch()) {
			
			$human = new StdClass();
			$human->id = $id;
			$human->email = $email;
			$human->gender = $gender;
			$human->nickname = $nickname;
			$human->avatar = $avatar;
			
			array_push($results, $human);	
		}
		
		return $results;
	}
	
	function cleanInput($input) {
		$input = trim($input);
		$input = stripslashes($input);
		$input = htmlspecialchars($input);
		return $input;
	}

?>