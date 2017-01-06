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
			echo "succeeded";
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
		SELECT epost, username, gender
		FROM 3user_food
		WHERE epost = ?
		");
		
		$stmt->bind_param("s", $_SESSION["userEmail"]);
		$stmt->bind_result($email, $nickname,$gender);
		$stmt->execute();
		$results = array();
		
		while ($stmt->fetch()) {
			$human = new StdClass();
			$human->email = $email;
			$human->nickname = $nickname;
			$human->gender = $gender;
			array_push($results, $human);	
		}
		
		return $results;
	}
	
	//CleanInput
	function cleanInput($input) {
		$input = trim($input);
		$input = stripslashes($input);
		$input = htmlspecialchars($input);
		return $input;
	}
	
	//KASUTAJA NIMI UUENDAMINE
	function updatePerson($nickname){
		$mysqli = new mysqli($GLOBALS["serverHost"],
		$GLOBALS["serverUsername"],
		$GLOBALS["serverPassword"],
		$GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("UPDATE 3user_food SET username=? WHERE id=?");
		$stmt->bind_param("si", $nickname, $_SESSION["userId"]);

		if($stmt->execute()){
			echo "salvestus onnestus!";
		}
		$stmt->close();
		$mysqli->close();	
	}
	
	//TAGASISIDE
	function comment($restname, $feedback, $rating) {	
		$mysqli = new mysqli($GLOBALS["serverHost"],
		$GLOBALS["serverUsername"],
		$GLOBALS["serverPassword"],
		$GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO 3user_food_rest (kasutaja, restname, feedback, rating) VALUE (?, ?, ?, ?)");
		echo $mysqli->error;
		$stmt->bind_param("ssss",$_SESSION["userEmail"], $restname, $feedback, $rating);
		
		if ( $stmt->execute() ) {
		} else {
			echo "ERROR ".$stmt->error;
		}	
	}
	
	//TAGASIDE TABEL
	function restaraunt($q, $sort, $order){
		
		$mysqli = new mysqli($GLOBALS["serverHost"], 
		$GLOBALS["serverUsername"], 
		$GLOBALS["serverPassword"], 
		$GLOBALS["database"]);
		
		$allowedSort = ["kasutaja", "restname", "feedback", "rating"];
		
		if(!in_array($sort, $allowedSort)){
			$sort = "kasutaja";}
		
		$orderBy = "ASC";	
		
		if($order == "DESC"){
			$orderBy = "DESC";}
		
			
		//OTSING
		if ($q != "") {
		$stmt = $mysqli->prepare("
			SELECT kasutaja, restname, feedback, rating
			FROM 3user_food_rest
			WHERE restname LIKE ? 
			OR feedback LIKE ?
			OR rating LIKE ?
			OR kasutaja LIKE ?
			ORDER BY $sort $orderBy
			");
			
		$searchWord = "%".$q."%";
		$stmt->bind_param("ssss", $searchWord, $searchWord, $searchWord, $searchWord );
		
		} else {
		//otsing ei toimu
		$stmt = $mysqli->prepare("
			SELECT kasutaja, restname, feedback, rating 
			FROM 3user_food_rest
			ORDER BY $sort $orderBy
			");
		}
		
		$stmt->bind_result($email, $restname, $feedback, $rating);
		$stmt->execute();
		$results = array();
		
		while ($stmt->fetch()) {
			$human = new StdClass();
			$human->kasutaja = $email;
			$human->restname = $restname;
			$human->feedback = $feedback;
			$human->rating =  $rating;
			array_push($results, $human);	
		}
		
		return $results;
	}
?>