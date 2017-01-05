<?php 

require("functions_2.php");
require("Helper.class.php");
$Helper = new Helper($mysqli);
require("Event.class.php");
$Event = new Event($mysqli);

$place = "";
$duration = "";	
$end_duration = "";
$placeError = "";
$durationError = "";	
$end_durationError = "";

	// kui ei ole sisse loginud, suunan login lehele
	if (!isset($_SESSION["userid"])) {
		header("Location: login_2.php");
	}

	if (isset($_GET["logout"])) {
		session_destroy();
		header("Location: login_2.php");
		exit();
	}



	// var_dump($_POST);
	if (isset($_POST['place'])&&
		isset($_POST['duration']) &&
		isset($_POST['end_duration']) ) {
		if (!empty($_POST['duration'])&&
			!empty($_POST['end_duration']) ) {
		
			$Event->saveEvent($Helper->cleanInput($_POST['place']), $_POST['duration'], $_POST['end_duration']);
		}
		echo "Vali laud ja aeg";		
		//header("Location: login_2.php");
		//exit();
		}

	$players = $Event->getAllPlayers();


 ?>
<!DOCTYPE html>
<html>
<head>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</head>
<body>



 <h1></h1>
 	<p>
 		Tere tulemast, <?=$_SESSION["userEmail"];?>!
 		<a href="?logout=1">logi valja</a>
 	</p>

<br><br>
 
 <form method="POST">
	<h1>Vali laud</h1>
	<select name="place">
		<option value="astra">Astra maja</option>
		<option value="bfm">BFM maja</option>
	</select>
<br><br>
	<h1>Vali alguse aeg</h1>
	<input type="time" placeholder="sisesta vahemik" name="duration">
<br><br>
	<h1>Vali lõpu aeg</h1>
	<input type="time" placeholder="sisesta vahemik" name="end_duration">
<br><br>
	<input type="submit" value="salvesta">
</form>

<br><br>

	<h2>BFM laua broneeringud</h2>
	
	<?php 

		$html = "<table>";
			$html .= "<tr>";
				$html .= "<th>Laud</th>";
				$html .= "<th>algusaeg</th>";
				$html .= "<th>lõpp</th>";
			$html .= "</tr>";

			foreach ($players as $p) {

				if ($p->place == "bfm") {
					$html .= "<tr>";
						$html .= "<td>".$p->place."</th>";
						$html .= "<td>".$p->duration."</th>";
						$html .= "<td>".$p->end_duration."</th>";
					$html .= "</tr>";
				}

			}
		$html .= "</table>";		

		echo $html;

	 ?>

	 <h2>Astra laua broneeringud</h2>
	
	<?php 

		$html = "<table>";
			$html .= "<tr>";
				$html .= "<th>Laud</th>";
				$html .= "<th>algusaeg</th>";
				$html .= "<th>lõpp</th>";
			$html .= "</tr>";

			foreach ($players as $p) {

				if ($p->place == "astra") {
					$html .= "<tr>";
						$html .= "<td>".$p->place."</th>";
						$html .= "<td>".$p->duration."</th>";
						$html .= "<td>".$p->end_duration."</th>";
					$html .= "</tr>";
				}

			}
		$html .= "</table>";		

		echo $html;

	 ?>


</body>
</html>