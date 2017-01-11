<?php

	//See fail peab olema seotud kõigiga, kus tahame sessiooni kasutada
	//Saab kasutada nüüd $_SESSION muutujat
	session_start();
	$database = "if16_stivsire_4";
	//function.php
	
	function signup($email, $password) {
	
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO user_sample (email, password) VALUE (?, ?)");
		echo $mysqli->error;
		
		//asendan küsimärgid
		//iga märgi kohta tuleb lisada üks täht ehk mis tüüpi muutuja on
		// s - string
		// i - interface_exists
		// d - double
		$stmt->bind_param("ss", $email, $password);
		
		if($stmt->execute()) {
			echo "õnnestus";
		} else {
			echo "ERROR".$stmt->error;
		}
	}
	
	
	function signup2($email, $password, $gender, $signupBday) {
	
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO userDb (email, password, gender, bday) VALUE (?, ?, ?, ?)");
		echo $mysqli->error;
		
		//asendan küsimärgid
		//iga märgi kohta tuleb lisada üks täht ehk mis tüüpi muutuja on
		// s - string
		// i - interface_exists
		// d - double
		$stmt->bind_param("ssss", $email, $password, $gender, $signupBday);
		
		if($stmt->execute()) {
			echo "õnnestus";
		} else {
			echo "ERROR".$stmt->error;
		}
		
	}
	
	
	function login($email, $password) {
		
		$notice = "";
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT id, email, password, gender, bday FROM userDb WHERE email = ?");
		echo $mysqli->error;
		
		//asendan küsimärgi
		$stmt->bind_param("s", $email);
		
		//rea kohta tulba väärtus
		$stmt->bind_result($id, $emailFromDb, $passwordFromDb, $gender, $signupBday);
		
		$stmt->execute();
		
		//fetch on ainult SELECTi puhul
		if($stmt->fetch()) {
			//oli olemas, rida käes
			//kasutaja sisestas sisse logimiseks
			$hash = hash("sha512", $password);
			
			if($hash == $passwordFromDb) {
				echo "Kasutaja $id logis sisse";
				
				$_SESSION["userId"] = $id;
				$_SESSION["userEmail"] = $emailFromDb;
				
				header("Location: data.php");
				
			} else {
				$notice =  "parool on vale";
			}
			
		} else {
			//ei olnud ühtegi rida
			$notice = "Sellise emailiga $email kasutajat ei ole olemas";
		}
		
		return $notice;
		
	}
	
	function tabelisse($age, $color) {
	
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	
	$stmt = $mysqli->prepare("INSERT INTO whistle (age, color) VALUE (?, ?)");
	echo $mysqli->error;
	
	//asendan küsimärgi
	$stmt->bind_param("is", $age, $color);
	
	if($stmt->execute()) {
			echo "õnnestus";
		} else {
			echo "ERROR".$stmt->error;
		}
	

	}
	
	function tabelisse2($food, $kcal, $day) {
	
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	
	$stmt = $mysqli->prepare("INSERT INTO toidud (food, kcal, day) VALUE (?, ?, ?)");
	echo $mysqli->error;
	$stmt->bind_param("sis", $food, $kcal, $day);
	
	if($stmt->execute()) {
			echo "Sissekanne lisatud";
		} else {
			echo "ERROR".$stmt->error;
		}
	}
	
	function getAllPeople() {
	
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("
			SELECT id, age, color FROM whistle
		
		");
		$stmt->bind_result($id, $age, $color);
		$stmt->execute();
		
		$results = array();
		
		//tsükli sisu tehakse nii mitu korda, mitu rida SQL lausega tuleb
		while($stmt->fetch()) {
			
			$human = new StdClass();
			$human->id = $id;
			$human->age = $age;
			$human->lightColor = $color;
	
			
			//echo $color."<br>";
			array_push($results, $human);
			
		}
		
		return $results;
		
	}
	
	
	function getAllFoods() {
	
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT id, food, kcal, day FROM toidud WHERE archive=0");
		$stmt->bind_result($id, $food, $kcal, $day);
		$stmt->execute();
		
		$results = array();
		
		//tsükli sisu tehakse nii mitu korda, mitu rida SQL lausega tuleb
		while($stmt->fetch()) {
			
			$toit = new StdClass();
			$toit->id = $id;
			$toit->food = $food;
			$toit->kcal = $kcal;
			$toit->day = $day;
	
			
			//echo $color."<br>";
			array_push($results, $toit);
			
		}
		
		return $results;
		
	}
	
	function getSearchedFoods($search) {
	
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT id, food, kcal, day FROM toidud WHERE food=? AND archive=0");
		$stmt->bind_param("s", $search);
		$stmt->bind_result($id, $food, $kcal, $day);
		$stmt->execute();
		
		$results = array();
		
		//tsükli sisu tehakse nii mitu korda, mitu rida SQL lausega tuleb
		while($stmt->fetch()) {
			
			$toit = new StdClass();
			$toit->id = $id;
			$toit->food = $food;
			$toit->kcal = $kcal;
			$toit->day = $day;
	
			
			//echo $color."<br>";
			array_push($results, $toit);
			
		}
		
		return $results;
		
	}
	
	function archiveFood($archiveId) {
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("UPDATE toidud SET archive=1 WHERE id=?");
		echo $mysqli->error;
		$stmt->bind_param("i", $archiveId);
		
		if($stmt->execute()) {
				echo "Arhiveeritud";
			} else {
				echo "ERROR".$stmt->error;
			}
	}
	
	function getArchivedFoods() {
	
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT id, food, kcal, day FROM toidud WHERE archive=1");
		$stmt->bind_result($id, $food, $kcal, $day);
		$stmt->execute();
		
		$results = array();
		
		//tsükli sisu tehakse nii mitu korda, mitu rida SQL lausega tuleb
		while($stmt->fetch()) {
			
			$toit = new StdClass();
			$toit->id = $id;
			$toit->food = $food;
			$toit->kcal = $kcal;
			$toit->day = $day;
	
			
			//echo $color."<br>";
			array_push($results, $toit);
			
		}
		
		return $results;
		
	}
	/*function hello($x, $y) {
		
		return "Tere tulemast, " .ucfirst($x)." ".ucfirst($y);
		
	}
	
	echo hello("stivo", "s");
	*/
?>