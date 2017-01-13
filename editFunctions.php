<?php
 
 	require_once("../../config.php");
 	
 	function getSinglePerosonData($edit_id){
     
         $database = "if16_raily_4";
 
 		//echo "id on ".$edit_id;
 		
 		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
 		
 		$stmt = $mysqli->prepare("SELECT City, Cinema, Movie, Genre, Comment, Rating FROM kino WHERE id=? AND deleted IS NULL");
 
 		$stmt->bind_param("i", $edit_id);
 		$stmt->bind_result($City, $Cinema, $Movie, $Genre, $Comment, $Rating);
 		$stmt->execute();
 		
 		//tekitan objekti
 		$p = new Stdclass();
 		
 		//saime ühe rea andmeid
 		if($stmt->fetch()){
 			// saan siin alles kasutada bind_result muutujaid
 			$p->City = $City;
 			$p->Cinema = $Cinema;
			$p->Movie = $Movie;
 			$p->Genre = $Genre;
			$p->Comment = $Comment;
 			$p->Rating = $Rating;
 			
 			
 		}else{
 			// ei saanud rida andmeid kätte
 			// sellist id'd ei ole olemas
 			// see rida võib olla kustutatud
 			header("Location: data.php");
 			exit();
 		}
		
 		$stmt->close();
 		$mysqli->close();
 		
 		return $p;
 		
 	}
 
 
 	function updatePerson($id, $City, $Cinema, $Movie, $Genre, $Comment, $Rating){
     	
         $database = "if16_raily_4";
 
 		
 		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
 		
 		$stmt = $mysqli->prepare("UPDATE kino SET City=?, Cinema=?, Movie=?, Genre=?, 
		Comment=?, Rating=? WHERE id=? AND deleted IS NULL");
 		$stmt->bind_param("sssssii",$City, $Cinema, $Movie, $Genre, $Comment, $Rating, $id);
 		
 		// kas õnnestus salvestada
 		if($stmt->execute()){
 			// õnnestus
 			echo "salvestus õnnestus!";
 		}
 		
 		$stmt->close();
 		$mysqli->close();
 		
		
 	}
 	
	
	
	function deletePerson($id){
     	
        $database = "if16_raily_4";
 
 		
 		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
 		
 		$stmt = $mysqli->prepare("
		UPDATE kino SET deleted=NOW()
 		WHERE id=? AND deleted IS NULL");
 		$stmt->bind_param("i",$id);
 		
 		// kas õnnestus salvestada
 		if($stmt->execute()){
 			// õnnestus
 			echo "salvestus õnnestus!";
 		}
 		
 		$stmt->close();
 		$mysqli->close();
 		
 	}
	
 	
 ?>