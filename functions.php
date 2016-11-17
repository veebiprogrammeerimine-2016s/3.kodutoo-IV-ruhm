<?php

	require("/home/ukupode/config.php");
	session_start();
	
	$database = "if16_ukupode";
	$mysqli = new mysqli($serverHost, $serverUsername, $serverPassword, $database);


class functions{
	

	private $connection;
		//käivitab siia kui on =new User(see jõuab siia)
	function __construct($mysqli){
			
		$this->connection = $mysqli;
	}	
	
	
	
	
	
	
	
	
	
	function submit($start,$finish){
		
		
		
		$allowedSubmits = ["start","finish"];
		
		$stmt = $this->connection->prepare("
		INSERT INTO gps (start, finish) 
		VALUES (?, ?)
		");
		
		echo $this->connection->error;
		
		$stmt->bind_param("ss", $start, $finish);
	
		if ($stmt->execute())
		{
			echo "<br>õnnestus";	
		}
		else
		{
			echo "error".$stmt->error;
		}
	}
	
	
	
	
	
	
	function numberDoesExist($nr, $points){
		foreach($points as $p){
			if (in_array($nr,$p)){
				return true;
			}
		}
		
		return false;
	}
	
	
	
	
	
	
	
	function mostUsed($filter) {
	
	
		$arr = ["start", "finish"];
		
		if (!in_array($filter,$arr))
		{
			echo "error ----";
			return;
		}else{
			
			$stmt = $this->connection->prepare("
				SELECT distinct($filter)
				FROM gps
				WHERE deleted is NULL				
				ORDER BY $filter DESC limit 3
				
				
				
				
			");
			//SESSION USER ID
			
			//$stmt->bind_param("ssss", $startnumber,$startnumber,$startnumber,$startnumber);
			
			echo $this->connection->error;
			
			$stmt->bind_result($start);
			$stmt->execute();
			
			
			//tekitan massiivi
			$result = array();
			
			// tee seda seni, kuni on rida andmeid
			// mis vastab select lausele
			while ($stmt->fetch()) {
				
				//tekitan objekti
				$used = new StdClass();
				
				$used->start = $start;
				
				//$used->count = $count;
			
				array_push($result, $used);
			}
			$stmt->close();
			return $result;
		}	
		
	}
	
	
	function startTable($q, $sort, $order) {


		$allowedSort = ["start","finish","kogus"];
		
		//sort ei kuulu lubatud valikute alla
		if (!in_array($sort, $allowedSort)){
			$sort = "kogus";
		}
		$orderBy = "ASC";
		
		if($order == "DESC"){
			
			$orderBy = "DESC";
		}
		
		echo "Sorteerin: ".$sort." ".$orderBy." ";
		
		
		if($q != ""){
				

			$stmt = $this->connection->prepare("
			SELECT start,finish,count(*)as kogus
			FROM gps
			WHERE deleted IS NULL
			GROUP BY start,finish
			ORDER BY $sort $orderBy
			");
			
			//$searchWord= "%".$q."%";
			//$stmt->bind_param("ss", $searchWord, $searchWord);
			
			
			
		}else{
			
			
			
			//ei otsi
			$stmt = $this->connection->prepare("
			SELECT start,finish,count(*)as kogus
			FROM gps
			WHERE deleted is NULL
			GROUP BY start,finish
			ORDER BY $sort $orderBy
			");
			
			
		}
		
		
		$stmt->bind_result($startPlace,$finishPlace,$count);
		$stmt->execute();
		
		$results = array();
		
		// tsükli sisu tehakse nii mitu korda, mitu rida
		// SQL lausega tuleb
		while ($stmt->fetch()) {
			
			$tabel = new StdClass();
			$tabel->start = $startPlace;
			//$tabel->count = $startCount;
			$tabel->finish = $finishPlace;
			$tabel->count = $count;
			
			
			//echo $color."<br>";
			array_push($results, $tabel);
			
		}
		
		return $results;
		
	}
	
	function deleteButton($start,$finish){
		

		$stmt = $this->connection->prepare("UPDATE gps SET deleted =NOW() WHERE start=? AND finish = ?");
		$stmt->bind_param("ss", $start, $finish);
		
		// kas õnnestus salvestada
		if($stmt->execute()){
			// õnnestus
			
			header("Location: test.php?success=true");
		}
		
		$stmt->close();
	}
	
}
?>