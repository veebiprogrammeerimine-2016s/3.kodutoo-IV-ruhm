<?php
class User {

	private $connection;

	function __construct($mysqli){

		$this->connection = $mysqli;

	}

	function signup($email, $password) {

			$stmt = $this->connection->prepare("INSERT INTO user_sample (email, password) VALUE (?, ?)");
			echo $this->connection->error;

			$stmt->bind_param("ss", $email, $password);

			if ($stmt->execute() ){
				echo "õnnestus";
			} else {
				echo "ERROR".$stmt->error;
			}
		}

	function login($email, $password) {

		$notice = "";

			$stmt = $this->connection->prepare("SELECT id, email, password, created FROM user_sample WHERE email = ?");

			echo $this->connection->error;

			$stmt->bind_param("s", $email);

			$stmt->bind_result($id, $emailFromDb, $passwordFromDb, $created);

			$stmt->execute();

			if($stmt->fetch()) {

				$hash = hash("sha512", $password);
				if ($hash == $passwordFromDb){
					echo "Kasutaja $id logis sisse";

					$_SESSION["userId"] = $id;
					$_SESSION["userEmail"] = $emailFromDb;

					header("Location: data.php");

					} else {
						$notice = "Vale parool!";
				}
			} else {

				$notice = "Sellise emailiga ".$email." kasutajat ei ole olemas";
			}

			return $notice;


	}




}
?>
