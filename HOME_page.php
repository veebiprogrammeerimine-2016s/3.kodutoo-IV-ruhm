<?php
	
	require("functions.php");

	//MUUTUJAD
	$companyname = $feedback = "";
	//MUUTUJAD ERROR
	$companynameerror = $feedbackerror = "";
	
	if (!isset ($_SESSION["userEmail"])) {
		header("Location: HOME_page.php");
		exit();	
	}
	
	//LOG OUT
	if (isset($_GET["logout"])) {
		session_destroy();
		header("Location: MAIN_page.php");
		exit();
	}
	
	//TAGASISIDE KOMMENTAAR
	//RESTARAUNT/CAFE NAME
	if (isset ($_POST["companyname"])) {
		if (empty ($_POST["companyname"])) {
		$companynameerror = "* Väli on kohustuslik!";
		} else {
		$companyname = $_POST["companyname"];
		}
	}
	
	//FEEDBACK
	if (isset ($_POST["feedback"])) {
		if (empty ($_POST["feedback"])) {
		$feedbackerror = "* Väli on kohustuslik!";
		} else {
		$feedback = $_POST["feedback"];
		}
	}
	
	//KUI KÕIK ON OKEI
	if (isset ($_POST["companyname"]) &&
		isset ($_POST["feedback"])  &&
		!empty ($_POST["companyname"]) &&
		!empty ($_POST["feedback"])
		)
	
	//SALVESTAMINE KOMMENTAARI
	{
	comment($companyname, $feedback, $_POST["rating"]);
	}
	
	//SORTEREERIMINE JA OTSING
	if (isset($_GET["q"])) {
		$q = $_GET["q"];
	
	} else {
		//otsing ei toimu
		$q = "";
	}
	//Kui midagi pole vajutatud
	$sort = "kasutaja";
	$order = "ASC";
	
	if (isset($_GET["sort"]) && isset($_GET["order"])) {
		$sort = $_GET["sort"];
		$order = $_GET["order"];
	}
	
	$people = restaraunt($q, $sort, $order);
	
?>

<html>
<body>
<head>
	
	<style>
	
		table {
			border-collapse: collapse;
			width: 30%;}

		th, td {
			text-align: left;
			padding: 8px;}

		tr:nth-child(even){background-color: #f2f2f2}

		th {
			background-color: #4CAF50;
			color: white;}
	
	</style>
	
</head>
Tere tulemast <?=$_SESSION["userEmail"];?>!
<a href="?logout=1">Logi välja</a>
<br><input type="button" onClick="location.href='user_page.php'" value="Minu kasutaja"></br>


	<h2>Leave your feedback</h2>
	<form method="POST">
	
	<!--RESTARAUNT NAME-->
	<label for="companyname">Company name(what u visited):</label><br>
	<input placeholder="" name="companyname">
	<?php echo $companynameerror;?>
	<br>
	
	<!--FEEDBACK-->
	<label for="feedback">Your feedback:</label><br>
	<textarea rows="4" cols="30" placeholder="" name="feedback"></textarea>
	<?php echo $feedbackerror;?>
	
	<!--RATING-->
	<p><label for="rating">Rate by 5 stars:</label>
	<select name = "rating"  id="rating" required>
		<option value="">How many stars</option>
		<option value="5">5</option>
		<option value="4">4</option>
		<option value="3">3</option>
		<option value="2">2</option>
		<option value="1">1</option>
	</select>
	
	<br><input type="submit" value="Send your comment"></br>
	
	</form>
	
	
</body>
</html>
<?php 
//TABELI STRUKTUUR	
$html = "<table>";
	
	$html .= "<tr>";
	
	 //ORDER BY KASUTAJA
	$orderkasutaja = "ASC";
	if (isset($_GET["order"]) &&
		$_GET["order"] == "ASC" &&
		$_GET["sort"] == "kasutaja"){
			$orderkasutaja = "DESC";
		}
	
		$html .= "<th><a href='?q=".$q."&sort=kasutaja&order=".$orderkasutaja."'>Kasutaja</a></th>";
	
	//ORDER BY VISITED
	$ordervisited = "ASC";
	if (isset($_GET["order"]) &&
		$_GET["order"] == "ASC" &&
		$_GET["sort"] == "restname")
		{$ordervisited = "DESC";}
		$html .= "<th><a href='?q=".$q."&sort=restname&order=".$ordervisited."'>Visited</a></th>";
	
	//ORDER BY FEEDBACK
	$orderfeedback = "ASC";
	if (isset($_GET["order"]) &&
		$_GET["order"] == "ASC" &&
		$_GET["sort"] == "feedback")
		{$orderfeedback = "DESC";}
		$html .= "<th><a href='?q=".$q."&sort=feedback&order=".$orderfeedback."'>Feedback</a></th>";
	
	//ORDER BY RATING
	$orderrating = "ASC";
	if (isset($_GET["order"]) &&
		$_GET["order"] == "ASC" &&
		$_GET["sort"] == "rating")
		{$orderrating = "DESC";}
		$html .= "<th><a href='?q=".$q."&sort=rating&order=".$orderrating."'>Rating</a></th>";
	
	$html .= "</tr>";
	
	foreach ($people as $p) {
	$html .= "<tr>";
		$html .= "<td>".$p->kasutaja."</td>";
		$html .= "<td>".$p->restname."</td>";
		$html .= "<td>".$p->feedback."</td>";
		$html .= "<td>".$p->rating."</td>";	
	$html .= "</tr>";
	}
	
$html .= "</table>";

echo $html;
?>
