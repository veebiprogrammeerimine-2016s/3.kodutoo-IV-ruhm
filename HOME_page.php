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
	
	//SALVESTAMINE
	{
	comment($companyname, $feedback, $_POST["rating"]);
	}
	$people = restaraunt();
?>

<html>
<body>
<head>
<style>

	table {
		border-collapse: collapse;
		width: 30%;
	}

	th, td {
		text-align: left;
		padding: 8px;
	}

	tr:nth-child(even){background-color: #f2f2f2}

	th {
		background-color: #4CAF50;
		color: white;
	}
	
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
		$html .= "<th>Account</th>";
		$html .= "<th>Visited</th>";
		$html .= "<th>Feedback</th>";
		$html .= "<th>Rating</th>";
	$html .= "</tr>";
			
	foreach ($people as $p) {
	$html .= "<tr>";
		$html .= "<td>".$p->email."</td>";
		$html .= "<td>".$p->restname."</td>";
		$html .= "<td>".$p->feedback."</td>";
		$html .= "<td>".$p->rating."</td>";	
	$html .= "</tr>";
	}
	
$html .= "</table>";

echo $html;
?>
