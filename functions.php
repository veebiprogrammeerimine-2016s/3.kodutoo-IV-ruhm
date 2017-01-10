<?php

require_once("../../config.php");
//see fail peab olema kõigil lehtedel, kus tahan kasutada session muutujat

session_start();

function signUp($signupUsername, $password, $signupEmail, $signupFirstName, $signupLastName, $signupGender) {
	//echo $serverUsername;
	//Ühendus
	$database = "if16_andrkalj_4";

		$mysqli = new mysqli ($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);

		// mysqli rida
		$stmt = $mysqli->prepare("INSERT INTO project_user (username, password, email, firstname, lastname, gender) VALUES (?, ?, ?, ?, ?, ?)");
		echo $mysqli->error;
		// stringina üks täht iga muutuja kohta (?), mis t??t
		// string - s
		// integer - i
		// float (double) - d
		// küsimärgid asendada muutujaga
		$stmt->bind_param("ssssss",$signupUsername, $password, $signupEmail, $signupFirstName, $signupLastName, $signupGender);
		
		//täida käu
		if($stmt->execute()) {
			echo "Salvestamine õnnestus";
			
		} else {
		 	echo "ERROR ".$stmt->error;
		}
		//panen Ühenduse kinni
		$stmt->close();
		$mysqli->close();
	}


function login($loginEmail, $loginPassword) {
	
	$error = "";
	$password = $loginPassword;
	$email = $loginEmail;
	
	$database = "if16_andrkalj_4";
		$mysqli = new mysqli ($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
		
		$stmt = $mysqli->prepare("SELECT id, username, password, email, firstname, lastname, gender FROM project_user WHERE email = ?");
		
		echo $mysqli->error;
		
		//asendan küsimärgi
		$stmt->bind_param("s", $email);
		
		//määrna väärtused muutujasse
		$stmt->bind_result($id, $usernameFromDB, $passwordFromDB,  $emailFromDB, $firstnameFromDB, $lastnameFromDB, $genderFromDB);
		$stmt->execute();
		
		//andmed tulid andmebaasist või mitte
		//on tõene kui on vähemalt üks vastus
		
		if($stmt->fetch()){
			//oli sellise meiliga kasutaja
			//password millega kasutaja tahab sisse logida
			$hash = hash("sha512", $password);
			if ($hash == $passwordFromDB) {
				echo "Kasutaja logis sisse ".$id;
				
			$_SESSION["userId"] = $id;
			$_SESSION["userEmail"] = $emailFromDB;
			$_SESSION["userName"] = $usernameFromDB;
			$_SESSION["firstName"] = $firstnameFromDB;
			$_SESSION["lastName"] = $lastnameFromDB;
			$_SESSION["gender"] = $genderFromDB;
			header("Location: data.php");
			exit();
			
			} else {
				$error = "Vale parool";
			}
			//määran sessiooni muutujad
			
			
			//header("Location: login.php");
			
		} else {
			//ei ole sellist kasutajat selle meiliga
			$error = "Ei ole sellist e-maili";
		}
	
		return $error;
	}
	
function cleanInput($input) {
	// " tere tulemast " <--
	$input = trim($input);
	// "tere tulemast" <-- peale eelmist rida
	
	// " tere \\tulemast " <--
	$input = stripslashes($input);
	// "tere tulemast"

	// "<"
	$input = htmlspecialchars_decode($input);
	// "&lt"
	
	return $input;
}

	
function work($userName, $age, $gender, $color){
	//echo $serverUsername;
	//Ühendus
	$database = "if16_andrkalj_4";

		$mysqli = new mysqli ($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);

		// mysqli rida
		$stmt = $mysqli->prepare("INSERT INTO project_run (age, gender, color) VALUES (?, ?, ?)");
		echo $mysqli->error;
		// stringina üks täht iga muutuja kohta (?), mis t??t
		// string - s
		// integer - i
		// float (double) - d
		// küsimärgid asendada muutujaga
		$stmt->bind_param("sss", $age, $gender, $color);
		
		//täida käu
		if($stmt->execute()) {
			echo "Salvestamine õnnestus";
			
		} else {
		 	echo "ERROR ".$stmt->error;
		}
		//panen Ühenduse kinni
		$stmt->close();
		$mysqli->close();
	}
	
	//$searching
	

function getwork($searching, $sort, $direction){
	$database = "if16_andrkalj_4";
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
	
	$allowedSortOptions = ["id", "name", "age"];
	
	if(!in_array($sort, $allowedSortOptions)){
			$sort = "id";
		}
		echo "Sorteerin: ".$sort." ";
	
	$orderBy= "ASC";
		if($direction == "descending"){
			$orderBy= "DESC";
		}
		echo "Järjekord: ".$orderBy." ";
	
	if($searching == "") {
		echo "Ei otsi";
	$stmt = $mysqli->prepare ("SELECT id, name, age, gender, color FROM project_run WHERE deleted is NULL ORDER BY $sort $orderBy");
	}else{
		echo "Otsib";
		$searchword = "%".$searching."%";
		$stmt = $mysqli->prepare ("SELECT id, name, age, gender, color FROM project_run WHERE deleted is NULL 
								   AND (name LIKE ? OR age LIKE ?) ORDER BY $sort $orderBy");
	//OR age LIKE ? OR gender LIKE ? OR color LIKE ? OR date LIKE ? OR avg_pace LIKE ?
		$stmt->bind_param("ss", $searchword, $searchword);
		}
	$stmt->bind_result($id, $userName, $age, $gender, $color);
	$stmt->execute();
	
	//tekitan massiivi
	$result = array();	
	
	
	//tee seda seni, kuni on rida andmeid, mis vastab select lausele
	while($stmt->fetch()) {
	//tekitan objekti
		$work = new StdClass();
		
		$work->id = $id;
		$work->userName = $userName;
		$work->age = $age;
		$work->gender = $gender;
		$work->color = $color;


		
		#echo $plate."<br>";
		//iga korda massiivi lisan juurde numbrimärgi
		array_push($result, $work);
	}
$stmt->close();
$mysqli->close();	
return $result;
}

	
 function getSinglework($edit_id){
     
        $database = "if16_andrkalj_4";
 
 	//echo "id on ".$edit_id;
 		
 		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
 		
 $stmt = $mysqli->prepare("SELECT age, gender, color FROM project_run WHERE id = ? ");
 		
		echo $mysqli->error;
		
		$stmt->bind_param("i", $edit_id);
 		$stmt->bind_result($age, $gender, $color);
 		$stmt->execute();
 		
 		//tekitan objekti
 	$work = new Stdclass();
 		
 		//saime ühe rea andmeid
 		if($stmt->fetch()){
 		// saan siin alles kasutada bind_result muutujaid
 			
			$work->age = $age;
 			$work->gender = $gender;
			$work->color = $color;

 			
 			
 		}else{
 		// ei saanud rida andmeid kätte
 			// sellist id'd ei ole olemas
 			// see rida võib olla kustutatud
 			header("Location: data.php");
 			exit();
 		}
 		
 		$stmt->close();
 		$mysqli->close();
 		
 		return $work;
 		
 	}
 


 	function updatework($id, $age, $gender, $color){
     	
         $database = "if16_andrkalj_4";
 
 		
 		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
 		echo $mysqli->error;
 		$stmt = $mysqli->prepare("UPDATE project_run SET age = ?, gender = ?, color = ? WHERE id = ?");
    	$stmt->bind_param("sssi", $age, $gender, $color, $id);
 		echo $mysqli->error;
 		// kas õnnestus salvestada
 		if($stmt->execute()){
 			// õnnestus
 			echo "salvestus õnnestus!";
 		}
 		
 		$stmt->close();
 		$mysqli->close();
 		
 	}
 	
	function delete($id){
		
		$database = "if16_andrkalj_4";

		$mysqli = new mysqli ($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
		
		$stmt = $mysqli->prepare("UPDATE project_run SET deleted=NOW() WHERE id=? AND deleted IS NULL");
		$stmt->bind_param("i",$id);
		
		// kas õnnestus salvestada
		if($stmt->execute()){
			// õnnestus
			echo "kustutamine õnnestus!";
		}
		
		$stmt->close();
		$mysqli->close();
		
	}
	
	
?>