<?php

require("../../config.php");
require("functions.php");

echo date("d.m.Y");

$age = "";
$gender = "";
$color = "";

$ageError = "";
$genderError = "";
$colorError = "";

//$searching = "r";
//kui ei ole kasutaja id'd
if (!isset($_SESSION["userId"])){
	//suunan sisselogimise lehele
	header("Location: login.php");	
	exit();
}

//kui on ?logout aadressireal siis login välja
if (isset($_GET["logout"])) {
	session_destroy();
	header("Location: login.php");
	exit();
}

if(isset($_POST["age"])){
	if(empty( $_POST["age"])){
		$ageError = "See väli on kohustuslik";
	}else{
		$_POST["age"] = cleanInput($_POST["age"]);
		$age = $_POST["age"];
		}
} 

if(isset($_POST["gender"])){
	if(empty($_POST["gender"])){
		$genderError = "See väli on kohustuslik";
	} else {
		$_POST["gender"] = cleanInput($_POST["gender"]);
		$gender = $_POST["gender"];
	}
}

if(isset($_POST["color"])){
	if(empty($_POST["color"])){
		$colorError = "See väli on kohustuslik";
	} else {
		$_POST["color"] = cleanInput($_POST["color"]);
		$color = $_POST["color"];
	}
}

if (isset($_POST["age"]) && isset($_POST["gender"]) && isset($_POST["color"]) &&
!empty($_POST["age"]) && !empty($_POST["gender"]) && !empty($_POST["color"]))
	{
		work($_SESSION["userName"], $age, $gender, $color);
	}



	// sorteerib
if(isset($_GET["sort"]) && isset($_GET["direction"])){
	$sort = $_GET["sort"];
	$direction = $_GET["direction"];
}else{
	// kui ei ole määratud siis vaikimis id ja ASC
	$sort = "id";
	$direction = "ascending";
}


//kas kasutaja otsib
if(isset($_GET["searching"])){
	$searching = cleanInput($_GET["searching"]);
		$workData = getwork($searching, $sort, $direction);
	} else {
		$searching = "";
		$workData = getwork($searching, $sort, $direction);
}


?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/bootstrap-theme.min.css">

	<script type="text/javascript" src="js/jquery-1.11.3.js">
		function updateClock (){
			var currentTime = new Date ( );
			var currentHours = currentTime.getHours ();
			var currentMinutes = currentTime.getMinutes ();
			var currentSeconds = currentTime.getSeconds();
			currentMinutes = ( currentMinutes < 10 ? "0" : "" ) + currentMinutes;
			currentSeconds = ( currentSeconds < 10 ? "0" : "" ) + currentSeconds;
			var timeOfDay = '';

			var currentTimeString = currentHours + ":" + currentMinutes + ':' + currentSeconds+ " " + timeOfDay;

			document.getElementById("clock").innerHTML = currentTimeString;
		}
	</script>


</head>
<style type="text/css">
	#clock {color:black;}
</style> <br>

<body  onLoad="updateClock(); setInterval('updateClock()', 1000 )">
<span id="clock">&nbsp;</span>

<p>Tere tulemast <?=$_SESSION["firstName"];?> <?=$_SESSION["lastName"];?>!</p>
<p>Kasutajanimi: <a href="user.php"><?=$_SESSION["userName"];?></a></p>
<p>E-mail: <?=$_SESSION["userEmail"];?></p>
<p>Sugu: <?=$_SESSION["gender"];?></p>
<a class="btn btn-success" href="?logout=1">Logi välja</a>  <br> <br>

	<h1>Sisesta andmed:</h1>


<form method="POST">

<h3>Sisesta looma vanus</h3>
	<input name="age" placeholder="Vanus" type="number" value="<?=$age;?>"> <?=$ageError; ?> <br><br>

<h3>Sisesta looma sugu</h3>

	<input name="gender" placeholder="Sugu" type="text" value="<?=$gender;?>"> <?=$genderError; ?> <br><br>
	
<h3>Sisesta looma värvus</h3>
	
	<input name="color" placeholder="Värv" type="text" value="<?=$color;?>" > <?=$colorError; ?> <br><br>


<input type="submit" class="btn btn-success" value="Sisesta">

</form>



<br><br>
<form>
	<input type="search" name="searching" value="<?=$searching;?>">
	<input type="submit" class="btn btn-success" value="Otsi">
</form>

<br><br>

<?php
	$direction = "ascending";
	if (isset($_GET["direction"])){
		if ($_GET["direction"] == "ascending"){
			$direction = "descending";
		}
	}

$html = "<table class='table table-striped table-bordered'>";

$html .= "<tr>";
$html .= "<th>
						<a href='?searching=".$searching."&sort=id&direction=".$direction."'>
							id
						</a>
					</th>";
$html .= "<th>
						<a href='?searching=".$searching."&sort=age&direction=".$direction."'>
							Vanus
						</a>
					</th>";
$html .= "<th>
						<a href='?searching=".$searching."&sort=gender&direction=".$direction."'>
							Sugu
						</a>
					</th>";
$html .= "<th>
						<a href='?searching=".$searching."&sort=color&direction=".$direction."'>
							Värvus
						</a>
					</th>";

	$html .="</tr>";
	
	foreach($workData as $m) {
	
	$html .="<tr>";
		$html .= "<td>".$m->id."</td>";
		$html .= "<td>".$m->age."</td>";
		$html .= "<td>".$m->gender."</td>";
		$html .= "<td>".$m->color."</td>";
		$html .= "<td><a class=\"btn btn-success\" href='edit.php?id=".$m->id."'>Muuda</a></td>";
	$html .="</tr>";
	
	}
$html .="</table>";
echo $html;

?>


</html>
