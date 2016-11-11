<?php
class User {
	
	private $connection;
	
	//funktsioon käivitatakse siis kui on 'new User(see jõuab siia)'
	function __construct($mysqli){
		//'this' viitab sellele klassile ja klassi muutujale
		$this->connection=$mysqli;
	}
	
	
	function signup($email, $password, $mobile, $gender) {
		
		$stmt = $this->connection->prepare("INSERT INTO user_sample (email, password, mobile, gender) values (?, ?, ?, ?)");
		
		echo $this->connection->error;
		// s -string
		// i - int
		// d- double
		//
		$stmt->bind_param("ssis", $email, $password, $mobile, $gender);
		
		
		if ($stmt->execute()) {
			echo "<span style='background: #000000;font-size: 250%;color: green'>Kasutaja $email loodi edukalt</span>";
		} else {
			
			echo "<span style='background: #000000;font-size: 250%;color: red'>Täitke kõik väljad</span>";//.$stmt->error;
		}
	}
	
	
	function login($email, $password) {

		$notice = "";
		$stmt = $this->connection->prepare("
		
		
		
		SELECT id, email, password, created
		FROM user_sample
		WHERE email = ?
		
		
		");
		
		echo $this->connection->error;
		//küsimärgi asendus
		$stmt->bind_param("s", $email);
		//rea kohta tulba väärtus
		$stmt->bind_result($id, $emailFromDb, $passwordFromDb, $created);
		
		$stmt->execute();
		//ainult selecti puhul
		if($stmt->fetch()) {
			
			$hash = hash("sha512", $password);
			
			if ($hash == $passwordFromDb) {
				echo "kasutaja $id logis sisse";
				
				$_SESSION["userId"] = $id;
				$_SESSION["userEmail"] = $emailFromDb;
				
				header("Location: data.php");
				exit();
			}
			else {
					
					$notice = "Sisestasite parooli valesti";
				}
			//oli olemas rida käes
			
		} else{
			
			
			//ei olnud ühtegi rida
			$notice = "Emailiga $email kasutajat ei eksisteeri andmebaasis";
			
		}
		
		return $notice;
		
	}
	
}
?>