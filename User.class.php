<?php
class User {
	private $connection;

	//käivitatakse siis, kui functions.php-s öeldakse new User, siis see jõuab siia
	function __construct($mysqli){
		// $this viitab selle classi muutujale
	
		$this->connection = $mysqli;

	}

// KÕIK FUNKTSIOONID

function login($email, $password) 
	{
		$notice = "";

		$stmt = $this->connection->prepare("
			SELECT id, email, password
			FROM mvp_161006
			WHERE email = ?");

		echo $this->connection->error;

		$stmt->bind_param("s", $email);
		$stmt->bind_result($id, $emailFormDb, $passwordFormDb);
		$stmt->execute();

		if ($stmt->fetch()) {
			$hash = hash ("sha512", $password);
			if ($hash == $passwordFormDb) {
				echo "kasutaja $id logis sisse";
				$_SESSION["userid"] =$id;
				$_SESSION["userEmail"] =$emailFormDb;
				header("Location: data_2.php");
				exit();
			} else {
				$notice = "parool on vale";
			} 
		} else {
			$notice = "sellise emailiga  ".$email."kasutajat ei ole olemas";
		}
		return $notice;
	}
	
function signup($email, $password) 
	{
		$stmt = $this->connection->prepare("
			INSERT INTO mvp_161006 (email, password) 
			VALUES (?, ?)");
		$stmt ->bind_param("ss", $email, $password);

		if ($stmt->execute() ) {
			echo "õnnestus";
		} else {
			echo "ERROR ".$stmt->error;
		}
	}

}
?>