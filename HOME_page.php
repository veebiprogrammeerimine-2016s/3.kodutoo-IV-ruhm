<?php
	
	require("functions.php");
	require("style.php");
	
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
<head>
	<style>
	
		table {
			border-collapse: collapse;
			width: 100%;
			background-color: white;
		}

		th, td {
			text-align: left;
			padding: 8px;
			border: 1px solid white;
		}

		tr:nth-child(even){
			background-color: black;
			color:white;
		}

		th {
			background-color: #AA7CFF;
			color: black;
		}
	
		body {
			margin: 0;
			background-color: black;
			}
		
		ul {
			list-style-type: none;
			margin: 0;
			padding: 0;
			width: 25%;
			background-color: white;
			position: fixed;
			height: 100%;
			overflow: auto;
		}

		li a {
			display: block;
			color: #000;
			padding: 12px 4px;
			text-decoration: none;
		}

		li a:hover:not(.active) {
			background-color: #AA7CFF;
			color: white;
		}
		
		input[type=text] {
			width: 100%;
			box-sizing: border-box;
			border: 2px solid black;
			border-radius: 4px;
			font-size: 16px;
			background-color: white;
			background-image: url('img/searchbutton.png');
			background-position: 4px 6px; 
			background-repeat: no-repeat;
			padding: 12px 20px 12px 40px;
		}
		
		h2 {
			font-family: "Lucida Console", "Lucida Sans Typewriter", monaco, "Bitstream Vera Sans Mono", monospace;
			font-size: 24px;
			font-style: normal;
			font-variant: normal;
			font-weight: 500;
			line-height: 26.4px;
			color: white;
		}
		
		h1 {
			font-family: "Lucida Console", "Lucida Sans Typewriter", monaco, "Bitstream Vera Sans Mono", monospace;
			font-size: 24px;
			font-style: normal;
			font-variant: normal;
			font-weight: 500;
			line-height: 26.4px;
			color: white;
		}
		
		h3 {
			font-family: "Lucida Console", "Lucida Sans Typewriter", monaco, "Bitstream Vera Sans Mono", monospace;
			font-size: 14px;
			font-style: normal;
			font-variant: normal;
			font-weight: 500;
			line-height: 15.4px;
			color: white;
		}
		
		p {
			font-family: "Lucida Console", "Lucida Sans Typewriter", monaco, "Bitstream Vera Sans Mono", monospace;
			font-size: 14px;
			font-style: normal;
			font-variant: normal;
			font-weight: 400;
			line-height: 20px;
		}
		
		a {
		color: white;
		}
	
	</style>
</head>

<body>
	
	<ul>
		<li><a href="HOME_page.php"> <img src="img/home.png"> Home </a></li>
		<li><a href="newtred.php"> <img src="img/newtred.png"> New post </a></li>
		<li><a href="user_page.php"> <img src="img/account.png"> My account </a></li>
		<li><a href="?logout=1"> <img src="img/logout.png"> Log out</a></li>
		
		<form>
		<input type="text" name="q" value="<?=$q;?>" placeholder="Search place">
		</form>
	</ul>
	
<div style="margin-left:25%;padding:1px 16px;height:1000px;">

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

</div>
</body>
</html>
