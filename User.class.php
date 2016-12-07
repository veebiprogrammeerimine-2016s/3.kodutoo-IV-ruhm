<?php
class User {
	
	private $connection;
	

	function __construct($mysqli){
		
		$this->connection = $mysqli;
		
	}
	
	function signup($email, $password, $gender, $birthdate) {
			
			$stmt = $this->connection->prepare("INSERT INTO mvp_user (email, password, gender, birthdate) VALUE (?, ?, ?, ?)");
			echo $this->connection->error;
			
			$stmt->bind_param("ssss", $email, $password, $gender, $_POST["birthdate"]);
			
			if ($stmt->execute() ){
				echo "õnnestus";
			} else {
				echo "ERROR".$stmt->error;
			}
		}
	
	function login($email, $password) {
		
		$notice = "";
		
			$stmt = $this->connection->prepare("SELECT id, email, password, created, gender, birthdate FROM mvp_user WHERE email = ?");
			
			echo $this->connection->error;
			
			$stmt->bind_param("s", $email);
			
			$stmt->bind_result($id, $emailFromDb, $passwordFromDb, $created, $gender, $birthdate);
			
			$stmt->execute();
			
			if($stmt->fetch()) {
				
				$hash = hash("sha512", $password);
				if ($hash == $passwordFromDb){
					echo "Kasutaja $id logis sisse";
					
					$_SESSION["userId"] = $id;
					$_SESSION["userEmail"] = $emailFromDb;
					
					header("Location: data.php");
					
					} else {
						$notice = "parool vale";
				}
			} else {
				
				$notice = "Sellise emailiga ".$email." kasutajat ei ole olemas";
			}
			
			return $notice;
			
		
	}
	
	
	
	
}
?>