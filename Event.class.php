<?php
class Event {
	
	private $connection;
	

	function __construct($mysqli){
		
		$this->connection = $mysqli;
		
	}
	
		function saveEvent($event, $date, $location) {
			
			$stmt = $this->connection->prepare("INSERT INTO mvp (event, date, location) VALUE (?, ?, ?)");
			echo $this->connection->error;
			
			$stmt->bind_param("sss", $event, $date, $location);
			
			if ($stmt->execute() ){
				echo "õnnestus";
			} else {
				echo "ERROR".$stmt->error;
			}
		}
		
		function getAllEvents ($q, $sort, $order){
			
			$allowedSort = ["id", "event", "date", "location"];
			
			if(!in_array($sort, $allowedSort)){
            $sort = "id";
        }
        $orderBy = "ASC";
        if($order == "DESC") {
            $orderBy = "DESC";
        }
        echo "Sorteerin: ".$sort." ".$orderBy." ";
			
			if ($q != "") {
			
			echo "otsin: ".$q;
			
				$stmt = $this->connection->prepare("SELECT id, event, date, location FROM mvp WHERE deleted IS NULL AND ( event LIKE ? OR date LIKE ? OR location like ? ) ORDER BY $sort $orderBy");
				$searchWord = "%".$q."%";
				$stmt->bind_param("sss", $searchWord, $searchWord, $searchWord);
				
			} else {
				
				$stmt = $this->connection->prepare("SELECT id, event, date, location FROM mvp WHERE deleted IS NULL ORDER BY $sort $orderBy");
					}
			$stmt->bind_result($id, $event, $date, $location);
			$stmt->execute();
			
			$results = array();
			// Tsükli sisu tehake nii mitu korda, mitu rida SQL lausega tuleb
			while($stmt->fetch()) {
				//echo $color."<br>";
				$upcomingEvent= new StdClass();
				$upcomingEvent->id = $id;
				$upcomingEvent->event = $event;
				$upcomingEvent->date = $date;
				$upcomingEvent->location = $location;
				
				array_push($results, $upcomingEvent);
			}
			
			return $results;
		}
		
		function getSinglePerosonData($edit_id){
		
		$stmt = $this->connection->prepare("SELECT event, date, location FROM mvp WHERE id=? AND deleted IS NULL");

		$stmt->bind_param("i", $edit_id);
		$stmt->bind_result($event, $date, $location);
		$stmt->execute();
		
		
		$p = new Stdclass();
		
		
		if($stmt->fetch()){
			
			$p->event = $event;
			$p->date = $date;
			$p->location = $location;
			
			
		}else{
			
			header("Location: data.php");
			exit();
		}
		
		$stmt->close();
		
		
		return $p;
		
	}
		
	function updateEvent($id, $event, $date, $location){
    	
		
		$stmt = $this->connection->prepare("UPDATE mvp SET event=?, date=?, location=? WHERE id=? AND deleted IS NULL");
		$stmt->bind_param("sssi",$event, $date, $location, $id);
		
		
		if($stmt->execute()){
			
			echo "salvestus õnnestus!";
		}
		
		$stmt->close();
		
		
	}
	function deleteEvent($id){
    	
		$stmt = $this->connection->prepare("UPDATE mvp SET deleted=NOW() WHERE id=? AND deleted IS NULL");
		$stmt->bind_param("i",$id);
		
		
		if($stmt->execute()){
			
			echo "kustutamine õnnestus!";
		}
		
		$stmt->close();
		
		
	}
		
	
	
}