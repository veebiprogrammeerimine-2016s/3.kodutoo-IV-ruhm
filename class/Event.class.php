<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
class Event {
    
    private $connection;
	
	function __construct($mysqli){
		$this->connection = $mysqli;
	}
	
		
	function saveEvent($testi_id, $kommentaar) {
				
		$stmt = $this->connection->prepare("INSERT INTO whistle (testi_id, kommentaar) VALUE (?, ?)");
		echo $this->connection->error;
		
		$stmt->bind_param("is", $testi_id, $kommentaar);
		
		if ( $stmt->execute() ) {
			echo "õnnestus";
		} else {
			echo "ERROR ".$stmt->error;
		}
		
	}
	
	function getAllPeople($q, $sort, $order) {
		
		$allowedSort = ["id", "testi_id", "kommentaar"];
		
		// sort ei kuulu lubatud tulpade sisse 
		if(!in_array($sort, $allowedSort)){
			$sort = "id";
		}
		
		$orderBy = "ASC";
		
		if($order == "DESC") {
			$orderBy = "DESC";
		}
		
		echo "Sorteerin: ".$sort." ".$orderBy." ";
		
		
		if ($q != "") {
			//otsin
			echo "otsin: ".$q;
			
			$stmt = $this->connection->prepare("
				SELECT id, testi_id, kommentaar
				FROM whistle
				WHERE deleted IS NULL
				AND ( testi_id LIKE ? OR kommentaar LIKE ? )
				ORDER BY $sort $orderBy
			");
			
			$searchWord = "%".$q."%";
			
			$stmt->bind_param("ss", $searchWord, $searchWord);
			
		} else {
			// ei otsi
			$stmt = $this->connection->prepare("
				SELECT id, testi_id, kommentaar
				FROM whistle
				WHERE deleted IS NULL
				ORDER BY $sort $orderBy
			");
		}
		
		$stmt->bind_result($id, $testi_id, $kommentaar);
		$stmt->execute();
		
		$results = array();
		
		// tsükli sisu tehakse nii mitu korda, mitu rida
		// SQL lausega tuleb
		while ($stmt->fetch()) {
			
			$human = new StdClass();
			$human->id = $id;
			$human->testi_id = $testi_id;
			$human->kommentaar = $kommentaar;
			
			
			//echo $color."<br>";
			array_push($results, $human);
			
		}
		
		return $results;
		
	}
	
	
	function getSinglePerosonData($edit_id){
    
		
		$stmt = $this->connection->prepare("SELECT testi_id, kommentaar FROM whistle WHERE id=? AND deleted IS NULL");

		$stmt->bind_param("i", $edit_id);
		$stmt->bind_result($testi_id, $kommentaar);
		$stmt->execute();
		
		//tekitan objekti
		$p = new Stdclass();
		
		//saime ühe rea andmeid
		if($stmt->fetch()){
			// saan siin alles kasutada bind_result muutujaid
			$p->testi_id = $testi_id;
			$p->kommentaar = $kommentaar;
			
			
		}else{
			// ei saanud rida andmeid kätte
			// sellist id'd ei ole olemas
			// see rida võib olla kustutatud
			header("Location: data.php");
			exit();
		}
		
		$stmt->close();
		
		return $p;
		
	}

	function updatePerson($id, $testi_id, $kommentaar){
    			
		$stmt = $this->connection->prepare("UPDATE whistle SET testi_id=?, kommentaar=? WHERE id=? AND deleted IS NULL");
		$stmt->bind_param("isi",$testi_id, $kommentaar, $id);
		
		// kas õnnestus salvestada
		if($stmt->execute()){
			// õnnestus
			echo "salvestus õnnestus!";
		}
		
		$stmt->close();
		
	}
	
	function deletePerson($id){
    	
        $database = "if16_henrsavi_4";
		
		$stmt = $this->connection->prepare("
		UPDATE whistle SET deleted=NOW()
		WHERE id=? AND deleted IS NULL");
		$stmt->bind_param("i",$id);
		
		// kas õnnestus salvestada
		if($stmt->execute()){
			// õnnestus
			echo "salvestus õnnestus!";
		}
		
		$stmt->close();
		
	}
	
	
}
?>