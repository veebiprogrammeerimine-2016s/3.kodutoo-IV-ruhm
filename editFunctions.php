<?php

	require_once("../../config.php");
	
	function getEntry($edit_id){
    
        $database = "if16_kristarn";

		//echo "id on ".$edit_id;
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
		
		$stmt = $mysqli->prepare("SELECT videokaart, malutyyp, malukiirus, videomalu, Hind, maluliidese_laius FROM videokaardid2 WHERE id=?");

		$stmt->bind_param("i", $edit_id);
		$stmt->bind_result($videokaart,  $Malutyyp, $malukiirus, $videomalu, $Hind, $maluliidese_laius);
		$stmt->execute();
		
		//tekitan objekti
		$videokaardid = new Stdclass();
		
		//saime ühe rea andmeid
		if($stmt->fetch()){
			// saan siin alles kasutada bind_result muutujaid
			$videokaardid->vc = $videokaart;
			$videokaardid->mt = $Malutyyp;
			$videokaardid->mk = $malukiirus;
			$videokaardid->vm = $videomalu;
			$videokaardid->h = $Hind;
			$videokaardid->mll = $maluliidese_laius;
			
			
		}else{
			// ei saanud rida andmeid kätte
			// sellist id'd ei ole olemas
			// see rida võib olla kustutatud
			header("Location: data.php");
			exit();
		}
		
		$stmt->close();
		$mysqli->close();
		
		return $videokaardid;
		
	}


	function updatePerson($id, $vc, $mt, $mk, $vm, $mll, $H){
    	
        $database = "if16_kristarn";

		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
		
		$stmt = $mysqli->prepare("UPDATE videokaardid2 SET videokaart=?, malutyyp=?, malukiirus=?, videomalu=?, Hind=?, maluliidese_laius=? WHERE id=?");
		$stmt->bind_param("ssiiiii", $vc, $mt, $mk, $vm, $mll, $H, $id);
		
		// kas õnnestus salvestada
		if($stmt->execute()){
			// õnnestus
			echo "salvestus õnnestus!";
		}
		
		$stmt->close();
		$mysqli->close();
		
	}
	
	function deleteEntry($id) {
		
		        $database = "if16_kristarn";
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
		
		$stmt = $mysqli->prepare("UPDATE videokaardid2 SET Arhiveeritud='jah'  WHERE id=?");
		$stmt->bind_param("i", $id);
		
		// kas õnnestus salvestada
		if($stmt->execute()){
			// õnnestus
			echo "salvestus õnnestus!";
		}
		
		$stmt->close();
		$mysqli->close();
		
	}
	
		
	
	
?>