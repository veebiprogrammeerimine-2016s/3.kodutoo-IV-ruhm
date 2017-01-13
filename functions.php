<?php 

	require("../../config.php");
	
	//see fail peab olema seotud kõigiga kus tahame sessiooni kasutada, saab kasutada nüüd $_session muutujat
	session_start();
	$database = "if16_raily_4";
	
	
	function signup($email, $password) {
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);

		$stmt = $mysqli->prepare("INSERT INTO user_sample (email, password) VALUE (?,?)");
		echo $mysqli->error;

		$stmt->bind_param("ss",$email, $password);
		if ($stmt->execute() ) {
			echo "õnnestus";
		}	else { "ERROR".$stmt->error;
		}
	}
	
	function login($email, $password) {
		$notice="";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT id, email, password, created FROM user_sample WHERE email = ?"  );
		echo $mysqli->error;
		//asendan küsimärgi
		$stmt->bind_param("s",$email);
		
		//rea kohta tulba väärtus
		$stmt->bind_result($id, $emailFromDb, $passwordFromDb, $created);
		$stmt->execute();
		
		//ainult select puhul
		if($stmt->fetch()){
			//oli olemas,rida käes
			$hash=hash("sha512", $password);
			if($hash==$passwordFromDb) {
				echo "Kasutaja $id logis sisse";
				$_SESSION["userId"] = $id;
				$_SESSION["userEmail"] = $emailFromDb;
				header("Location: data.php");
				exit();
			} else {
				$notice = "Parool vale";
			}
		} else {
			//ei olnud ühtegi rida
			$notice = "Sellise emailiga $email kasutajat ei ole olemas";
		}
		
		$stmt->close();
		$mysqli->close();
		
		return $notice;
	}
	
	function saveEvent($City, $Cinema, $Movie, $Genre, $Comment, $Rating) {
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO kino (City, Cinema, Movie, Genre, Comment, Rating) VALUE (?, ?, ?, ?, ?, ?)");
		echo $mysqli->error;
		
		$stmt->bind_param("sssssi", $City, $Cinema, $Movie, $Genre, $Comment, $Rating);
		
		if ( $stmt->execute() ) {
			echo "õnnestus <br>";
		} else {
			echo "ERROR ".$stmt->error;
		}
		
	}
	
	
	
	
	
	
	
	
	
	
	function getAllPeople($q, $sort, $order){
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$allowedSort = ["id", "City", "Cinema", "Movie", "Genre", "Comment", "Rating"];
		
		// sort ei kuulu lubatud tulpade sisse 
		if(!in_array($sort, $allowedSort)){
			$sort = "id";
		}
		
		$orderBy = "ASC";
		
		if($order == "DESC") {
			$orderBy = "DESC";
		}
		//echo "Sorteerin: ".$sort." ".$orderBy." ";
		
		if($q!=""){
			//otsin
			echo"otsin: ".$q;
			$stmt = $mysqli->prepare("
				SELECT id, City, Cinema, Movie, Genre, Comment, Rating
				FROM kino
				WHERE deleted IS NULL
				AND ( City LIKE ? OR Cinema LIKE ? OR Movie LIKE ? OR Genre LIKE ? OR Comment LIKE ? OR Rating LIKE ?)
				ORDER BY $sort $orderBy
				");
			$searchWord="%".$q."%";
			$stmt->bind_param("sssssi", $searchWord, $searchWord, $searchWord, $searchWord, $searchWord, $searchWord);
		}else {
			//ei otsi
			$stmt = $mysqli->prepare("
				SELECT id, City, Cinema, Movie, Genre, Comment, Rating
				FROM kino
				WHERE deleted IS NULL
				ORDER BY $sort $orderBy
				");
		}
		
		
		$stmt->bind_result($id, $City, $Cinema, $Movie, $Genre, $Comment, $Rating);
		$stmt->execute();
		$results=array();
		//tsüklissisu toimib seni kaua, mitu rida SQL lausega tuleb
		while($stmt->fetch()) {
			$human=new StdClass();
			$human->id=$id;
			$human->City=$City;
			$human->Cinema=$Cinema;
			$human->Movie=$Movie;
			$human->Genre=$Genre;
			$human->Comment=$Comment;
			$human->Rating=$Rating;
			array_push($results, $human);
		}
		return $results;
	}
	
	
	
	
	
	
	
	
	
	
	
	/*
	function getAllPeople(){
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt=$mysqli->prepare("SELECT id, City, Cinema, Movie, Genre, Comment, Rating FROM kino WHERE deleted IS NULL");
		$stmt->bind_result($id, $City, $Cinema, $Movie, $Genre, $Comment, $Rating);
		$stmt->execute();
		$results=array();
		//tsüklissisu toiimib seni kaua, mitu rida SQL lausega tuleb
		while($stmt->fetch()) {
			$human=new StdClass();
			$human->id=$id;
			$human->City=$City;
			$human->Cinema=$Cinema;
			$human->Movie=$Movie;
			$human->Genre=$Genre;
			$human->Comment=$Comment;
			$human->Rating=$Rating;
			
			
			
			array_push($results, $human);
		}
		return $results;
		}
	*/
	function cleanInput($input) {
		$input=trim($input);
		$input=stripslashes($input);
		$input=htmlspecialchars($input);
		return $input;
	}
	
	
	
	
	/*function sum($x, $y) {
		return $x + $y;
	}
	echo sum(12312312,12312355553);
	echo "<br>";
	function hello($n, $p) {
		return "Tere tulemast ".$n." ". $p;
	}
	echo hello("Raily", "T");
	echo "<br>";
	*/
?>