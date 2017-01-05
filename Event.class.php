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


function getAllPlayers ()
	{
		$stmt = $this->connection->prepare("
			SELECT place, duration, end_duration
			FROM duration
			");

		$stmt->bind_result($place, $duration, $end_duration);
		$stmt->execute();

		$results = array();
		while ($stmt->fetch())	{
			$player = new StdClass();
			$player->place = $place;
			$player->duration = $duration;
			$player->end_duration = $end_duration;

			array_push($results, $player);
		}
		return $results;
	}

/*function getSinglePerosonData($edit_id){
    
        $database = "if16_thetloff";
		//echo "id on ".$edit_id;
		
		$stmt = $this->connection->prepare("
			SELECT age, color 
			FROM whistle 
			WHERE id=? AND deleted IS NULL");

		$stmt->bind_param("i", $edit_id);
		$stmt->bind_result($age, $color);
		$stmt->execute();
		
		//tekitan objekti
		$p = new Stdclass();
		
		//saime ühe rea andmeid
		if($stmt->fetch()){
			// saan siin alles kasutada bind_result muutujaid
			$p->age = $age;
			$p->color = $color;
			
			
		}else{
			header("Location: data.php");
			exit();
		}
		
		$stmt->close();
		
		return $p;
		
	}

	function updatePerson($id, $age, $color){
    	
        $database = "if16_thetloff";
		
		$stmt = $this->connection->prepare("
			UPDATE whistle 
			SET age=?, color=? 
			WHERE id=? AND deleted IS NULL");
		$stmt->bind_param("isi",$age, $color, $id);
		
		// kas õnnestus salvestada
		if($stmt->execute()){
			// õnnestus
			echo "salvestus õnnestus!";
		}
		
		$stmt->close();
		
	}
	
	function deletePerson($id){
    	
        $database = "if16_thetloff";

		$stmt = $this->connection->prepare("
			UPDATE whistle 
			SET deleted=NOW() 
			WHERE id=? AND deleted IS NULL");
		$stmt->bind_param("i", $id);
		
		// kas õnnestus salvestada
		if($stmt->execute()){
			// õnnestus
			echo "kustutamine õnnestus!";
		}
		
		$stmt->close();
		
	}*/


}
?>