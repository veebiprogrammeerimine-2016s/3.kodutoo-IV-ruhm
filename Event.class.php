<?php
class Event {
	
			private $connection;
	
	// k�ivitatakse siis kui on = new User(see j�uab siia)
	function __construct($mysqli) {
		$this->connection = $mysqli;
	}

		
		function saveEvent($vc, $mt, $mk, $vm, $mll, $H) {
		
				 
				 $stmt = $this->connection->prepare("INSERT INTO videokaardid2 (videokaart, malutyyp, malukiirus, videomalu, Hind, maluliidese_laius) VALUE (?, ?, ?, ?, ?, ?)");
				 
				 //asendan k�sim�rgid
				 //iga m�rgi kohta tuleb lisada �ks t�ht - mis t��pi muutuja on
				 // s - string
				 // i - int
				 // d - double
				 $stmt->bind_param("ssiiii", $vc, $mt, $mk, $vm, $mll, $H);
				 //t'ida k�sku
				 if( $stmt->execute()){
					 echo "�nnestus";
				 } else {
						echo "<br>"."ERROR: ".$stmt->error;
					 
				 }	
		
	}	
	
			function getAllVideocards($q, $sort, $order) {
				 
				 $mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]); 
				 
				 $allowedSort = ["videokaart","videomalu", "Hind", "malukiirus"];
				 
				 		if(!in_array($sort, $allowedSort)){
							$sort = "videokaart";
						}
		
		
				$orderBy = "ASC";
				
				if($order == "DESC") {
					$orderBy = "DESC";
					}
				echo "Sorteerin: ".$sort." ".$orderBy." ";
				
				if ($q != "") {
					
					echo "otsin: ".$q;
					
					$stmt = $mysqli->prepare("
					SELECT videokaart, id, malutyyp, malukiirus, videomalu, Hind, maluliidese_laius
					FROM videokaardid2
					WHERE Arhiveeritud IS NULL AND ( videokaart like ? OR malukiirus like ? or videomalu like ? or Hind like ?)
					ORDER BY $sort, $orderBy
				");
	
				$searchWord = "%".$q."%";
				$stmt->bind_param("ssss", $searchWord, $searchWord, $searchWord, $searchWord);
			$stmt->bind_result($videokaart, $id, $Malutyyp, $malukiirus, $videomalu, $Hind, $maluliidese_laius);
		
			$stmt->execute();
			
			$results = array();
			
			// ts�klit tehakse nii mitu korda, mitu rida sql lausega tuleb.			
			while ($stmt->fetch()) {
				
				$videokaardid = new StdClass();
				$videokaardid->vc = $videokaart;
				$videokaardid->id = $id;
				$videokaardid->mt = $Malutyyp;
				$videokaardid->mk = $malukiirus;
				$videokaardid->vm = $videomalu;
				$videokaardid->h = $Hind;
				$videokaardid->mll = $maluliidese_laius;
			
					//echo $color."<br>";
					array_push($results, $videokaardid);
					
			} 
				} else {
				$stmt = $mysqli->prepare("
					SELECT videokaart, id, malutyyp, malukiirus, videomalu, Hind, maluliidese_laius
					FROM videokaardid2
					WHERE Arhiveeritud IS NULL
				");
	
			$stmt->bind_result($videokaart, $id, $Malutyyp, $malukiirus, $videomalu, $Hind, $maluliidese_laius);
		
			$stmt->execute();
			
			$results = array();
			
			// ts�klit tehakse nii mitu korda, mitu rida sql lausega tuleb.			
			while ($stmt->fetch()) {
				
				$videokaardid = new StdClass();
				$videokaardid->vc = $videokaart;
				$videokaardid->id = $id;
				$videokaardid->mt = $Malutyyp;
				$videokaardid->mk = $malukiirus;
				$videokaardid->vm = $videomalu;
				$videokaardid->h = $Hind;
				$videokaardid->mll = $maluliidese_laius;
			
					//echo $color."<br>";
					array_push($results, $videokaardid);
					
			}
			
			
			return $results;
	}
			}

			function getAllVideocardsPlus() {
				 
				 $mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]); 
		
				$stmt = $mysqli->prepare("
					SELECT videokaart, id, malutyyp, malukiirus, videomalu, Hind, maluliidese_laius
					FROM videokaardid2
				");
	
			$stmt->bind_result($videokaart, $id, $Malutyyp, $malukiirus, $videomalu, $Hind, $maluliidese_laius);
		
			$stmt->execute();
			
			$results = array();
			
			// ts�klit tehakse nii mitu korda, mitu rida sql lausega tuleb.			
			while ($stmt->fetch()) {
				
				$videokaardid = new StdClass();
				$videokaardid->vc = $videokaart;
				$videokaardid->id = $id;
				$videokaardid->mt = $Malutyyp;
				$videokaardid->mk = $malukiirus;
				$videokaardid->vm = $videomalu;
				$videokaardid->h = $Hind;
				$videokaardid->mll = $maluliidese_laius;
			
					//echo $color."<br>";
					array_push($results, $videokaardid);
					
			}

			return $results;
		}			
			
	
	
	
	
}
?>