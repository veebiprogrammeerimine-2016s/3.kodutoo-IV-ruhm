<?php
	

	require("../../config.php");
	$database = "if16_greg_4";
	// see fail peab olema seotud kõigiga kus tahame sessiooni kasutada
	// saab kasutada nüüd $_SESSION muutujat.
	session_start();

	$mysqli = new mysqli($serverHost, $serverUsername, $serverPassword, $database);
	

	


	//phpinfo();

	/*function submit($caption) {
		
		$database = "if16_greg_4";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("INSERT INTO submissions (caption) values (?)");
		
		echo $mysqli->error;
		// s -string
		// i - int
		// d- double
		//
		$stmt->bind_param("s", $caption);
		
		
		if ($stmt->execute()) {
			echo "<span style='background: #000000;font-size: 250%;color: green'>Your post was submitted successfully</span>";
		} else {
			echo "<span style='background: #000000;font-size: 250%;color: red'>There was an error submitting your post</span>";//.$stmt->error;
		}
	}*/
	
	
	
	function getAllPeople($srch,$filter) {
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		
		
		
				
		$allowedFilter = ["asc", "desc"];
		
		
		if(!in_array($filter, $allowedFilter)) {
			$filter = "asc";
		}
		
		
		
		
		
		
		
		
		if ($srch != "") {
			echo "otsin: ".$srch;
			
			$stmt = $mysqli->prepare("
			SELECT id, caption, imgurl
			FROM submissions
			where deleted is null
			AND caption like ?
			order by date $filter
			
		");
		
		$searchWord = "%".$srch."%";
		
		$stmt->bind_param("s", $searchWord);

		} else {
			$stmt = $mysqli->prepare("
			SELECT id, caption, imgurl
			FROM submissions
			where deleted is null
			order by date $filter
			
		");
		}
		
		$stmt->bind_result($id, $caption, $imgurl);
		
		
		
		
		
		
		
		
		
		if ($srch == "") { 
			
			$stmt = $mysqli->prepare("
				SELECT id,caption,imgurl
				FROM submissions WHERE deleted is NULL
				order by date $filter
			
			");
			
		}
		$stmt->bind_result($id,$caption,$imgurl);
		$stmt->execute();
		
		
		
		
		$results = array();
		
		//tsükeldab nii mitu korda kui mitu rida SQL lausega tuleb
		while ($stmt->fetch()) {
			
			$human = new StdClass();
			$human->id = $id;
			$human->caption = $caption;
			$human->imgurl = $imgurl;
			
			array_push($results, $human);
			
		}
		
		return $results;
		
	}
	
	function cleanInput($input) {
		
		return htmlspecialchars(stripslashes(trim($input)));
		
	}
	
	function deleteSubmission($deleteid) {
		
		$database = "if16_greg_4";

				
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		
		
		$stmt = $mysqli->prepare("UPDATE submissions SET deleted=NOW() WHERE id=? ");
		$stmt->bind_param("i", $deleteid);
		
		// kas õnnestus salvestada
		if($stmt->execute()){
			// õnnestus
			
			//nt echo
		}
		
		
		
	}
	
	
	
	
	
	
	/**function getSinglePerosonData($edit_id){
    
        $database = "if16_greg_4";

		//echo "id on ".$edit_id;
		
		$stmt = $mysqli->prepare("SELECT age, color FROM whistle WHERE id=?");

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
			// ei saanud rida andmeid kätte
			// sellist id'd ei ole olemas
			// see rida võib olla kustutatud
			header("Location: data.php");
			exit();
		}
		
		$stmt->close();
		
		return $p;
		
	}**/






/*
	
	function sum($x, $y) {
		
		return $x + $y;
		
	}
	
	echo sum(132, 145);
	echo "<br>";
	
	
	
	
	function hello($firstname, $lastname) {
		
		return "Tere tulemast ".$firstname." ".$lastname."!";
		
	}
	
	echo hello("Greg","N");

*/



?>