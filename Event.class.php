<?php
class Event {
	private $connection;

	//käivitatakse siis, kui functions.php-s öeldakse new User, siis see jõuab siia
	function __construct($mysqli){
		// $this viitab selle classi muutujale

		$this->connection = $mysqli;
	}
	
	function saveEvent($place, $duration, $end_duration) 
	{
		$stmt = $this->connection->prepare("
			INSERT INTO duration (user_id, place, duration, end_duration) 
			VALUES (?, ?, ?, ?)");

		$stmt ->bind_param("isss", $_SESSION["userid"], $place, $duration, $end_duration);

		if ($stmt->execute() ) {
			echo "õnnestus";
		} else {
			echo "ERROR ".$stmt->error;
		}
	}

function getAllPlayers ($q, $sort, $order){

$allowedSort = ["duration", "end_duration"];
	if(!in_array($sort, $allowedSort)) {
		$sort = "duration";
	}

	$orderBy = "ASC";

	if ($order == "DESC")	{
		$orderBy = "DESC";
	}
	echo "sorteerin: ".$sort." ".$orderBy." ";

	if($q !="") {
		$stmt = $this->connection->prepare("
			SELECT id, place, duration, end_duration
			FROM duration
			WHERE deleted IS NULL
			AND ( duration LIKE ? OR end_duration LIKE ?)
			ORDER BY $sort $orderBy
			");

			$searchWord = "%".$q."%";
			$stmt->bind_param("ss", $searchWord, $searchWord);

		}	else {
			$stmt = $this->connection->prepare("
			SELECT id, place, duration, end_duration
			FROM duration
			WHERE deleted IS NULL
			ORDER BY $sort $orderBy
			");
		}
		
		$stmt->bind_result($id, $place, $duration, $end_duration);
		$stmt->execute();

		$results = array();
		while ($stmt->fetch())	{
			$player = new StdClass();
			$player->id =$id;
			$player->place = $place;
			$player->duration = $duration;
			$player->end_duration = $end_duration;

			array_push($results, $player);
		}
		return $results;
	}



/*	function getAllPlayers (){

		$stmt = $this->connection->prepare("
			SELECT id, place, duration, end_duration
			FROM duration
			WHERE deleted IS NULL
			");

		$stmt->bind_result($id, $place, $duration, $end_duration);
		$stmt->execute();

		$results = array();
		while ($stmt->fetch())	{
			$player = new StdClass();
			$player->id =$id;
			$player->place = $place;
			$player->duration = $duration;
			$player->end_duration = $end_duration;

			array_push($results, $player);
		}
		return $results;
	}*/


	function updatePerson($id, $place, $duration, $end_duration){

		$stmt = $this->connection->prepare("
			
			UPDATE duration
			SET place=?, duration=?, end_duration=?
			WHERE id=? AND deleted IS NULL
			");

		$stmt->bind_param("sssi", $place, $duration, $end_duration, $id);

		if($stmt->execute()){
			echo "andmete muutmine õnnestus";
		}

		$stmt->close();
		
	}


	function getSinglePersonData($edit_id){

		$database = "if16_thetloff";
		//echo "id on ".$edit_id;
		
		$stmt = $this->connection->prepare("
			SELECT id, place, duration, end_duration
			FROM duration
			WHERE id=? AND deleted IS NULL");

		$stmt->bind_param("i", $edit_id);
		$stmt->bind_result($id, $place, $duration, $end_duration);
		$stmt->execute();
		
		//tekitan objekti
		$p = new Stdclass();
		
		//saime ühe rea andmeid
		if($stmt->fetch()){
			// saan siin alles kasutada bind_result muutujaid
			$p->id = $id;
			$p->place = $place;
			$p->duration = $duration;
			$p->end_duration = $end_duration;
			
			
		}else{
			header("Location: data_2.php");
			exit();
		}
		
		$stmt->close();
		
		return $p;
		
	}

	
	
	function deletePerson($id){

		$database = "if16_thetloff";

		$stmt = $this->connection->prepare("
			UPDATE duration 
			SET deleted=CURRENT_DATE() 
			WHERE id=? AND deleted IS NULL");
		$stmt->bind_param("i", $id);
		
		// kas õnnestus salvestada
		if($stmt->execute()){
			// õnnestus
			echo "kustutamine õnnestus!";
		}
		
		$stmt->close();
		
	}


}
?>