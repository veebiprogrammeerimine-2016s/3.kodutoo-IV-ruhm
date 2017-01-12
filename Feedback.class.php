<?php
class Feedback {

	private $connection;

	function __construct($mysqli){

		$this->connection = $mysqli;

	}

		function saveFeedback($points, $color, $address) {

			$stmt = $this->connection->prepare("INSERT INTO tagasiside (points, color, address) VALUE (?, ?, ?)");
			echo $this->connection->error;

			$stmt->bind_param("iss", $points, $color, $address);

			if ($stmt->execute() ){
				echo "õnnestus";
			} else {
				echo "ERROR".$stmt->error;
			}
		}

		function getAllFeedbacks ($f, $sort, $order){

			$allowedSort = ["id", "points", "color", "address"];

			if(!in_array($sort, $allowedSort)){
            $sort = "id";
        }
        $orderBy = "ASC";
        if($order == "DESC") {
            $orderBy = "DESC";
        }
        echo "Sorteerin: ".$sort." ".$orderBy." ";

			if ($f != "") {

			echo "otsin: ".$f;

				$stmt = $this->connection->prepare("SELECT id, points, color, address FROM tagasiside WHERE deleted IS NULL AND ( points LIKE ? OR color LIKE ? OR address like ? ) ORDER BY $sort $orderBy");
				$searchWord = "%".$f."%";
				$stmt->bind_param("sss", $searchWord, $searchWord, $searchWord);

			} else {

				$stmt = $this->connection->prepare("SELECT id, points, color, address FROM tagasiside WHERE deleted IS NULL ORDER BY $sort $orderBy");
					}
			$stmt->bind_result($id, $points, $color, $address);
			$stmt->execute();

			$results = array();
			// Tsükli sisu tehake nii mitu korda, mitu rida SQL lausega tuleb
			while($stmt->fetch()) {
				//echo $color."<br>";
				$upcomingFeedback= new StdClass();
				$upcomingFeedback->id = $id;
				$upcomingFeedback->points = $points;
				$upcomingFeedback->color = $color;
				$upcomingFeedback->address = $address;

				array_push($results, $upcomingFeedback);
			}

			return $results;
		}

		function getSingleFeedbackData($edit_id){

		$stmt = $this->connection->prepare("SELECT points, color, address FROM tagasiside WHERE id=? AND deleted IS NULL");
		$stmt->bind_param("i", $edit_id);
		$stmt->bind_result($points, $color, $address);
		$stmt->execute();


		$f = new Stdclass();


		if($stmt->fetch()){

			$f->points = $points;
			$f->color = $color;
			$f->address = $address;


		}else{

			header("Location: data.php");
			exit();
		}

		$stmt->close();


		return $f;

	}

	function updateFeedback($id, $points, $color, $address){


		$stmt = $this->connection->prepare("UPDATE tagasiside SET points=?, color=?, address=? WHERE id=? AND deleted IS NULL");
		$stmt->bind_param("issi",$points, $color, $address, $id);


		if($stmt->execute()){

			echo "salvestus õnnestus!";
		}

		$stmt->close();


	}
	function deleteFeedback($id){

		$stmt = $this->connection->prepare("UPDATE tagasiside SET deleted=NOW() WHERE id=? AND deleted IS NULL");
		$stmt->bind_param("i",$id);


		if($stmt->execute()){

			echo "kustutamine õnnestus!";
		}

		$stmt->close();


	}



}

?>
