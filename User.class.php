<?php 
class User {
	
	private $connection;
	
	// käivitatakse siis kui on = new User(see jõuab siia)
	function __construct($mysqli) {
		$this->connection = $mysqli;
	}
	
		function signup($email, $password, $sugu, $auto) {
		
				 
				 $stmt = $this->connection->prepare("INSERT INTO kodutoo_KrisTarn (email, password, sugu, lemmikauto) VALUE (?, ?, ?, ?) ");
				 
				 //asendan küsimärgid
				 //iga märgi kohta tuleb lisada üks täht - mis tüüpi muutuja on
				 // s - string
				 // i - int
				 // d - double
				 $stmt->bind_param("ssss", $email, $password, $sugu, $auto);
				 //t'ida käsku
				 if( $stmt->execute()){
					 echo "õnnestus";
				 } else {
						echo "<br>"."ERROR: ".$stmt->error;
					 
				 }	
		
	}
	
	function login($email, $password) {
	
				 $stmt = $this->connection->prepare("
				  
					SELECT id, email, password, sugu, Lemmikauto, created
					FROM kodutoo_KrisTarn
					WHERE email = ?
					
				 ");
				 
				 echo $this->connection->error;
				 
				 $stmt->bind_param("s", $email);
				
				//rea kohta tulba väärtus
				$stmt->bind_result($id, $emailFromDb, $passwordFromDb, $suguFromDb, $autoFromDb, $created);
				
				$stmt->execute();
				
				//ainult SELECT'i puhul
				if($stmt->fetch()){
					//oli olemas, rida käes
					//kasutaja sisestas sisselogimiseks
					$hash = hash("sha512", $password);
					
					if ($hash == $passwordFromDb) {
						
						//oli sama
						echo"Kasutaja $id logis sisse";
						
						$_SESSION["userId"] = $id;
						$_SESSION["userEmail"] = $emailFromDb;
						
						header("Location: data.php");
						
					} else {
						
						//polnud sama
						$notice ="sitt parool";
						
					}
					
				} else {
					
					//ei olnud ühtegi rida
					$notice = "Sellise emailiga: ".$email."kasutajat ei ole olemas.";
				}
				return $notice;
	}
	
	
	}
?>