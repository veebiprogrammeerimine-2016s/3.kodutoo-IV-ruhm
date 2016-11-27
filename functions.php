<?php

	require("../../config.php");

	session_start();

	$database = "if16_raitkeer";


	function signup($email, $password, $firstName, $surname, $address) {

		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO user_list (email, password, firstName, surname, address) VALUE (?, ?, ?, ?, ?)");
		
		$stmt->bind_param("sssss", $email, $password, $firstName, $surname, $address);
		
		if ( $stmt->execute() ) {
		}
	}

	function login($email, $password) {
		
		$notice = "";
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("
			SELECT id, email, password, created
			FROM user_list
			WHERE email = ?
		
		");
		
		$stmt->bind_param("s", $email);
		
		$stmt->bind_result($id, $emailFromDb, $passwordFromDb, $created);
		
		$stmt->execute();
		
		if($stmt->fetch()) {
			
			$hash = hash("sha512", $password);
			
			if ($hash == $passwordFromDb) {
				echo "Kasutaja $id logis sisse";
				
				$_SESSION["userId"] = $id;
				$_SESSION["userEmail"] = $emailFromDb;
				
				header("Location: data.php");
				
			} else {
				$notice = "parool vale";
			}
			
			
		} else {
			
			$notice = "Sellise emailiga ".$email." kasutajat ei ole olemas";
		}
		
		$stmt->close();
		$mysqli->close();
		
		return $notice;
		
	}

	function saveApples($variety, $location, $quantity, $price) {
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO apples (users, variety, location, quantity, price) VALUE (?, ?, ?, ?, ?)");
		
		$stmt->bind_param("sssdd", $_SESSION["userEmail"], $variety, $location, $quantity, $price);
		
		$stmt->execute();
	}	
	
	
	function getApples ($q, $sort, $order) {
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$allowedSort = ["variety", "location", "quantity", "price"];
		
		if(!in_array($sort, $allowedSort)){
			$sort = "price";
		}
		
		$orderBy = "ASC";
		
		if($order == "DESC") {
			$orderBy = "DESC";
		}
		
		if ($q != "") {
			
			$stmt = $mysqli->prepare("
				SELECT variety, location, quantity, price FROM apples
				WHERE ( variety LIKE ? OR location LIKE ? ) AND deleted IS NULL
				ORDER BY $sort $orderBy
			");
			
			$searchWord = "%".$q."%";
			
			$stmt->bind_param("ss", $searchWord, $searchWord);
			
		} else {
			// ei otsi
			$stmt = $mysqli->prepare("
				SELECT variety, location, quantity, price FROM apples WHERE deleted IS NULL
				ORDER BY $sort $orderBy
			");
		}
		
		$stmt->bind_result($variety, $location, $quantity, $price);
		
		$stmt->execute();
		
		$results = array();
		
		while ($stmt->fetch()) {
			
			$offer = new StdClass();
			$offer->variety = $variety;
			$offer->location = $location;
			$offer->quantity = $quantity;
			$offer->price = $price;
			
			array_push($results, $offer);

		}
		
		return $results;
		
	}
	
	function getMyApples () {
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);

		$stmt = $mysqli->prepare("SELECT id, variety, quantity, price FROM apples WHERE users = ? AND deleted IS NULL");
		
		$stmt->bind_param("s", $_SESSION["userEmail"]);
		
		$stmt->bind_result( $id, $variety, $quantity, $price);
		
		$stmt->execute();
		
		$results = array();
		
		while ($stmt->fetch()) {
			
			$offer = new StdClass();
			$offer->id = $id;
			$offer->variety = $variety;
			$offer->quantity = $quantity;
			$offer->price = $price;
			
			array_push($results, $offer);

		}
		
		return $results;
		
	}

	function cleanInput ($input) {
		
		$input = trim($input);
		
		//võtab välja "\"
		$input = stripslashes($input);
		
		//html asendused nt.\ asemel unicode
		$input = htmlspecialchars($input);
		
		return $input;
		
	}

	function getSingleApple($edit_id) {
    
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT id, variety, location, quantity, price FROM apples WHERE id=? AND deleted IS NULL");

		$stmt->bind_param("i", $edit_id);
		$stmt->bind_result($id, $variety, $location, $quantity, $price);
		$stmt->execute();
		
		$p = new Stdclass();
		
		if($stmt->fetch()){
			
			$p->id = $id;
			$p->variety = $variety;
			$p->location = $location;
			$p->quantity = $quantity;
			$p->price = $price;
			
			
		}else{
			header("Location: myData.php");
			exit();
		}
		
		$stmt->close();
		
		return $p;

	}
	
	function updateApple($id, $variety, $location, $quantity, $price){
    	
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("UPDATE apples SET variety = ?, location = ?, quantity = ?, price = ? WHERE id= ? AND deleted IS NULL");
		
		$stmt->bind_param("ssddi", $variety, $location, $quantity, $price, $id);
		
		$stmt->execute();
		
		$stmt->close();
		
	}
	
	function deleteOffer($id) {

		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	
		$stmt = $mysqli->prepare("UPDATE apples SET deleted=NOW() WHERE id = ? AND deleted IS NULL");
		
		$stmt->bind_param("i",$id);
		
		$stmt->execute();
		
		$stmt->close();
		
	}
	
	function getOfferCount() {
    
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT COUNT(*) FROM apples WHERE users = ? AND deleted IS NULL");

		$stmt->bind_param("s", $_SESSION["userEmail"]);
		
		$stmt->bind_result($count);
		$stmt->execute();
		
		
		$c = new Stdclass();
		
		if($stmt->fetch()){
			
			$c->count = $count;
			
		}else{

			exit();
		}
		
		$stmt->close();
		
		return $c;

	}


?>