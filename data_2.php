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

// otsib
	if (isset($_GET["q"])) {
		$q = $_GET["q"];
	}	else {
		$q = "";
	}
//vaikimisi, kui keegi mingit linki ei vajuta
	$sort = "duration";
	$order = "ASC";
	
	if (isset($_GET["sort"]) && isset($_GET["order"])) {
		$sort = $_GET["sort"];
		$order = $_GET["order"];
	}


$players = $Event->getAllPlayers($q, $sort, $order);


?>

<?php require("header.php"); ?>
	<h1>Tere tulemast, <?=$_SESSION["userEmail"];?>!</h1>
	<a href="?logout=1">logi valja</a>
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
	<h2>Arhiiv</h2>
	<form>
		<input type="search" name="q" value="<?=$q;?>">
		<input type="submit" value="Otsi">
	</form>
	
	<h2>BFM laua broneeringud</h2>
	
	<?php 

	$html = "<div class='row'> <div class='col-sm-4 col-md-4'> <table class='table table-striped'>";
	$html .= "<tr>";
		

	$html .= "<th>ID</th>";
	$html .= "<th>Laud</th>";

	$orderDuration = "ASC";
	if (isset($_GET["order"]) &&
		$_GET["order"] == "ASC" &&
		$_GET["sort"] == "duration") {

		$orderDuration = "DESC";
	}
	$html .= "<th>
	<a href='?q=".$q."&sort=duration&order=".$orderDuration."'>__Algusaeg</a>
	</th>";

	$orderend_Duration = "ASC";
	if (isset($_GET["order"]) &&
		$_GET["order"] == "ASC" &&
		$_GET["sort"] == "duration") {

		$orderend_Duration = "DESC";
	}
	$html .= "<th>
	<a href='?q=".$q."&sort=end_duration&order=".$orderend_Duration."'>__Lõpp</a>
	</th>";
	$html .= "<th>Edit</th>";
	$html .= "</tr>";

	foreach ($players as $p) {
	
		if ($p->place == "bfm") {
			$html .= "<tr>";
			$html .= "<td>".$p->id."</th>";
			$html .= "<td>".$p->place."</th>";
			$html .= "<td>".$p->duration."</th>";
			$html .= "<td>".$p->end_duration."</th>";
			$html .= "<td><a class= 'btn btn-default btn-xs' href='edit_2.php?id=".$p->id."'><span class ='glyphicon glyphicon-pencil'> </span> edit</a></td>";
			$html .= "</tr>";
		}

	}
	$html .= "</table>";		

	echo $html;

	?>

	<h2>Astra laua broneeringud</h2>
	
	<?php 

	$html = "<div class='row'> <div class='col-sm-4 col-md-4'> <table class='table table-striped'>";
	$html .= "<tr>";
		

	$html .= "<th>ID</th>";
	$html .= "<th>Laud</th>";

	$orderDuration = "ASC";
	if (isset($_GET["order"]) &&
		$_GET["order"] == "ASC" &&
		$_GET["sort"] == "duration") {

		$orderDuration = "DESC";
	}
	$html .= "<th>
	<a href='?q=".$q."&sort=duration&order=".$orderDuration."'>__Algusaeg</a>
	</th>";

	$orderend_Duration = "ASC";
	if (isset($_GET["order"]) &&
		$_GET["order"] == "ASC" &&
		$_GET["sort"] == "duration") {

		$orderend_Duration = "DESC";
	}
	$html .= "<th>
	<a href='?q=".$q."&sort=end_duration&order=".$orderend_Duration."'>__Lõpp</a>
	</th>";
	$html .= "<th>Edit</th>";
	$html .= "</tr>";

	foreach ($players as $p) {
	
		if ($p->place == "astra") {
			$html .= "<tr>";
			$html .= "<td>".$p->id."</th>";
			$html .= "<td>".$p->place."</th>";
			$html .= "<td>".$p->duration."</th>";
			$html .= "<td>".$p->end_duration."</th>";
			$html .= "<td><a class= 'btn btn-default btn-xs' href='edit_2.php?id=".$p->id."'><span class ='glyphicon glyphicon-pencil'> </span> edit</a></td>";
			$html .= "</tr>";
		}

	}
	$html .= "</table>";

	echo $html;

	?>

<?php require("footer.php"); ?>